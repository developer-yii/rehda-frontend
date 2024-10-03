<?php
    $getBackgroundStyle = getBackgroundStyle();
?>
@extends('layouts.auth')

@section('title', 'Select Account')

@section('content')

<style>
    #downButton{
        /* left: 95%; */
        /* top: 90%; */
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }
</style>

<div class="container">
<div class="card mt-5">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h5 class="card-title mb-3">Rehda Member Portal</h5>
        </div>

        <div class="choose-company-section section-padding mb-5">
            <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                        <div class="title mt-2">
                            <h3>Select Account</h3>
                        </div>
                    </div>

                    <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-sm-12">
                    <form name="saveaccount" id="saveaccount" method="POST" action="{{ route('saveaccount') }}">
                    @csrf

                    @php
                    if(count($upMidList) > 1) {

                        foreach($upMidList as $up_mid) {
                            $memberComps = App\Models\MemberComp::where('did', $up_mid)->where('d_status',1)->orderBy('d_compname','ASC')->get();

                            foreach($memberComps as $memberComp){

                                @endphp

                                <div class="row">
                                    <div class="col-md mb-md-0 mb-2">
                                    <div class="form-check custom-option custom-option-basic">
                                        <label class="form-check-label custom-option-content" for="{{ $memberComp->d_mid }}">
                                        <input
                                            name="chooseCompany"
                                            class="form-check-input"
                                            type="radio"
                                            value="<?= $memberComp->did ?>"
                                            id="{{ $memberComp->d_mid }}" />
                                        <span class="custom-option-header">
                                            <span class="h6 mb-0">{{ $memberComp->d_compname }} [{{ getMembershipNo($memberComp->d_mid) }}]</span>
                                        </span>
                                        </label>
                                    </div>
                                    </div>
                                </div>

                                @php
                            }

                        }


                    } else if(count($upMidList) == 1) {

                        session([ 'compid' => $upMidList[0] ]);
                        header('Location: ' . route('dashboard'));
                        exit();

                    }
                    @endphp

                    <div class="submit mt-3 text-center">
                        <button type="submit" name="submit" id="submit" class="btn btn-primary btn-lg waves-effect waves-light w-100">View</button>
                    </div>

                    </form>

                    </div>
                </div>
        </div>
</div>
</div>

<button type="button" class="btn btn-lg rounded-pill btn-icon btn-outline-primary waves-effect" id="downButton">
    <span class="ti ti-arrow-down"></span>
</button>

<script>
document.querySelectorAll('.custom-option-basic').forEach(div => {
    div.addEventListener('click', function() {
        // Remove class from all divs
        document.querySelectorAll('.custom-option-basic').forEach(d => {
            d.classList.remove('checked'); // Replace 'active' with the class you want to remove
        });

        // Add class to the clicked div
        this.classList.add('checked'); // Replace 'active' with the class you want to add
    });
});

document.getElementById('downButton').addEventListener('click', function() {
    window.scrollTo({
        top: document.body.scrollHeight,
        behavior: 'smooth' // Smooth scroll effect
    });
});
</script>


@endsection