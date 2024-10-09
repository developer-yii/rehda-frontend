@extends('layouts.auth')

@section('title', 'Select Account')

@section('auth-css')
    <link href="{{ asset('frontend/css/pages/choosecompany.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/css/pages/membership.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')

    <div class="lopgBox">
        <a href="">
        <img src="{{ asset('assets/img/rehda-logo.svg') }}" alt="">
        </a>
    </div>
    <div class="container mb-4">
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-center">
                <h3 class="card-title mb-3">Select Account</h3>
            </div>

            <div class="choose-company-section section-padding mb-5">
                <!-- <div class="container"> -->
                <div class="row">
                    <!-- <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                        <h2 class="text-center mb-4 mt-0 mt-md-4">Select Account</h2>
                    </div> -->

                    <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-sm-12 mt-4">
                        @error('chooseCompany')
                            <div class="alert alert-danger mb-4">
                                <i class="icon_error-circle_alt"></i>{{ $message }}
                            </div>
                        @enderror
                        <form name="saveaccount" id="saveaccount" method="POST" action="{{ route('saveaccount') }}">
                            @csrf

                            @if (count($upMidList) > 1)
                                @foreach ($upMidList as $up_mid)
                                    @php
                                        $memberComps = App\Models\MemberComp::where('did', $up_mid)
                                            ->where('d_status', 1)
                                            ->orderBy('d_compname', 'ASC')
                                            ->get();
                                    @endphp

                                    @foreach ($memberComps as $memberComp)
                                        <div class="row">
                                            <div class="col-md mb-md-0 mb-2">
                                                <div class="form-check custom-option custom-option-basic">
                                                    <label class="form-check-label custom-option-content"
                                                        for="{{ $memberComp->d_mid }}">
                                                        <input name="chooseCompany" class="form-check-input" type="radio"
                                                            value="{{ $memberComp->did }}" id="{{ $memberComp->d_mid }}" />
                                                        <span class="custom-option-header">
                                                            <span class="h6 mb-0">{{ $memberComp->d_compname }}
                                                                [{{ getMembershipNo($memberComp->d_mid) }}]</span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            @elseif(count($upMidList) == 1)
                                @php
                                    session(['compid' => $upMidList[0]]);
                                    header('Location: ' . route('dashboard'));
                                    exit();
                                @endphp
                            @endif

                            <div class="submit mt-3 text-center">
                                <button type="submit" name="submit" id="submit"
                                    class="btn btn-primary btn-lg waves-effect waves-light w-100">View</button>
                            </div>

                        </form>

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

        document.querySelectorAll('.custom-option-basic').forEach(div => {
            div.addEventListener('click', function() {
                // Remove class from all divs
                document.querySelectorAll('.custom-option-basic').forEach(d => {
                    d.classList.remove(
                        'checked'); // Replace 'active' with the class you want to remove
                });

                // Add class to the clicked div
                this.classList.add('checked'); // Replace 'active' with the class you want to add
            });
        });
    </script>
@endsection
