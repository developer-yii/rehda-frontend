<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\MemberComp;
use App\Models\MemberUser;
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

                if(auth()->user()->ml_priv == "CompanyAdmin") {
                    $up_ids = MemberUserProfile::where('up_mid',auth()->user()->memberUserProfile->up_mid)->whereNot('up_id', auth()->user()->ml_id)->pluck('up_id')->toArray();

                    $usernames = MemberUser::whereIn('ml_uid', $up_ids)->pluck('ml_username')->toArray();

                    $upMidList = MemberUser::join('member_userprofiles', 'member_users.ml_uid', '=', 'member_userprofiles.up_id')
                    ->whereIn('member_users.ml_username', $usernames)
                    ->groupBy('member_userprofiles.up_mid')
                    ->orderBy('member_userprofiles.up_mid', 'asc')
                    ->pluck('member_userprofiles.up_mid')->toArray();

                    $arr = array_unique(array_merge($upMidList,$arr), SORT_REGULAR);
                }

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
                    $invno = config('constant.ORDERID_SET').$row->order_no;
                    $auth = md5($invno).sha1($invno).md5(sha1($invno));
                    $buttons .= '<a href="'.route('invoice.paymentfpx', [$invno, $auth]).'" target="_blank" class="btn btn-outline-primary waves-effect me-2 mb-1">Pay with FPX</a>';
                    $buttons .= '<a href="'.route('invoice.paymentcard', [$invno, $auth]).'" target="_blank" class="btn btn-outline-primary waves-effect me-2 mb-1">Pay with Credit/Debit Card<br><small>+'.config('constant.CC_FEE').'% Handling Fee</small></a>';
                    $buttons .= '<a href="'.route('invoice.pdf', $row->oid).'" target="_blank" class="btn btn-outline-primary waves-effect me-2 mb-1">Proforma Invoice</a>';
                } else {
                    $buttons .= '<a href="'.route('invoice.pdf', $row->oid).'" target="_blank" class="btn btn-outline-primary waves-effect me-2 mb-1">Invoice</a>';
                    $buttons .= '<a href="'.route('invoice.receipt', $row->oid) .'" target="_blank" class="btn btn-outline-primary waves-effect mb-1">Receipt</a>';
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
            if(auth()->user()->ml_priv == "CompanyAdmin") {
                $order = Order::where('oid', $id)->first();
            } else {
                $arr = getChildMid(session('compid'));
                $order = Order::where('oid', $id)->whereIn('order_mid', $arr)->first();
            }
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
            if(auth()->user()->ml_priv == "CompanyAdmin") {
                $order = Order::where('oid', $id)->first();
            } else {
                $arr = getChildMid(session('compid'));
                $order = Order::where('oid', $id)->whereIn('order_mid', $arr)->first();
            }
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

    public function invoicePaymentfpx($order_no, $auth)
    {
        $authcodex = md5($order_no).sha1($order_no).md5(sha1($order_no));
        $order_no = str_replace(config('constant.ORDERID_SET'),'',$order_no);
        if($authcodex != $auth) {
            die();
        } else {
            $order = Order::where('order_no', $order_no)->where('order_status',1)->first();
            $memberDetails = getMemberToSendInv($order->order_mid);
            return view('frontend.invoice.paymentfpx', compact('order','memberDetails'));
        }
    }

    public function invoicePaymentcard($order_no, $auth)
    {
        $authcodex = md5($order_no).sha1($order_no).md5(sha1($order_no));
        $order_no = str_replace(config('constant.ORDERID_SET'),'',$order_no);
        if($authcodex != $auth) {
            die();
        } else {
            $order = Order::where('order_no', $order_no)->where('order_status',1)->first();
            $memberDetails = getMemberToSendInv($order->order_mid);
            return view('frontend.invoice.paymentcard', compact('order','memberDetails'));
        }
    }

    public function invoicePaymentreturn(Request $request)
    {
        if ( !empty($request->PaymentId) && !empty( $request->RefNo ) )
        {
            $now = date('Y-m-d H:i:s');
            $orderid = date('YmdHis')."-CC";

            $merchantcode = $request->MerchantCode;
            $paymentid = $request->PaymentId;
            $refno = $request->RefNo;
            $pamount = $request->Amount;
            $ecurrency = $request->Currency;
            $remark = $request->Remark;
            $transid = $request->TransId;
            $authcode = $request->AuthCode;
            $response_code = $request->Status;
            $errdesc = $request->ErrDesc;
            $signature = $request->Signature;
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

            $orderUpdate = Order::where('oid', $order->oid)->where('order_status',1)->update([
                'order_status' => $order_status_paid,
                'order_paid_at' => $now,
                'order_pm' => $paymentid,
                'order_grandtotal' => $newgt
            ]);

            return 1;
        } else {
            return 2;
        }
    }

    public function invoicePaymentreturncallback(Request $request)
    {
        if ( !empty($request->PaymentId) && !empty( $request->RefNo ) )
        {
            $now = date('Y-m-d H:i:s');
            $orderid = date('YmdHis')."-CC";

            $merchantcode = $request->MerchantCode;
            $paymentid = $request->PaymentId;
            $refno = $request->RefNo;
            $pamount = $request->Amount;
            $ecurrency = $request->Currency;
            $remark = $request->Remark;
            $transid = $request->TransId;
            $authcode = $request->AuthCode;
            $response_code = $request->Status;
            $errdesc = $request->ErrDesc;
            $signature = $request->Signature;
            $decrypt = "IPAY88";
            $ttype = 2; //CC

            if($response_code == 1)
            {
                $result = $this->succUpdateMember($orderid,$ttype,$merchantcode,$paymentid,$refno,$pamount,$ecurrency,$remark,$transid,$authcode,$response_code,$errdesc,$signature);
            } else { //failed
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
            }

        }
    }

    public function paymentFail()
    {
        return view('frontend.invoice.paymentfail');
    }

    public function paymentSuccess()
    {
        return view('frontend.invoice.paymentsuccess');
    }

}