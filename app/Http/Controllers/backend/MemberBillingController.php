<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberComp;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\PaymentEmail;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;

class MemberBillingController extends Controller
{
    public function billing(Request $request)
    {
        if (!Auth::user()->can('invoices-view')) {
            abort(403, "You have not permission to view member invoices. Close this window.");
            die;
        }

        if (isset($request->pid) && !empty($request->pid)) {
            $pid = $request->pid;
            $companyName = MemberComp::find($request->pid)->d_compname ?? null;

            // BranchAdmin case
            if (Auth::user()->hasRole('BranchAdmin')) {
                // Use Eloquent with relationships and subquery for the 'BranchAdmin' case
                $invoices = Order::with('memberComp', 'orderStatus') // Assuming an order belongs to a memberComp
                    ->whereHas('memberComp', function ($query) use ($pid) {
                        $query->where('did', $pid)
                            ->whereHas('member', function ($subQuery) {
                                $subQuery->where('m_branch', Auth::user()->branchid);
                            });
                    })
                    ->orderBy('oid', 'asc')
                    ->get();
            }
            // Admin access case
            else if (chkAdminAccess() == 1) {
                // Fetch invoices for Admins using Eloquent
                $invoices = Order::with('memberComp', 'orderStatus')
                    ->whereHas('memberComp', function ($query) use ($pid) {
                        $query->where('did', $pid);
                    })
                    ->orderBy('oid', 'asc')
                    ->get();
            } else {
                // Abort if the user has no access
                abort(403, "No record / no permission. Close this window.");
                die;
            }
        } else {

            die("Invalid data. Close this window.");
            exit();
        }

        return view('backend.members.invoices', compact('invoices', 'companyName'));
    }

    public function invoiceView(Request $request)
    {
        if (!Auth::user()->can('invoices-view')) {
            abort(403, "You have not permission to view member invoices. Close this window.");
            die;
        }

        // Ensure required parameter exists
        if (!Auth::check() || !$request->has('bid')) {
            abort(403, "Invalid request.");
        }

        // Fetch the order and member_comp data
        $order = Order::find($request->bid);
        if (!$order) {
            abort(404, "Order not found.");
        }

        // Check user role and fetch data based on role
        $transaction = null;
        if (Auth::user()->hasRole('BranchAdmin')) {
            $transaction = MemberComp::where('did', $order->order_mid)->first();
        } else if (chkAdminAccess() == 1) {
            $transaction = MemberComp::where('did', $order->order_mid)->first();
        } else {
            abort(403, "You do not have permission to access this page.");
        }

        if (!$transaction) {
            abort(404, "Member company details not found.");
        }

        // Prepare additional data for invoice view
        $memberDetails = getMemberToSendInv($order->order_mid);
        $fullAddress = strtoupper($transaction->d_compadd);
        $addressParts = explode(',', $fullAddress);
        $addressParts = array_filter($addressParts); // Filter empty parts

        $data = [
            'order' => $order,
            'transaction' => $transaction,
            'memberDetails' => $memberDetails,
            'addressParts' => $addressParts,
            'fullAddress' => $fullAddress
        ];

        $html = View::make('backend.members.pdf.invoice', $data)->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = config('constant.ORDERID_SET') . $order->order_no . ".pdf";
        return $dompdf->stream($filename, ['Attachment' => 0]);
    }

    public function sendInvoice(Request $request)
    {
        if (!Auth::user()->can('invoices-view')) {
            return response()->json(['status' => false, 'message' => 'You have not permission to send invoices!', 'data' => []], 403);
        }

        if(chkV($request->header('referer'))){
            // Check if 'bid' is present in the GET request
            $bid = $request->query('bid');
            if (empty($bid)) {
                return redirect()->back();
            }

            // Fetch the order
            $order = Order::find($bid);

            if (!$order) {
                return redirect()->back();
            }

            $invno = config('constant.ORDERID_SET') . $order->order_no;
            $subject = "[" . config('constant.COMP_NAME2') . "] Invoice " . $invno;
            $member = getMemberToSendInv($order->order_mid);
            $fullname = $member['fullname'];
            $email = $member['email'];
            Log::info($email);
            $html = $this->generateInvoiceHtml($order->oid);

            $filename = config('constant.ORDERID_SET').$order->order_no.".pdf";
            // $filePath = "./invoicepdf/".$filename;

            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $options->set('isHtml5ParserEnabled', true);

             // Generate PDF
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

           // Define the directory and file path
            $directoryPath = storage_path('app/public/invoices');
            $filePath = $directoryPath . '/' . $filename;

            // set from email and name
            $fromEmail = config('constant.ADMIN_EMAIL');
            $fromName = config('constant.COMP_NAME2');

            // Check if the directory exists, if not create it
            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0755, true); // 0755 permissions and true for recursive directory creation
            }

            // Save the file, overwriting it if it already exists, with exclusive lock
            file_put_contents($filePath, $dompdf->output(), LOCK_EX);

            try {
                // Send email
                Mail::to($email)->send(new PaymentEmail($invno, $fullname, $filename, $filePath, $subject,  $fromEmail, $fromName));
                return response()->json(['status' => true, 'message' => 'Email sent!']);
            } catch (\Exception $e) {
                Log::error("Email failed to send. Error: " . $e->getMessage());
                return response()->json(['status' => false, 'message' => "Email can't be send! Try again later.", 'data' => []], 400);
            }
        }
    }

    public function generateInvoiceHtml($oid)
    {
        $order = Order::find($oid);
        $transaction = MemberComp::where('did', $order->order_mid)->first();
        // Prepare additional data for invoice view
        $memberDetails = getMemberToSendInv($order->order_mid);
        $fullAddress = strtoupper($transaction->d_compadd);
        $addressParts = explode(',', $fullAddress);
        $addressParts = array_filter($addressParts); // Filter empty parts

        $data = [
            'order' => $order,
            'transaction' => $transaction,
            'memberDetails' => $memberDetails,
            'addressParts' => $addressParts,
            'fullAddress' => $fullAddress
        ];

        $html = View::make('backend.members.pdf.invoice', $data)->render();

        return $html;
    }
}
