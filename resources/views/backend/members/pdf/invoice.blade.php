<!-- resources/views/invoices/invoice-pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        @media print {
            @page {
                size: A4 landscape;
                max-height: 100%;
                max-width: 100%;
                margin: 1cm;
            }

            body {
                margin: 0;
            }

            .container {
                width: 100%;
                max-width: 100%;
            }

            header {
                margin-top: 0;
            }

            footer {
                margin-bottom: 0;
            }
        }

        body {
            /* font-family: 'Outfit', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; */
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            line-height: 1;
            letter-spacing: 0px;
        }

        p {
            /* font-family: 'Outfit', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; */
            font-size: 14px;
            font-weight: 300;
            line-height: 1;
            letter-spacing: 0px;
            margin: 0;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            /* font-family: 'Outfit', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; */
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
                        <img src="{{ asset('backend/assets/img/logo/email-rehda-logo-blue.png') }}" alt="Rehda Logo"
                            style="text-align:right; width:100px;">
                    </td>
                </tr>
                <tr style="background-color:#eeeeee;">
                    <td class="text-left">
                        <p>Invoice No.: <span
                                style="font-weight:500;">#{{ config('constant.ORDERID_SET') }}{{ $order->order_no }}</span>
                        </p>
                    </td>
                    <td class="text-right">
                        <p>Date: <span style="font-weight:500;">{{ $order->order_created_at->format('d-F-Y') }}</span>
                        </p>
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
                        <h3>{{ strtoupper($transaction->d_compname) }}</h3>
                        @if(empty($addressParts))
                        <p>{{ $fullAddress }}</p>
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
                        <p>{{ strtoupper($transaction->d_compaddcity) }}</p>
                        <p>{{ $transaction->d_compaddpcode }} {{ strtoupper(getStatex($transaction->d_compaddstate)) }}
                        </p>
                    </td>
                </tr>
                <tr class="body-info">
                    <td width="50%">
                        <h3>Person in Charge:
                            {{ ucwords(strtolower($memberDetails['title'] . ' ' . $memberDetails['fullname'])) }}</h3>
                        <p>Contact No.: {{ $memberDetails['hp'] }}</p>
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
                @php $i = 1; @endphp
                @if ($order->order_entrance_fee > 0)
                    @include('backend.members.pdf.partials.table-row', [
                        'index' => $i++,
                        'item' => config('constant.ENTRANCE_FEE_LABEL'),
                        'amount' => $order->order_entrance_fee,
                    ])
                @endif
                @if ($order->order_sub_fee > 0)
                    @php
                        $feeLabel =
                            $order->order_type == 2
                                ? config('constant.RENEWAL_FEE_LABEL')
                                : config('constant.FEE_LABEL');
                    @endphp
                    @include('backend.members.pdf.partials.table-row', [
                        'index' => $i++,
                        'item' => $feeLabel . ' ' . $order->order_planname . ' ' . $order->order_sub_fee_year,
                        'amount' => $order->order_sub_fee,
                        'subItem' => strtoupper($transaction->d_compname),
                    ])
                @endif
                @if ($order->order_status == 2 && $order->order_pm == 2 && $order->order_paycc > 0)
                    @include('backend.members.pdf.partials.table-row', [
                        'index' => $i++,
                        'item' => config('constant.CC_HANDLING_FEE_LABEL'),
                        'amount' => $order->order_paycc,
                    ])
                @elseif ($order->order_status == 2 && $order->order_pm != 2)
                    @include('backend.members.pdf.partials.table-row', [
                        'index' => $i++,
                        'item' => config('constant.FPX_HANDLING_FEE_LABEL'),
                        'waived' => true,
                    ])
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
                        <p>{{ number_format($order->order_grandtotal, 2) }}</p>
                    </td>
                    <td>
                        <p>-</p>
                    </td>
                    <td>
                        <p>{{ number_format($order->order_grandtotal, 2) }}</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td style="padding-top:30px;padding-bottom:30px;">
                    <p>To make payment, kindly login to your REHDA Membership Account at <a
                            href="{{ config('constant.SITE2') }}" target="_blank">{{ config('constant.SITE2') }}</a>.</p>
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
