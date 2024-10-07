<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title>Rehda Membership Forgot Password Request</title>
    <style>
        @font-face {
            font-family: "Outfit", sans-serif;
            font-weight: 300;
            src: url("{{ asset('backend/assets/css/webfonts/Outfit-Regular.ttf') }}");
        }
        @font-face {
            font-family: "Outfit", sans-serif;
            font-weight: 400;
            src: url("{{ asset('backend/assets/css/webfonts/Outfit-Bold.ttf') }}");
        }
        table, td, div, h1, p {
            font-family: "Outfit", sans-serif;
            font-weight: 300;
            line-height: 1.4;
        }
    </style>
</head>
<body style="margin:0;padding:0;">
    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
        <tr>
            <td align="center" style="padding:0;">
                <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #eeeeee;border-spacing:0;text-align:left;">
                    <tr>
                        <td align="center" style="padding:60px 0 30px 0;background:#003264;border: 1px solid #003264;">
                            <a style="cursor: pointer;" target="_blank"><img src="{{ asset('backend/assets/img/logo/email-rehda-logo-white.png') }}" alt="Rehda Logo" width="150" style="height: auto; display: block;"></a>
                        </td>
                    </tr>
                    <!-- VIEW INVOICE / BILL STATEMENT -->
                    <tr>
                        <td style="padding:36px 30px 42px 30px; text-align: center;">
                            <h1 style="font-size:24px; font-weight: bold; margin:0 0 15px 0;">Hi {{ $fullname }}, <br> You have a new invoice {{ $invno }}!</h1>
                            <p style="margin:0 0 20px 0;font-size:16px;line-height:24px;">Please refer to the attachment.</p>
                            <p style="margin:0 0 20px 0;font-size:16px;line-height:24px;">Click below to pay now! Thank you.</p>
                            <div>
                                <a href="{{ route('invoice.paymentfpx', [$invno, $auth]) }}" target="_blank">
                                    <button style="border: 1px solid #003264; background: white; cursor: pointer; font-family: Outfit, sans-serif; font-weight: 300; padding: 15px; color: #003264; max-width: 200px; text-transform: uppercase; width: 100%;">Pay with FPX</button>
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('invoice.paymentcard', [$invno, $auth]) }}" target="_blank">
                                    <button style="border: 1px solid #003264; background: white; cursor: pointer; font-family: Outfit, sans-serif; font-weight: 300; padding: 15px; color: #003264; max-width: 200px; text-transform: uppercase; width: 100%;">Pay with Credit/Debit Card <small>+{{ config('constant.CC_FEE') }}% Handling Fee</small></button>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="background: #ee4c50; padding: 15px 30px;">
                            <h2 style="color: white; font-weight: bold; margin: 0 0 10px; text-transform: uppercase;"></h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 15px 30px;background:#ffffff; margin: 15px 0 0; text-align: center;">
                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;">
                                <tr style="text-align: center;">
                                    <a style="cursor: pointer;" target="_blank"><img src="{{ asset('backend/assets/img/logo/email-rehda-logo-blue.png') }}" alt="Rehda Logo" width="80" style="height: auto; margin: auto; display: block;"></a>
                                    <p style="font-size: 14px; font-weight: bold;">{!! config('constant.COMPANY_NAME') !!} <br> <small>({{ config('constant.COMPANY_REGISTRATION_NUMBER') }})</small></p>
                                    <p style="font-size: 14px;">{{ config('constant.COMPANY_ADDRESS') }}<br>{{ config('constant.COMPANY_ADDRESS1') }}<br>{{ config('constant.COMPANY_ADDRESS2') }}</p>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
