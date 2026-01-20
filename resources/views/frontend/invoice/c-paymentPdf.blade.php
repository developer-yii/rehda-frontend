<!DOCTYPE html>
<html lang="en">

<head>
  <title>REHDA Confirmation of Payment - {{ config('constant.PR_ORDERID_SET').$order->order_no }}</title>
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
                    <td colspan="2">
                        <img src="{{ asset('frontend/img/receipt-bg.png') }}" alt="Rehda Header BG" width="100%">
                    </td>
                </tr>
                <tr>
                    <td class="text-left" width="80%">
                        <h1 style="font-size:42px;">Payment Successful</h1>
                    </td>

                    <td class="text-right">
                        <img src="{{ asset('frontend/img/logo/email-rehda-logo-blue.png') }}" alt="Rehda Logo" style="text-align:right; width:100px;">
                    </td>
                </tr>

                <tr>
                    <td class="text-left">
                        Dear {{ strtoupper($memberComp->d_compname) }},
                    </td>
                </tr>
                <tr>
                    <td class="text-left" colspan="2">
                        We are pleased to inform you that the following online payment via iPay88 is successful.
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>PROFORMA INVOICE NO.</td>
                                <td width="25">:</td>
                                <td>{{ config('constant.PR_ORDERID_SET').$order->order_no }}</td>
                            </tr>
                            <tr>
                                <td>TRANSACTION DATE</td>
                                <td width="25">:</td>
                                <td>{{ date("d-F-Y", strtotime($order->order_paid_at)) }}</td>
                            </tr>
                            <tr>
                                <td>MEMBERSHIP NO</td>
                                <td width="25">:</td>
                                <td>{{ getMembershipNobyMID($order->memberComp->d_mid) }}</td>
                            </tr>
                            <tr>
                                <td>COMPANY (MEMBERS) NAME</td>
                                <td width="25">:</td>
                                <td>{{ strtoupper($memberComp->d_compname) }}</td>
                            </tr>
                            <tr>
                                <td>PAYMENT TYPE</td>
                                <td width="25">:</td>
                                <td>
                                    @if($payment)
                                        @if(in_array($payment->pymtid, [16,10,14,152,31,20,15,6,163,8,167,198,124,168]) || in_array($payment->pymtid, [270,271,272,273,274,276,277,278,279,280,281,282,283,285,286,]))
                                            FPX
                                        @elseif($payment->pymtid == 2)
                                          Credit Card
                                        @else
                                          Direct
                                        @endif
                                    @else
                                        Direct
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>TOTAL AMOUNT</td>
                                <td width="25">:</td>
                                <td>{{ number_format($order->order_grandtotal,2) }}</td>
                            </tr>
                            <tr>
                                <td>TRANSACTION METHOD</td>
                                <td width="25">:</td>
                                <td>{{ $paymentType }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
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