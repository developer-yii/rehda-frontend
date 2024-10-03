@extends('layouts.auth')

@section('title', 'Select Account')

@section('auth-css')
    <link href="{{ asset('frontend/css/pages/choosecompany.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')

    <div class="container mb-4">
        <div class="card mt-5">
            <div class="card-header border-bottom d-flex justify-content-center">
                <h3 class="card-title mb-3">Terms & Conditions</h3>
            </div>

            <div class="choose-company-section section-padding mb-5">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 px-5">
                        <p><h4>REHDA Malaysia Website Terms & Conditions</h4></p>
                        <p><h5 class="mb-1">Introduction</h5></p>
                        <p>REHDA Malaysia Website is provided by the Real Estate Housing Developer’s Association (REHDA) Malaysia, a registered non-profit organization (NGO) in Malaysia under registration number PPM-002-10-21051970. Throughout the site, the terms “we,” “us,” and “our” refer to the Association. </p>

                        <p>We may change these terms at any time without notice by updating the terms shown on our website. It is the visitor’s (referred as “you”) responsibility to review our website terms when visiting the website to ensure you are aware of our latest terms and conditions. Your use of our website after a change/s has/have been made signifies your acceptance of the revised terms.</p>

                        <h5 class="mb-1" id="privacy-policy">Privacy Policy</h5>

                        <p>This page explains the Real Estate Housing Developer’s Association (REHDA) Malaysia privacy policy which includes the use and protection of any information submitted by visitors. If you choose to transact using our website, send an online form or e-mail which provides personally identifiable data, this data maybe shared where necessary with related Government agencies to serve you in the most efficient and effective manner. An example might be in terms of resolving or addressing complaints as well as responding to surveys that require escalation to related Government agencies.</p>

                        <h5 class="mb-1">Copyright</h5>

                        <p>Unless otherwise stated, the contents of <a href="https://rehda.com/" target="_blank">https://rehda.com/</a> and related REHDA websites are the copyright of REHDA Malaysia.</p>

                        <p>To reproduce any content from this website, please email <a href="mailto:secretariat@rehda.com">secretariat@rehda.com</a>.</p>

                        <h5 class="mb-1">Storage Security</h5>

                        <p>To safeguard your personal data, all electronic storage and transmission of personal data are secured and stored with appropriate security technologies.</p>

                        <h5 class="mb-1">Feedback</h5>

                        <p>We welcome all feedbacks/ inquiries, in case of any detailed information which the website may not be able to provide.</p>

                        <h5 class="mb-1">Information Collected</h5>

                        <p>No personally identifiable information is gathered during the browsing of this web site except for the information provided by you via online forms or e-mail.</p>

                        <h5 class="mb-1">Links to Other Sites</h5>

                        <p>This web site contains links to other websites and we do not take any liability for information contained on third party websites, accessed through <a href="https://rehda.com/" target="_blank">https://rehda.com/</a>. This privacy policy applies only to our website and you should be aware that other sites linked by this web site may have different privacy policies and we highly recommend that you read and understand the privacy statements of each site. </p>

                        <h5 class="mb-1" id="refund-policy">Membership Cancellation & Refund Policy</h5>

                        <p>REHDA reserves the right to refuse or withdraw the membership of its members should the applicants or members do not fulfill the REHDA Membership requirement. New applicants will be offered a full refund should we deny the application to become a member.  </p>

                        <p>Membership cancellation received within 30 days of registration is eligible to receive a full refund less RM100.00 being the administrative fee. Cancellation received after the stated deadline is not eligible for a refund.</p>

                        <p>REHDA Membership cancellation and refund request must be made officially by the Director of the company in written and send to REHDA Malaysia office addressed at <b>Wisma REHDA, No. 2C, Jalan SS5D/6, Kelana Jaya, 47301 Petaling Jaya, Selangor, Malaysia</b>.  All benefits by the member must be cancelled/returned to REHDA immediately.</p>

                        <p>Any questions or cancellation requests may be directed to REHDA Malaysia Secretariat at 03-7803 2978 or e-mail to <a href="secretariat@rehda.com" target="_blank">secretariat@rehda.com</a>.</p>

                        <h5 class="mb-1">Changes to this Policy</h5>

                        <p>If this privacy policy changes in any way, it will be updated on this page. Regularly reviewing this page ensures you are updated with the information which is collected, how it is used and under what circumstances, if any, it is shared with other parties.</p>

                        <h5 class="mb-1">Queries or Complaints</h5>

                        <p>If you have any queries or complaints about our privacy policy or the website, kindly send them to <a href="secretariat@rehda.com" target="_blank">secretariat@rehda.com</a> or get in touch with us via our Contact Us section.</p>

                        <h5 class="mb-1">Disclaimer/Indemnity</h5>

                        <p>Information held on the site is deemed accurate at the time and date of publication and REHDA Malaysia reserves the right to revise the Terms at any time.</p>

                        <p>By accessing the website, you have agreed to indemnify, defend, hold harmless REHDA and its Councils, officers, employees, consultants, agents, and affiliates, from any and all third party claims, liability, damages and/or costs (including but not limited to, legal fees) arising from your use of our website or your breach of these Terms and Conditions.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    <button type="button" class="btn btn-lg rounded-pill btn-icon btn-outline-primary waves-effect" id="upButton">
        <span class="ti ti-arrow-up"></span>
    </button>
    <button type="button" class="btn btn-lg rounded-pill btn-icon btn-outline-primary waves-effect" id="downButton">
        <span class="ti ti-arrow-down"></span>
    </button>

    <script>
        // ... existing code ...

        const upButton = document.getElementById('upButton');
        const downButton = document.getElementById('downButton');

        // Function to toggle button visibility
        function toggleButtonVisibility() {
            const scrollPosition = window.pageYOffset;
            const scrollHeight = document.documentElement.scrollHeight;
            const clientHeight = document.documentElement.clientHeight;

            upButton.style.display = scrollPosition > 100 ? 'block' : 'none';
            downButton.style.display = scrollPosition + clientHeight < scrollHeight - 100 ? 'block' : 'none';
        }

        // Initial call to set button visibility
        toggleButtonVisibility();

        // Add scroll event listener
        window.addEventListener('scroll', toggleButtonVisibility);

        // Up button click event
        upButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Down button click event
        downButton.addEventListener('click', function() {
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: 'smooth'
            });
        });
    </script>
@endsection