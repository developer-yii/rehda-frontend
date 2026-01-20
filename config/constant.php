<?php

return [
    'MNP1' => 'HDA',
    'MNP2' => '/',
    'MAX_IMG_FILESIZE_MB' => env('MAX_IMG_FILESIZE_MB', '1'),
    'MAX_PDF_FILESIZE_MB' => env('MAX_PDF_FILESIZE_MB', '10'),
    'COMP_NAME2' => env('COMP_NAME2', 'REHDA Membership'),
    'ADMIN_EMAIL' => env('ADMIN_EMAIL', 'noreply@rehda.com'),
    'SMTP_USED' => env('SMTP_USED', 'sendinblue'),
    'SENDINBLUE' => env('SENDINBLUE', ''),
    'COMPANY_NAME' => env('COMPANY_NAME', 'PERSATUAN PEMAJU HARTANAH DAN PERUMAHAN MALAYSIA <br> REAL ESTATE AND HOUSING DEVELOPERS’ ASSOCIATION MALAYSIA'),
    'COMPANY_REGISTRATION_NUMBER' => env('COMPANY_REGISTRATION_NUMBER', '(PPM-002-10-21051970)'),
    'COMPANY_ADDRESS' => env('COMPANY_ADDRESS', 'WISMA REHDA, NO 2C,'),
    'COMPANY_ADDRESS1' => env('COMPANY_ADDRESS1', 'JALAN SS 5D/6, KELANA JAYA,'),
    'COMPANY_ADDRESS2' => env('COMPANY_ADDRESS2', '47301 PETALING JAYA, SELANGOR'),
    'SITE2' => env('SITE2', 'https://members.rehda.com/'),
    'ORDERID_SET' => env('ORDERID_SET', 'RDM'),
    'PR_ORDERID_SET' => env('PR_ORDERID_SET', 'MRM'),
    'RECEIPTID_SET' => env('RECEIPTID_SET', 'OR'),
    'ENTRANCE_FEE_LABEL' => env('ENTRANCE_FEE_LABEL', 'Entrance Fee'),
    'FEE_LABEL' => env('FEE_LABEL', 'Subscription Fee'),
    'RENEWAL_FEE_LABEL' => env('RENEWAL_FEE_LABEL', 'Renewal of Subscription Fee'),
    'CC_HANDLING_FEE_LABEL' => env('CC_HANDLING_FEE_LABEL', 'Service Charge – Credit/Debit Card Payment'),
    'FPX_HANDLING_FEE_LABEL' => env('FPX_HANDLING_FEE_LABEL', 'Service Charge – FPX Payment'),
    'EMAIL_TEMP_COMP_INFO' => env('EMAIL_TEMP_COMP_INFO', '<p style="margin-bottom:10px; font-size:13px; color:#9d9898;">Real Estate and Housing Developers\' Association Malaysia <span style="font-weight:500;">(PPM-002-10-21051970)</span><br>
          Wisma REHDA, No. 2C, Jalan SS 5D/6, Kelana Jaya, 47301 Petaling Jaya, Selangor <br>
          Phone: 03-78032978 &nbsp; Fax: 03-78035285 &nbsp; Email: secretariat@rehda.com</p>'),
    'EMAIL_FOOTER' => env('EMAIL_FOOTER', '<p style="font-weight: 500; font-size:13px;" class="text-right">"Towards Sustainable Development" <br>
            Responsive | Respected | Responsible | Relevant</p>'),
    'MAINDOMAIN' => env('MAINDOMAIN', 'https://members.rehda.com/'),
    'MAINDOMAINWWW' => env('MAINDOMAINWWW', 'https://members.rehda.com/'),
    'CC_FEE' => env('CC_FEE', '2.5'),
    'FPX_FEE' => env('FPX_FEE', '0'),

    // ipay merchnat credentials
    'MERCHANT_KEY' => env('MERCHANT_KEY', 'PqtEkbDgCg'),
    'MERCHANT_CODE' => env('MERCHANT_CODE', 'M29137'),
];