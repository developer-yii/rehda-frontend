<!DOCTYPE html>
<html lang="en">

<head>
    <title>REHDA Invoice - {{ config('constant.ORDERID_SET').$order->order_no }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500&display=swap" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        @media print {
            @page { size: A4 landscape; max-height: 100%; max-width: 100%; margin: 1cm; }
            body { margin: 0; }
            .container { width: 100%; max-width: 100%; }
            header { margin-top: 0; }
            footer { margin-bottom: 0; }
        }

        body {
            font-family: 'Public Sans', system-ui, -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Oxygen, Ubuntu, Cantarell, \'Open Sans\', \'Helvetica Neue\', sans-serif;
            font-size: 14px; line-height: 1; letter-spacing: 0px;
        }

        p {
            font-family: 'Public Sans', system-ui, -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Oxygen, Ubuntu, Cantarell, \'Open Sans\', \'Helvetica Neue\', sans-serif;
            font-size: 14px;
            font-weight: 300;
            line-height: 1; letter-spacing: 0px;
            margin: 0;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Public Sans', system-ui, -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Oxygen, Ubuntu, Cantarell, \'Open Sans\', \'Helvetica Neue\', sans-serif;
            font-weight: 400;
            margin: 0;
        }

        .container {
            margin: auto;
            max-width: 900px;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .header td {
            padding: 10px;
        }

        .body-info {
            margin: 10px 0;
        }

        .body-info td {
            padding: 10px;
        }

        .table-title {
            background-color: #808080;
            margin: 0 0 10px;
        }

        .table-title th {
            padding: 8px 10px;
        }

        .table-title th:nth-child(2) {
            text-align: left;
        }

        .table-title th p {
            color: #ffffff;
            font-weight: 500;
        }

        .table-basic-info {
            background-color: #ececec;
        }

        .table-basic-info td {
            padding: 8px 10px;
            text-align: center;
        }

        .table-basic-info td:nth-child(2) {
            text-align: left;
        }

        .table-basic-info tr:last-child {
            background-color: #bebebe;
        }

        .table-basic-info tr:last-child td p {
            font-weight: 500;
        }

        .table-basic-info tr:last-child td:nth-child(2) {
            text-align: center;
        }

        table td {
            padding: 8px 10px;
        }

        hr {
            border-top: 2px solid white;
        }
    </style>
</head>
<body>
    <div class="container">

        <table cellpadding="0" cellspacing="0" width="100%" class="header">
            <tbody>
                <tr>
                    <td class="text-left">
                        <h1 style="font-size:45px;">Invoice</h1>
                    </td>

                    <td class="text-right">
                        <img src="{{ asset('frontend/img/logo/email-rehda-logo-blue.png') }}" alt="Rehda Logo" style="text-align:right; width:100px;">
                    </td>
                </tr>

                <tr style="background-color:#eeeeee;">
                    <td class="text-left">
                        <p>Invoice No.: <span style="font-weight:500;">{{ '#'.config('constant.ORDERID_SET').$order->order_no }}</span></p>
                        <p>
                            Acc Code:
                        </p>
                    </td>

                    <td class="text-right">
                        <p>Date: <span style="font-weight:500;">{{ date("d-F-Y", strtotime($order->order_created_at)) }}</span></p>
                        <p>Terms: 90 Days</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="body-info">
            <tbody>
                <tr class="body-info">
                    <td width="50%">
                        <h4>[ Attn to ]</h4>

                        <h3>{{ strtoupper($memberComp->d_compname) }}</h3>

                        @php
                        $full = strtoupper($memberComp->d_compadd);
                        $addressParts = explode(',', $full);
                        $addressParts = array_filter($addressParts); // Filter empty parts
                        @endphp

                        @if(empty($addressParts))
                            <p>{{ strtoupper($full) }}</p>
                        @else

                            @foreach ($addressParts as $index => $part)
                                @if ($index % 2 == 0)
                                    <p>
                                        {{ strtoupper($part) }}
                                        @if (isset($addressParts[$index + 1]))
                                            , {{ strtoupper($addressParts[$index + 1]) }}
                                        @endif
                                    </p>
                                @endif
                            @endforeach
                        @endif

                        <p>{{ strtoupper($memberComp->d_compaddcity) }}</p>
                        <p>{{ $memberComp->d_compadd_3 }}</p>
                        <p>{{ $memberComp->d_compaddpcode.' '.(isset($memberComp->state) ? strtoupper($memberComp->state->state_name) : '') }}</p>
                    </td>
                </tr>

                <tr class="body-info">
                    <td width="50%">
                        <h3>Person in Charge: {{ ucwords(strtolower(getTitle($memberProfile->up_title).' '.$memberProfile->up_fullname)) }}</h3>
                        <p>Contact No.: {{ $memberProfile->up_contactno }}</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <table cellpadding="0" cellspacing="0" width="100%">
            <thead class="table-title">
                <tr>
                    <th>
                        <p>No</p>
                    </th>

                    <th width="40%">
                        <p>Item</p>
                    </th>

                    <th>
                        <p>Total Excl. Tax<br>({{ config('currency.base_currency') }})</p>
                    </th>

                    <th>
                        <p>Tax <br>Amount</p>
                    </th>

                    <th>
                        <p>Total Incl. Tax<br>({{ config('currency.base_currency') }})</p>
                    </th>
                </tr>
            </thead>

            <tbody class="table-basic-info">

                @php $i=1; @endphp
                @if($order->order_entrance_fee > 0)
                <tr>
                    <td>
                        <p>{{ $i }}</p>
                    </td>
                    <td>
                        <p>{{ config('constant.ENTRANCE_FEE_LABEL') }}</p>
                    </td>
                    <td>
                        <p>{{ number_format($order->order_entrance_fee,2) }}</p>
                    </td>
                    <td>
                        <p>-</p>
                    </td>
                    <td>
                        <p>{{ number_format($order->order_entrance_fee,2) }}</p>
                    </td>
                </tr>
                @php $i++; @endphp
                @endif
                @if($order->order_sub_fee > 0)
                <tr>
                    <td>
                        <p>{{ $i }}</p>
                    </td>
                    <td>
                        <p>{{ (($order->order_type == 2) ? config('constant.RENEWAL_FEE_LABEL') : config('constant.FEE_LABEL')).' '.$order->order_planname.' '.$order->order_sub_fee_year }}</p>
                        <p>- {{ strtoupper($memberComp->d_compname) }}</p>
                    </td>
                    <td>
                        <p>{{ number_format($order->order_sub_fee,2) }}</p>
                    </td>
                    <td>
                        <p>-</p>
                    </td>
                    <td>
                        <p>{{ number_format($order->order_sub_fee,2) }}</p>
                    </td>
                </tr>
                @php $i++; @endphp
                @endif
                @if($order->order_status == 2 && $order->order_pm == 2 && $order->order_paycc > 0)
                <tr>
                    <td>
                        <p>{{ $i }}</p>
                    </td>
                    <td>
                        <p>{{ config('constant.CC_HANDLING_FEE_LABEL') }}</p>
                    </td>
                    <td>
                        <p>{{ number_format($order->order_paycc,2) }}</p>
                    </td>
                    <td>
                        <p>-</p>
                    </td>
                    <td>
                        <p>{{ number_format($order->order_paycc,2) }}</p>
                    </td>
                </tr>
                @php $i++; @endphp
                @else if($order->order_status == 2 && $order->order_pm != 2)
                <!-- <tr>
                    <td>
                        <p>{{ $i }}</p>
                    </td>
                    <td>
                        <p>{{ config('constant.FPX_HANDLING_FEE_LABEL') }}</p>
                    </td>
                    <td>
                        <p>(waived)</p>
                    </td>
                    <td>
                        <p>-</p>
                    </td>
                    <td>
                        <p>(waived)</p>
                    </td>
                </tr> -->
                {{-- @php $i++; @endphp --}}
                @endif

                <tr height="50px">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="2" class="text-left">
                        <p>Total Amount</p>
                    </td>
                    <td>
                        <p>{{ number_format($order->order_grandtotal,2) }}</p>
                    </td>
                    <td>
                        <p>-</p>
                    </td>
                    <td>
                        <p>{{ number_format($order->order_grandtotal,2) }}</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td style="padding-top:30px;padding-bottom:30px;">
                    <p>To make payment, kindly login to your REHDA Membership Account at <a href="{{ config('constant.SITE2') }}" target="_blank">{{ config('constant.SITE2') }}</a>.</p>
                </td>
            </tr>
        </table>

        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td>{!! config('constant.EMAIL_TEMP_COMP_INFO') !!}</td>
            </tr>
            <tr>
                <td>{!! config('constant.EMAIL_FOOTER') !!}</td>
            </tr>
            <tr>
                <td>
                    <p style="font-size:13px;">*Note: This is a Computer generated, no signature is required.</p>
                </td>
            </tr>
        </table>

    </div>
</body>
</html>