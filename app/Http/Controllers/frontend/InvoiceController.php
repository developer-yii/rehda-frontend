<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\MemberComp;
use App\Models\MemberUser;
use App\Models\MemberUserProfile;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Paymentdev;
use App\Models\PaymentType;
use App\Models\MemberEInvoice;
use App\Models\MemberOReceipt;
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

                // if(auth()->user()->ml_priv == "CompanyAdmin") {
                //     $up_ids = MemberUserProfile::where('up_mid',auth()->user()->memberUserProfile->up_mid)->whereNot('up_id', auth()->user()->ml_id)->pluck('up_id')->toArray();

                //     $usernames = MemberUser::whereIn('ml_uid', $up_ids)->pluck('ml_username')->toArray();

                //     $upMidList = MemberUser::join('member_userprofiles', 'member_users.ml_uid', '=', 'member_userprofiles.up_id')
                //     ->whereIn('member_users.ml_username', $usernames)
                //     ->groupBy('member_userprofiles.up_mid')
                //     ->orderBy('member_userprofiles.up_mid', 'asc')
                //     ->pluck('member_userprofiles.up_mid')->toArray();

                //     $arr = array_unique(array_merge($upMidList,$arr), SORT_REGULAR);
                // }

                $orders = Order::with('orderStatus', 'memberComp')
                ->whereIn('order_mid', $arr)->orderBy('order_created_at', 'DESC');

            } else {
                $orders = Order::with('orderStatus', 'memberComp')
                ->where('order_mid', session('compid'))->orderBy('order_created_at', 'DESC');
            }

            // Apply the status filter if present
            if ($request->input('status_filter') !== null) {
                $orders->where('order_status', $request->input('status_filter'));
            }

            return DataTables::eloquent($orders)
            ->addColumn('membership_no', function ($row) {
                return getMembershipNobyMID($row->memberComp->d_mid);
            })
            ->addColumn('member_type', function ($row) {
                return $row->memberComp->member->memberType->typename ?? '';
            })
            ->addColumn('date', function ($row) {
                if($row->order_status == 100){
                    $label = 'Pending - For Checker Approval';
                } else {
                    $label = $row->orderStatus->status;
                }
                return '<p>'.date('d-M-Y',strtotime($row->order_created_at)).'</p><span class="badge bg-label-'.$row->orderStatus->label.'">'.$label.'</span>';
            })
            ->addColumn('invoice_no', function ($row) {
                return '#'.config('constant.ORDERID_SET').$row->order_no;
            })
            ->addColumn('amount', function ($row) {
                return config('currency.base_currency').' '.number_format($row['order_grandtotal'],2);
            })
            ->addColumn('actions', function ($row) {
                $buttons = '';

                if($row->order_status == 1 || $row->order_status == 100) {
                    $invno = config('constant.ORDERID_SET').$row->order_no;
                    $auth = md5($invno).sha1($invno).md5(sha1($invno));
                    $buttons .= '<a href="'.route('invoice.paymentfpx', [$invno, $auth]).'" target="_blank" class="btn btn-outline-primary waves-effect me-2 mb-1">Pay with FPX</a>';
                    $buttons .= '<a href="'.route('invoice.paymentcard', [$invno, $auth]).'" target="_blank" class="btn btn-outline-primary waves-effect me-2 mb-1">Pay with Credit/Debit Card<br><small>+'.config('constant.CC_FEE').'% Handling Fee</small></a>';

                    if(date('Y', strtotime($row->order_created_at)) >= 2026) {
                        $buttons .= '<a href="javascript:void(0);" class="btn btn-outline-secondary waves-effect me-2 mb-1" style="width: 122px;height: 55px;">Invoice</a>';
                        $buttons .= '<a href="'.route('pr-invoice.pdf', $row->oid).'" target="_blank" class="btn btn-outline-primary waves-effect me-2 mb-1" style="width: 122px;height: 55px;">Proforma Invoice</a>';
                    } else {
                        $buttons .= '<a href="'.route('invoice.pdf', $row->oid).'" target="_blank" class="btn btn-outline-primary waves-effect me-2 mb-1" style="width: 122px;height: 55px;">Invoice</a>';
                        $buttons .= '<a href="javascript:void(0);" class="btn btn-outline-secondary waves-effect me-2 mb-1" style="width: 122px;height: 55px;">Proforma Invoice</a>';
                    }

                    $orderYear = date('Y', strtotime($row->order_created_at));
                    $eInvoice = MemberEInvoice::where('mei_mid', $row->order_mid)->where('mei_yr', $orderYear)->first();
                    if($eInvoice) {
                        $buttons .= '<a href="'. config('app.backendurl').'storage/'.$eInvoice->einvoice_path .'" target="_blank" class="btn btn-outline-primary waves-effect me-2 mb-1" style="width: 122px;height: 55px;">e-Invoice</a>';
                    } else {
                        $buttons .= '<a href="javascript:void(0);" class="btn btn-outline-secondary waves-effect me-2 mb-1" style="width: 122px;height: 55px;">e-Invoice</a>';
                    }

                } else {
                    if(date('Y', strtotime($row->order_created_at)) >= 2026) {
                        $buttons .= '<a href="javascript:void(0);" class="btn btn-outline-secondary waves-effect me-2 mb-1" style="width: 122px;height: 55px;">Invoice</a>';
                        $buttons .= '<a href="'.route('pr-invoice.pdf', $row->oid).'" target="_blank" class="btn btn-outline-primary waves-effect me-2 mb-1" style="width: 122px;height: 55px;">Proforma Invoice</a>';
                    } else {
                        $buttons .= '<a href="'.route('invoice.pdf', $row->oid).'" target="_blank" class="btn btn-outline-primary waves-effect me-2 mb-1" style="width: 122px;height: 55px;">Invoice</a>';
                        $buttons .= '<a href="javascript:void(0);" class="btn btn-outline-secondary waves-effect me-2 mb-1" style="width: 122px;height: 55px;">Proforma Invoice</a>';
                    }

                    $orderYear = date('Y', strtotime($row->order_created_at));
                    $eInvoice = MemberEInvoice::where('mei_mid', $row->order_mid)->where('mei_yr', $orderYear)->first();
                    if($eInvoice) {
                        $buttons .= '<a href="'. config('app.backendurl').'storage/'.$eInvoice->einvoice_path .'" target="_blank" class="btn btn-outline-primary waves-effect me-2 mb-1" style="width: 122px;height: 55px;">e-Invoice</a>';
                    } else {
                        $buttons .= '<a href="javascript:void(0);" class="btn btn-outline-secondary waves-effect me-2 mb-1" style="width: 122px;height: 55px;">e-Invoice</a>';
                    }

                    if($row->order_status != 99) {
                        if(date('Y', strtotime($row->order_created_at)) >= 2026) {
                            $buttons .= '<a href="javascript:void(0);" class="btn btn-outline-secondary waves-effect mb-1 me-2" style="width: 122px;height: 55px;">Receipt</a>';
                            $buttons .= '<a href="'.route('invoice.c-payment', $row->oid) .'" target="_blank" class="btn btn-outline-primary waves-effect mb-1 me-2" style="width: 122px;height: 55px;">Payment Confirmation</a>';
                        } else {
                            $buttons .= '<a href="'.route('invoice.receipt', $row->oid) .'" target="_blank" class="btn btn-outline-primary waves-effect mb-1 me-2" style="width: 122px;height: 55px;">Receipt</a>';
                            $buttons .= '<a href="javascript:void(0);" class="btn btn-outline-secondary waves-effect mb-1 me-2" style="width: 122px;height: 55px;">Payment Confirmation</a>';
                        }


                        $orderYear = date('Y', strtotime($row->order_created_at));
                        $oReceipt = MemberOReceipt::where('mor_mid', $row->order_mid)->where('mor_yr', $orderYear)->first();
                        if($oReceipt) {
                            $buttons .= '<a href="'. config('app.backendurl').'storage/'.$oReceipt->oreceipt_path .'" target="_blank" class="btn btn-outline-primary waves-effect mb-1 me-2" style="width: 122px;height: 55px;">Official Rct</a>';
                        } else {
                            $buttons .= '<a href="javascript:void(0);" class="btn btn-outline-secondary waves-effect mb-1 me-2" style="width: 122px;height: 55px;">Official Rct</a>';
                        }
                    }
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

        $filename = "REHDA Invoice - ".config('constant.ORDERID_SET').$order->order_no.".pdf";
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

        $filename = "REHDA Receipt - ".config('constant.ORDERID_SET').$order->order_no;
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
            if($order) {
                $memberDetails = getMemberToSendInv($order->order_mid);
                return view('frontend.invoice.paymentfpx', compact('order','memberDetails'));
            } else {
                return redirect()->back()->with('error', 'Order not found.');
            }
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
            if($order) {
                $memberDetails = getMemberToSendInv($order->order_mid);
                return view('frontend.invoice.paymentcard', compact('order','memberDetails'));
            } else {
                return redirect()->back()->with('error', 'Order not found.');
            }
        }
    }

    public function invoicePaymentreturn(Request $request)
    {
        \Log::info('Payment return request');
        \Log::info($request->all());

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

                \Log::info('succUpdateMember function result - '.$result);

                if($result == 2){
                    return redirect(route('payment.fail'));
                } else {
                    return redirect(route('payment.success'));
                }

            } else {

                $checkPayment = Payment::where('refno', $refno)->where('trans_id',$transid)->first();
                if(!$checkPayment) {
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

                if($response_code == 6 && ($errdesc == 'Payment Pending' || $errdesc == 'Pending Checker Approval')){
                    return redirect(route('payment.pending', $refno));
                }

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

        if ($payment === null) {
            \Log::info("succUpdateMember not found single payment record");
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
            if ($payments->isEmpty()) {
                \Log::info("succUpdateMember not found multiple payment record");
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
                \Log::info("succUpdateMember found ".$payments->count()." payment record");

                $check_paymentInsert = Paymentdev::where('trans_id', $transid)->where('refno', $refno)->first();
                if($check_paymentInsert === null) {

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

                return 1;
            }
        }

        $status = 1;

        $refnonew = str_replace(config('constant.ORDERID_SET'),'',$refno);
        $order = Order::where('order_no', $refnonew)->whereIn('order_status',[1,100])->first();
        if($order) {
            \Log::info("succUpdateMember found order record");
            $pamount = $order->order_grandtotal;

            $order_status_paid = 2;
            if($paymentid==2){
                $newgt = $pamount + $order->order_paycc;
            } else {
                $newgt = $pamount + $order->order_payfpx;
            }

            $paidOrder = Order::where('oid', $order->oid)->whereIn('order_status',[1,100])->where('order_status', '=', $order_status_paid)->first();
            \Log::info('paidOrder');
            \Log::info($paidOrder);

            if(!$paidOrder){
                \Log::info('update order');

                $orderUpdate = Order::where('oid', $order->oid)->whereIn('order_status',[1,100])->update([
                    'order_status' => $order_status_paid,
                    'order_paid_at' => $now,
                    'order_pm' => $paymentid,
                    'order_grandtotal' => $newgt
                ]);
            }

            $findorder = Order::with('memberComp.member')->where('order_no', $refnonew)->first();

            // create certificate when invoice create
            $resultnew = memberCertificatePdfCreate($findorder->memberComp->member->mid);
            \Log::info('member-id - '.$findorder->memberComp->member->mid);
            \Log::info($resultnew);

            return 1;
        } else {
            \Log::info("succUpdateMember not found order record");
            return 2;
        }
    }

    public function invoicePaymentreturncallback(Request $request)
    {
        \Log::info('Payment return callback');
        \Log::info($request->all());

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

                $checkPayment = Payment::where('refno', $refno)->where('trans_id',$transid)->first();
                if(!$checkPayment) {
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

        echo "RECEIVEOK";
        exit;
    }

    public function paymentFail()
    {
        return view('frontend.invoice.paymentfail');
    }

    public function paymentSuccess()
    {
        return view('frontend.invoice.paymentsuccess');
    }

    public function PaymentPending($orderno)
    {
        Order::where('order_no', $orderno)->update(['order_status' => 100]);
        return view('frontend.invoice.paymentpending');
    }

    public function prInvoicePdf($id)
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

        $html = view('frontend.invoice.pr-invoice-pdf', compact('memberComp', 'memberProfile', 'order'))->render();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = "REHDA Invoice - ".config('constant.PR_ORDERID_SET').$order->order_no.".pdf";
        return $dompdf->stream($filename, ['Attachment' => 0]);
    }

    public function invoiceCPayment($id)
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
        $payment = Payment::where('refno', config('constant.ORDERID_SET').$order->order_no)->first();
        if($payment){
            $paymentType = PaymentType::where('display', PaymentType::DISPLAY_SHOW)->first()->type_name ?? '';
        } else {
            $paymentType = '';
        }

        $html = view('frontend.invoice.c-paymentPdf', compact('memberComp', 'memberProfile', 'order', 'payment', 'paymentType'))->render();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = "REHDA Conformation of Payment - ".config('constant.PR_ORDERID_SET').$order->order_no;
        return $dompdf->stream($filename, ['Attachment' => 0]);
    }

}