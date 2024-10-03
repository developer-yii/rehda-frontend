<!doctype html>
<html>
<head>
    <title></title>
    <style type='text/css'>
    @media print {
        /*@page { size: A4 landscape; max-height:100%; max-width:100%; margin: 1cm; }*/
        body { margin: 0; }
        .container { width: 100%; max-width: 100%; }
        header { margin-top: 0; }
        footer { margin-bottom: 0; }
    }
    body {
        background-color: #fff; margin: 0;
        font-family: \"Helvetica Neue\",Helvetica,Roboto,Arial,sans-serif; font-size: 14px; color: #333; line-height: 1.3; letter-spacing: 0.2px; vertical-align: middle;
        -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;
    }
    p { margin: 0; }
    p:not(:last-child) { margin-bottom: 10px; }
    img { max-width: 100%; height: auto; vertical-align: middle; }
    hr { border:none; border-bottom: 1px solid; border-color: #ccc; }

    .text-left { text-align: left; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .nilpadding { padding: 0; }

    .container { max-width: 900px; margin: auto; }
    /*.header { border-bottom: 2px solid #333; }*/
    .header td { padding: 10px 10px; }
    footer { margin: 80px auto 30px; }

    .title { font-size: 20px; font-weight: bold; text-align: right; }
    .bbottom { border-bottom: 1px solid #222; }

    table tbody > tr > th:first-child,
    table tbody > tr > td:first-child { padding-left: 0; }
    table tbody > tr > th:last-child,
    table tbody > tr > td:last-child { padding-right: 0; }

    table.basic-info { margin-top: 15px; margin-bottom: 15px; }
    table.basic-info h6 { font-size: 20px; margin: 0; margin-bottom: 10px; }
    table.basic-info tr { text-align: left; vertical-align: top; }
    table.basic-info table { border-collapse: collapse; }
    table.basic-info th,
    table.basic-info td { padding: 5px 5px; }

    table.data { border-collapse: collapse; }
    table.data .desc tr { text-align: center; }
    /*table.data .desc th { background-color: #ccc; }*/
    table.data .desc th,
    table.data .desc td { border: 1px solid #ddd; padding: 10px 5px; }

    table.data .count td { padding: 3px 5px; }
    table.data .count td.total { border-top: 1px solid #222; border-bottom: 4px double #222; }
    </style>
</head>
<body>

    <div class='container'>
        <table cellpadding='0' cellspacing='0' width='100%' class='header'>
            <tbody>
                <tr>
                    <td width='25%'><img src="{{ asset('frontend/img/logo/email-rehda-logo-blue.png') }}"></td>
                    <td width='5%'>&nbsp;</td>
                    <td class='title text-right'>STATEMENT YEAR {{ $year }}</td>
                </tr>
            </tbody>
        </table>
        <table cellpadding='0' cellspacing='0' width='100%' class='basic-info'>
            <tbody>
                <tr>
                    <td>
                        <table width='100%'>
                            <tbody>
                                <tr>
                                    <td>
                                        <p><b>{!! config('constant.COMPANY_NAME') !!}</b></p>
                                        <small>{{ config('constant.COMPANY_REGISTRATION_NUMBER') }}</small>
                                        <p>{{ config('constant.COMPANY_ADDRESS') }}<br>{{ config('constant.COMPANY_ADDRESS1') }}<br>{{ config('constant.COMPANY_ADDRESS2') }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table cellpadding='0' cellspacing='0' width='100%' class='basic-info'>
            <tbody>
                <tr>
                    <td>
                        <table width='100%'>
                            <tbody>
                                <tr>
                                    <td>
                                        <p><b>{{ strtoupper($memberComp->d_compname) }}</b></p>
                                        <small>{{ $memberComp->d_compssmno }}</small>
                                        <p>{{ strtoupper($memberComp->d_compadd) }}</p><p>{{ $memberComp->d_compaddcity }}</p><p>{{ $memberComp->d_compaddpcode}} {{ $memberComp->state->state_name }}</p><p>{{ $memberComp->country->country_name }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <table cellpadding='0' cellspacing='0' width='100%' class='data'>
            <tbody class='desc'>
                <tr>
                    <th width='15%'>Date</th>
                    <th width='15%'>Item</th>
                    <th width='10%'>Amount (RM)</th>
                </tr>
                <tr>
                    <td>{{ date('d M Y', strtotime($order->order_created_at)) }}</td>
                    <td>Invoice: {{  config('constant.ORDERID_SET').$order->order_no }}</td>
                    <td>{{ number_format($order->order_grandtotal,2) }}</td>
                </tr>
                @if($order->order_status == 2)
                <tr>
                    <td>{{ date('d M Y', strtotime($order->order_paid_at)) }}</td>
                    <td>Payment: {{ config('constant.RECEIPTID_SET').date('ymdHis',strtotime($order->order_no)) }}</td>
                    <td>-{{ number_format($order->order_grandtotal,2) }}</td>
                </tr>
                @endif
            </tbody>
        </table>
        <footer>
            <hr>
            <p style='padding-top:20px;'><b>*This is a computer generated documents. No signature is required.</b>
        </footer>
    </div>
</body>
</html>