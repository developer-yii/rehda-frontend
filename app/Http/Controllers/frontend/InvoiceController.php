<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\MemberComp;
use App\Models\MemberUserProfile;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Paymentdev;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Financial\CashFlow\Constant\Periodic\Payments;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        if(session('compid') == null){
            return redirect(route('login'));
        }

        if ($request->ajax()) {

            $membertype = getMemberType(session('compid'));
            if($membertype == 1){
                $arr = getChildMid(session('compid'));
                $orders = Order::with('orderStatus')->whereIn('order_mid', $arr)->orderBy('order_created_at', 'DESC');
            } else {
                $orders = Order::with('orderStatus')->where('order_mid', session('compid'))->orderBy('order_created_at', 'DESC');
            }

            return DataTables::eloquent($orders)
            ->addColumn('date', function ($row) {
                return '<p>'.date('d-M-Y',strtotime($row->order_created_at)).'</p><span class="badge bg-label-'.$row->orderStatus->label.'">'.$row->orderStatus->status.'</span>';
            })
            ->addColumn('invoice_no', function ($row) {
                return '#'.config('constant.ORDERID_SET').$row->order_no;
            })
            ->addColumn('amount', function ($row) {
                return config('currency.base_currency').' '.number_format($row['order_grandtotal'],2);
            })
            ->addColumn('actions', function ($row) {
                $buttons = '';

                if($row->order_status == 1) {
                    $buttons .= '<a href="'.route('invoice.paymentfpx', $row->order_no).'" target="_blank" class="btn btn-outline-primary waves-effect me-2">Pay with FPX</a>';
                    $buttons .= '<a href="'.route('invoice.paymentcard', $row->order_no).'" target="_blank" class="btn btn-outline-primary waves-effect me-2">Pay with Credit/Debit Card<br><small>+'.config('constant.CC_FEE').'% Handling Fee</small></a>';
                    $buttons .= '<a href="'.route('invoice.pdf', $row->oid).'" target="_blank" class="btn btn-outline-primary waves-effect me-2">Proforma Invoice</a>';
                } else {
                    $buttons .= '<a href="'.route('invoice.pdf', $row->oid).'" target="_blank" class="btn btn-outline-primary waves-effect me-2">Invoice</a>';
                    $buttons .= '<a href="'.route('invoice.receipt', $row->oid) .'" target="_blank" class="btn btn-outline-primary waves-effect">Receipt</a>';
                }

                return $buttons;
            })
            ->rawColumns(['date', 'actions'])
            ->toJson();
        }

        return view('frontend.invoice.index');
    }

    public function invoicePdf($id)
    {

        $membertype = getMemberType(session('compid'));
        if($membertype == 1){
            $arr = getChildMid(session('compid'));
            $order = Order::where('oid', $id)->whereIn('order_mid', $arr)->first();
        } else {

            $order = Order::where('oid', $id)->where('order_mid', session('compid'))->first();
        }

        $memberComp = MemberComp::with('state')->where('did', $order->order_mid)->first();

        $memberProfile = MemberUserProfile::where('up_mid', $order->order_mid)->where('up_usertype',2)->orderBy('up_id', 'ASC')->first();
        if(!$memberProfile) {
            $memberProfile = MemberUserProfile::where('up_mid', $order->order_mid)->where('up_usertype',1)->orderBy('up_id', 'ASC')->first();
        }

        $html = view('frontend.invoice.pdf', compact('memberComp', 'memberProfile', 'order'))->render();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = "Invoic-" . "pdf";
        return $dompdf->stream($filename, ['Attachment' => 0]);
    }

    public function invoiceReceipt($id)
    {
        $membertype = getMemberType(session('compid'));
        if($membertype == 1){
            $arr = getChildMid(session('compid'));
            $order = Order::where('oid', $id)->whereIn('order_mid', $arr)->first();
        } else {
            $order = Order::where('oid', $id)->where('order_mid', session('compid'))->first();
        }

        $memberComp = MemberComp::where('did', $order->order_mid)->first();

        $memberProfile = MemberUserProfile::where('up_mid', $order->order_mid)->where('up_usertype',2)->orderBy('up_id', 'ASC')->first();
        if(!$memberProfile) {
            $memberProfile = MemberUserProfile::where('up_mid', $order->order_mid)->where('up_usertype',1)->orderBy('up_id', 'ASC')->first();
        }

        $html = view('frontend.invoice.receiptPdf', compact('memberComp', 'memberProfile', 'order'))->render();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = "Receipt-" . "pdf";
        return $dompdf->stream($filename, ['Attachment' => 0]);
    }

    public function invoicePaymentfpx($order_no)
    {
        $order = Order::where('order_no', $order_no)->where('order_status',1)->first();
        $memberDetails = getMemberToSendInv($order->order_mid);
        return view('frontend.invoice.paymentfpx', compact('order','memberDetails'));
    }

    public function invoicePaymentcard($order_no)
    {
        $order = Order::where('order_no', $order_no)->where('order_status',1)->first();
        $memberDetails = getMemberToSendInv($order->order_mid);
        return view('frontend.invoice.paymentcard', compact('order','memberDetails'));
    }

    public function invoicePaymentsubmit(Request $request)
    {
        dd($request);
    }

    public function invoicePaymentreturn(Request $request)
    {
        if ( !empty($_REQUEST["PaymentId"]) && !empty( $_REQUEST["RefNo"] ) )
        {
            $now = date('Y-m-d H:i:s');
            $orderid = date('YmdHis')."-CC";

            $path="";
            $merchantcode = $_REQUEST["MerchantCode"];
            $paymentid = $_REQUEST["PaymentId"];
            $refno = $_REQUEST["RefNo"];
            $pamount = $_REQUEST["Amount"];
            $ecurrency = $_REQUEST["Currency"];
            $remark = $_REQUEST["Remark"];
            $transid = $_REQUEST["TransId"];
            $authcode = $_REQUEST["AuthCode"];
            $response_code = $_REQUEST["Status"];
            $errdesc = $_REQUEST["ErrDesc"];
            $signature = $_REQUEST["Signature"];
            $decrypt = "IPAY88";
            $ttype = 2; //CC

            if($response_code==1)
            {
                $result = $this->succUpdateMember($orderid, $ttype, $merchantcode, $paymentid, $refno, $pamount, $ecurrency, $remark, $transid, $authcode, $response_code, $errdesc, $signature);

                if($result == 2){
                    return redirect(route('payment.fail'));
                } else {
                    return redirect(route('payment.success'));
                }

            } else {
                $payment = Payment::create([
                    'trans_id' => $transid,
                    'authcode' => $authcode,
                    'pstatus' => $response_code,
                    'pamount' => $pamount,
                    'refno' => $refno,
                    'pymtid' => $paymentid,
                    'ecurr' => $ecurrency,
                    'remark' => $remark,
                    'errdesc' => $errdesc,
                    'sign' => $signature,
                    'pymt_dt' => $now
                ]);

                return redirect(route('payment.fail'));
            }
        } else {
            return redirect(route('payment.fail'));
        }
    }

    public function succUpdateMember($orderid,$ttype,$merchantcode,$paymentid,$refno,$pamount,$ecurrency,$remark,$transid,$authcode,$response_code,$errdesc,$signature)
    {
        $tstatus = $response_code;
        $now = date('Y-m-d H:i:s');

        $payment = Payment::where('trans_id', $transid)->where('refno', $refno)->first();

        $payments = Payment::where('trans_id', $transid)->where('refno', $refno)->where('pstatus',1)->get();

        if(count($payment) == 0) {
            $paymentInsert = Payment::create([
                'trans_id' => $transid,
                'authcode' => $authcode,
                'pstatus' => $response_code,
                'pamount' => $pamount,
                'refno' => $refno,
                'pymtid' => $paymentid,
                'ecurr' => $ecurrency,
                'remark' => $remark,
                'errdesc' => $errdesc,
                'sign' => $signature,
                'pymt_dt' => $now
            ]);
        } else {
            if(count($payments) == 0) {
                $paymentInsert = Payment::create([
                    'trans_id' => $transid,
                    'authcode' => $authcode,
                    'pstatus' => $response_code,
                    'pamount' => $pamount,
                    'refno' => $refno,
                    'pymtid' => $paymentid,
                    'ecurr' => $ecurrency,
                    'remark' => $remark,
                    'errdesc' => $errdesc,
                    'sign' => $signature,
                    'pymt_dt' => $now
                ]);
            } else {
                $paymentInsert = Paymentdev::create([
                    'trans_id' => $transid,
                    'authcode' => $authcode,
                    'pstatus' => $response_code,
                    'pamount' => $pamount,
                    'refno' => $refno,
                    'pymtid' => $paymentid,
                    'ecurr' => $ecurrency,
                    'remark' => $remark,
                    'errdesc' => $errdesc,
                    'sign' => $signature,
                    'pymt_dt' => $now
                ]);
            }
        }

        $status = 1;

        $refnonew = str_replace(config('constant.ORDERID_SET'),'',$refno);
        $order = Order::where('order_no', $refnonew)->where('order_status',1)->first();
        if($order) {
            $pamount = $order->order_grandtotal;

            $order_status_paid = 2;
            if($paymentid==2){
                $newgt = $pamount + $order->order_paycc;
            } else {
                $newgt = $pamount + $order->order_payfpx;
            }

            // $orderUpdate = Order::where('oid', $order->oid)->where('order_status',1);
        }
    }

    public function paymentFail()
    {

    }

}