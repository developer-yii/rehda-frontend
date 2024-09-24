<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\MemberComp;
use App\Models\Branch;
use App\Models\Order;
use Dompdf\Dompdf;
use Dompdf\Options;

class MemberStatementAccountController extends Controller
{
    public function getStatement(Request $request)
    {
        if (Auth::user()->cannot('statementaccount-view')) {
            return response()->json(['message' => 'You don\'t have permission to view this data'], 403);
        }

        // Fetch the order years for the given member ID
        $orders = Order::selectRaw('YEAR(order_created_at) as orderyear')
            ->where('order_mid', $request->pid)
            ->groupByRaw('YEAR(order_created_at)')
            ->orderByRaw('YEAR(order_created_at) DESC')
            ->get();

        // If no orders are found, return an error response
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No Statement found for the member'], 404);
        }

        // Return the partial view with order data
        $html = view('backend.members.partials.account_statement', compact('orders', 'request'))->render();

        return response()->json(['status' => true, 'message' => '', 'html' => $html]);
    }

    public function generateStatement(Request $request)
    {
        if (auth()->user()->cannot('statementaccount-view')) {
            return redirect()->back()->with('error', 'You don\'t have permission to access account statement page');
        }

        $year = $request->input('year');
        $compId = $request->input('compid');

        // Fetch the transaction details
        $transaction = MemberComp::where('did', $compId)->first();
        if (!$transaction) {
            return redirect()->route('active-members.index');
        }

        // Fetch the orders
        $orders = Order::where('order_mid', $compId)
            ->whereYear('order_created_at', $year)
            ->orderBy('order_created_at', 'asc')
            ->get();

        // Generate the HTML content using the Blade view
        $html = view('backend.members.pdf.statementofaccount', compact('year', 'transaction', 'orders'))->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = "Rehda Statement-" . $year . "pdf";
        return $dompdf->stream($filename, ['Attachment' => 0]);
    }
}
