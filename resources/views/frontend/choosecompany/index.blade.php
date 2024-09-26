<?php
    $getBackgroundStyle = getBackgroundStyle();
?>
@extends('layouts.auth')

@section('title', 'Select Account')

@section('content')

<div class="card">

    <div class="card-body pt-4">
        <h5 class="card-title mb-3">Rehda Member Portal</h5>

        <div class="choose-company-section section-padding">
            <!-- <div class="container"> -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                        <div class="title">
                            <h2>Select Account</h2>
                        </div>
                    </div>

                    <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-sm-12">
                    <form name="saveaccount" id="saveaccount" method="POST" action="{{ route('saveaccount') }}">
                    @csrf
                    @php
                    if ($userProfiles->count() > 0) {
                        foreach ($userProfiles as $profile) {

                            $companies = App\Models\MemberComp::where('did', $profile->up_mid)->where('d_status', 1)->orderBy('d_compname')->get();

                            foreach ($companies as $company) {
                                @endphp

                                <div class="form-text">
                                    <label class="radio-label">
                                        <input type="radio" class="radio-input" name="chooseCompany" value="<?= $company->did ?>">
                                        <!-- <div class="radio-design"></div> -->
                                        <!-- <div class="radio-text">{{ $company->d_compname }} []</div> -->
                                        <span class="radio-text">{{ $company->d_compname }} [{{ auth()->user()->ml_username }}]</span>
                                    </label>
                                </div>

                                @php

                            }
                        }
                    }
                    @endphp
                    <div class="submit">
                        <input type="submit" name="submit" id="submit" value="View" class="btn btn-outline-primary waves-effect">
                    </div>

                    </form>

                    </div>
                </div>
        </div>

    </div>
</div>


@endsection