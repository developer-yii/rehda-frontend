<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\MemberComp;
use App\Models\Order;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StatementOfAccountController extends Controller
{
    public function index(Request $request)
    {
        if(session('compid') == null){
            return redirect(route('login'));
        }

        if ($request->ajax()) {

            $orders = Order::where('order_mid', session('compid'))->orderBy('order_created_at', 'DESC');
            // $orders = Order::selectRaw('oid, YEAR(order_created_at) AS orderyear')->where('order_mid', session('compid'))->groupByRaw('YEAR(order_created_at)')->orderByRaw('YEAR(order_created_at) DESC');

            return DataTables::eloquent($orders)
            ->addColumn('date', function ($row) {
                return date('Y',strtotime($row->order_created_at));
            })
            ->addColumn('actions', function ($row) {
                $buttons = '';

                $buttons .= '<a href="'.route('statement-of-account.view', date('Y',strtotime($row->order_created_at))).'" target="_blank" class="btn btn-outline-primary waves-effect me-2">View</a>';
                $buttons .= '<a href="'.route('statement-of-account.download', date('Y',strtotime($row->order_created_at))) .'" target="_blank" download class="btn btn-outline-primary waves-effect">Download</a>';

                return $buttons;
            })
            ->rawColumns(['date', 'actions'])
            ->toJson();

        }
        return view('frontend.statement-of-account.index');
    }

    public function view($year)
    {
        $memberComp = MemberComp::with('state')->where('did', session('compid'))->first();
        $order = Order::where('order_mid', session('compid'))->whereYear('order_created_at', $year)->orderBy('order_created_at', 'asc')->first();

        $html = view('frontend.statement-of-account.view', compact('memberComp', 'year', 'order'))->render();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = "REHDA Statement-" . $year;
        return $dompdf->stream($filename, ['Attachment' => 0]);
    }

    public function download($year)
    {
        $memberComp = MemberComp::with('state')->where('did', session('compid'))->first();
        $order = Order::where('order_mid', session('compid'))->whereYear('order_created_at', $year)->orderBy('order_created_at', 'asc')->first();

        $html = view('frontend.statement-of-account.view', compact('memberComp', 'year', 'order'))->render();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = "REHDA Statement-" . $year;
        return $dompdf->stream($filename, ['Attachment' => 0]);
    }
}