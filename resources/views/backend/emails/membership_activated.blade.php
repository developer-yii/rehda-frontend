@php
    $fontUrl = asset('backend\assets\css\webfonts');
@endphp
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
            src: url('{{ asset("backend/assets/css/webfonts/Outfit-Regular.ttf") }}');
        }

        @font-face {
            font-family: "Outfit", sans-serif;
            font-weight: 400;
            src: url('{{ asset("backend/assets/css/webfonts/Outfit-Bold.ttf") }}');
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
                            <a style="cursor: pointer;" target="_blank"><img src="{{ asset('backend/assets/img/logo/email-rehda-logo-white.png') }}" alt="Logo" width="150" style="height: auto; display: block;"></a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:36px 30px 42px 30px;">
                            <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr style="margin-bottom: 0 0 10px !important;">
                                    <td style="padding:0 0 30px 0; color:#003264;">
                                        <p>Hi {{ $fname }},</p>
                                        <h1 style="font-size:24px; font-weight: bold; margin:0 0 15px 0;">Your Account Info</h1>

                                        <p style="margin:0 0 5px 0;font-size:16px;line-height:24px;">
                                            <span style="font-weight: bold;">Company Name: </span>{{ $compname }}
                                        </p>

                                        <p style="margin:0 0 5px 0;font-size:16px;line-height:24px;">
                                            <span style="font-weight: bold;">URL: </span><a href="{{ config('constant.SITE2') }}">{{ config('constant.SITE2') }}</a>
                                        </p>

                                        <p style="margin:0 0 5px 0;font-size:16px;line-height:24px;">
                                            <span style="font-weight: bold;">Username: </span>{{ $uname }}
                                        </p>

                                        <p style="margin:0 0 5px 0;font-size:16px;line-height:24px;">
                                            <span style="font-weight: bold;">Password: </span>{{ $pws }}
                                        </p>

                                        <hr style="margin: 1rem 0;">

                                        <p style="color: red; font-size: 14px;">
                                            * This password is auto-generated. Please change your password on your first login to the Membership Portal.
                                        </p>
                                    </td>
                                </tr>
                            </table>
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
                                    <a style="cursor: pointer;" target="_blank"><img src="{{ asset('backend/assets/img/logo//email-rehda-logo-blue.png') }}" alt="Logo" width="80" style="height: auto; margin: auto; display: block;"></a>
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
