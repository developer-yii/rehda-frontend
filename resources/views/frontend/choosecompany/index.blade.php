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
                    if(count($upMidList) > 1) {

                        foreach($upMidList as $up_mid) {
                            $memberComps = App\Models\MemberComp::where('did', $up_mid)->where('d_status',1)->orderBy('d_compname','ASC')->get();

                            foreach($memberComps as $memberComp){

                                @endphp

                                <div class="mb-2">
                                    <label class="radio-label">
                                        <input type="radio" class="form-check-input" name="chooseCompany" id="chooseCompany{{$memberComp->did}}" value="<?= $memberComp->did ?>">
                                        <label class="form-check-label" for="chooseCompany{{$memberComp->did}}">{{ $memberComp->d_compname }} [{{ getMembershipNo($memberComp->d_mid) }}]</label>
                                    </label>
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