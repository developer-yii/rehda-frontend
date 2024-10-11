@extends('layouts.auth')

@section('title', 'Membership')

@section('auth-css')
    <link href="{{ asset('frontend/css/pages/membership.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/css/pages/choosecompany.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')

    <div class="lopgBox">
        <a href="{{ route('login') }}">
           <img src="{{ asset('assets/img/rehda-logo.svg') }}" alt="">
        </a>
    </div>
        <div class="container mb-4">
            <div class="card mt-1">
                <div class="card-header border-bottom d-flex justify-content-center">
                    <h3 class="card-title mb-3">Membership</h3>
                </div>

                <div class="choose-company-section section-padding mb-5">
                    <!-- <div class="container"> -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 px-5">
                            <div class="memberBox">
                                <h4 class="mainTitle">How to become a REHDA Member?</h4>
                                <p class="commonPtext">One can apply to become a member via REHDA Branch or Headquarters by filling in the Membership Application form.</p>
                                <p class="commonPtext">Upon receipt of the application form from applicants, an administration personnel will verify all the information submitted before sending it to the Branch for vetting and recommendation. On approval by the Branch Committee, the application will be tabled for the National Council’s approval.</p>
                                <p class="commonPtext">The applicants will be informed once their applications have been approved. A Membership Certificate and an Approval Letter signed by the President will be issued to the successful applicants.</p>
                                <a class="commonBtn" href="{{ route('register') }}">Membership Application</a>
                            </div>

                            <div class="typeOfmember">
                                <h3 class="mainTitle">Type Of Membership</h3>
                                <div class="row row-cols-lg-3 row-cols-md-3 row-cols-sm-1 row-cols-1">
                                    <div class="col">
                                        <div class="icon"></div>
                                        <h4 class="comInnerTitle">Ordinary Member</h4>
                                        <ul>
                                        <li>
                                            <p class="commonPtext">Any person, company, firm or corporation who carries on the business of housing and property development and undertakes such development within 5 years of membership entry.</p>
                                        </li>

                                        <li>
                                            <p class="commonPtext">A member shall belong to the branch of the Association in which it has principal housing project.</p>
                                        </li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <div class="icon"></div>
                                        <h4 class="comInnerTitle">Subsidiary/Related Member</h4>
                                        <ul>
                                        <li>
                                            <p class="commonPtext">An ordinary member who is a company, firm, or corporation who has subsidiaries or related companies, wishing to join the Association as subsidiary or related members.</p>
                                        </li>

                                        <li>
                                            <p class="commonPtext">A subsidiary or related member shall not be entitled to vote or hold office.</p>
                                        </li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <div class="icon"></div>
                                        <h4 class="comInnerTitle">Affiliate Member</h4>
                                        <ul>
                                        <li>
                                            <p class="commonPtext">An ordinary member with a branch office in another state may apply to be an Affiliate Member of the branch.</p>
                                        </li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <div class="icon"></div>
                                        <h4 class="comInnerTitle">Associate Member</h4>
                                        <ul>
                                        <li>
                                            <p class="commonPtext">Any person, company, firm or corporation who carries on the business which is related to the business of housing and property development.</p>
                                        </li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <div class="icon"></div>
                                        <h4 class="comInnerTitle">REHDA Youth Member</h4>
                                        <ul>
                                        <li>
                                            <p class="commonPtext">An executive employee of ordinary members, under the age of forty years, is eligible for REHDA Youth membership.</p>
                                        </li>

                                        <li>
                                            <p class="commonPtext">The REHDA Youth membership is limited to a maximum of two eligible employees for each ordinary member.</p>
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="benefitBox">
                                <h3 class="mainTitle">member-benefit</h3>
                                <p class="commonPtext">REHDA members get the very best information, advocacy, education and networking opportunities for their Membership! When you join the Association as a member, you automatically become a full member at the Branch level. This will benefit you in terms of your dealing with local issues and practices, as well as in federal controlled matters. REHDA offers plenty of resources to help each member make the most of this investment and connect with the benefits they value most.</p>
                                <a class="commonBtn" href="{{ route('register') }}">Membership Application</a>
                                <p class="commonPtext">By becoming a member you will enjoy the following benefits:-</p>
                                <ul>
                                    <li>
                                        <p class="commonPtext">REHDA members are kept informed with prompt regulatory and legislative alerts. <b>Updated News and Information</b> pertinent the industry is being communicated through monthly bulletins, online publications, website content and special reports. REHDA has been the nation’s leading source for housing industry information, up-to-date information and recognized as the leading voice of advocacy and governance of the real estate and housing industry.</p>
                                    </li>
                                    <li>
                                        <p class="commonPtext"><b>REHDA’s Voice of Representation</b> provides members with an effective voice before policymakers. The elected representatives in the Council focus on <b>lobbying on your behalf</b> on issues related to housing development, policies and regulations, tax policy, energy efficiency and sustainable development, transportation and infrastructure as well as <b>working with broad industry coalitions</b> on a wide range of industry matters.</p>
                                    </li>
                                    <li>
                                        <p class="commonPtext">REHDA offers an <b>invaluable networking opportunities</b> with more than 1,000 of its members. From local networking receptions and monthly membership meetings to regional trade shows, national committees and specific taskforce / working group meetings, REHDA provides hundreds of ways for you to meet and build relationships with fellow industry professionals, future customers and suppliers.</p>
                                    </li>
                                    <li>
                                        <p class="commonPtext">The education arm of the Association, REHDA Institute provides you with the tools to gain an edge in the industry. In today’s competitive marketplace, differentiation is the key to success and REHDA’s <b>nationally recognised education programmes</b> offer just that. Hundreds of educational programmes through conferences, courses, workshops and seminars on a wide range of subject matters are being organised regularly to cater to members’ needs. No matter what your interest is, REHDA has the curriculum, instructors and prestige to boost your success.</p>
                                    </li>
                                    <li>
                                        <p class="commonPtext"><b>Exposure to the Latest Building Products and Services</b> through direct contact with industry vendors. As a REHDA member, you get to attend REHDA’s product talks at a special members’ price and get a first-hand insight into the latest products and technology services available in the market.</p>
                                    </li>
                                    <li>
                                        <p class="commonPtext"><b>Professional Recognition</b> through REHDA, members can enhance their professional credibility and visibility by belonging to one of the nation’s most highly respected and widely known trade associations.</p>
                                    </li>
                                    <li>
                                        <p class="commonPtext"><b>The Membership Directory</b> is another great way to acquire information and get connected with fellow REHDA members. Look up in the REHDA Directory to locate a member or find a joint-venture partner.</p>
                                    </li>
                                    <li>
                                        <p class="commonPtext"><b>The Daily News Clipping Alert and Industry Updates</b> are regularly circulated to members via email to keep them abreast with the latest news and updates pertaining to the property and real estate industry.</p>
                                    </li>
                                    <li>
                                        <p class="commonPtext"><b>Members’ Login in REHDA website</b> is another exclusive benefit of being a REHDA member. Loaded with information, members are provided with login ID and password for access to specified sections of the websites, containing extensive list of policies, guidelines, procedures and all useful information that one needs to know related to the real estate and housing industry. Members will also have access to shared information, subscribed by REHDA.</p>
                                    </li>
                                    <li>
                                        <p class="commonPtext"><b>Enquiries on Industry</b> – REHDA’s strong Industry Affairs Team at the REHDA Secretariat provides assistance to members’ queries on housing and real estate matters. They should be able to refer you to the appropriate channel in the event answers are not readily available.</p>
                                    </li>
                                    <li>
                                        <p class="commonPtext"><b>Members’ Lounge</b>, a lounge with members’ comfort in mind. Members are welcome to use the lounge for discussion on business matters. Facilities available include light snacks, coffee/tea making facility, ASTRO and complimentary Wi-Fi connection.</p>
                                    </li>
                                    <li>
                                        <p class="commonPtext">Unlimited usage of <b>REHDA’s Resource Centre</b> where members are strongly encouraged to frequent and utilise the facility which is fully equipped with journals, guidelines, acts and publication of government reports on a wide range of topics relevant to the property industry.</p>
                                    </li>
                                </ul>
                            </div>

                            <div class="ourInformation">
                                <div class="table-responsive">
                                    <table class="table">
                                    <thead>
                                        <tr>
                                        <th width="30%">Type Of Membership</th>
                                        <th width="30%">Entrance Fee</th>
                                        <th colspan="2">Yearly Subscription Fee</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                        <td rowspan="5">Ordinary</td>
                                        <td rowspan="5">RM 2,000</td>
                                        <td colspan="2">3 tiers based on paid-up Capital of the Company as follows:</td>
                                        </tr>
                                        <tr>
                                        <td>Paid up capital</td>
                                        <td>Subscription</td>
                                        </tr>
                                        <tr>
                                        <td>Over RM 10 million</td>
                                        <td>RM 5,000</td>
                                        </tr>
                                        <tr>
                                        <td>Over RM 3 - 10 million</td>
                                        <td>RM 2,000</td>
                                        </tr>
                                        <tr>
                                        <td>RM 3 million and below</td>
                                        <td>RM 1,000</td>
                                        </tr>
                                        <tr>
                                        <td>Subsidiary / Related</td>
                                        <td>Not required but to qualify for subsidary / related membership, one of the companies under the group must be an ordinary member.</td>
                                        <td colspan="2">RM 100 per company</td>
                                        </tr>
                                        <tr>
                                        <td>Affiliate</td>
                                        <td>Not required but the member concerned must be an ordinary member with any branch</td>
                                        <td colspan="2">RM 250</td>
                                        </tr>
                                        <tr>
                                        <td>Associate</td>
                                        <td>RM 500</td>
                                        <td colspan="2">RM 500</td>
                                        </tr>
                                        <tr>
                                        <td>REHDA Youth</td>
                                        <td>No entrance fee</td>
                                        <td colspan="2">RM 500 per individual</td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>

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