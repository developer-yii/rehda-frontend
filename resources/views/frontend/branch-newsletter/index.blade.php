@extends('layouts.app')

@section('title', 'Branch Newsletter')

@section('css')
<link href="{{ asset('frontend/css/pages/bulletin.css') }}"></link>
@endsection

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-end">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">{{ __('translation.label_dashboard') }}</a>
                </li>

                <li class="breadcrumb-item active">Branch Newsletter</li>

            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h5 class="card-title mb-3">Branch Newsletter</h5>
        </div>

        <div class="card-body pt-4">
            @if(count($newsletters) == 0)
            <p class="mt-3 mb-0">Stay tune for more content...</p>
            @else
            <div class="accordion accordion-flush accordion-arrow-left" id="accordionYearParent">
                @php
                $years = $newsletters->groupBy('bu_yr')->sortByDesc(function ($group, $key) {
                    return $key;
                });
                $count = 0;
                @endphp

                @foreach($years as $key => $year)
                    @php
                    $firstKey = $year->keys()->first();
                    $count++;

                    $year[$firstKey]->bu_yr = str_replace('/','-',$year[$firstKey]->bu_yr);
                    $ctype = 'newsletter';

                    $memberComp = App\Models\MemberComp::with('member')->where('did', session('compid'))->first();
                    $member = $memberComp->member;

                    $newslettersData = App\Models\Newsletter::where('bu_status', 2)
                    ->where('bu_yr', $year[$firstKey]->bu_yr)
                    ->where(function ($query) use ($ctype, $member) {
                        // HQ level condition
                        $query->where(function ($subquery) use ($ctype, $member) {
                            $subquery->where('bu_level', 'HQ')
                                ->whereIn('bu_id', function ($q) use ($ctype, $member) {
                                    // Subquery for content_mperm
                                    $q->select('cm_item')
                                        ->from('content_mperm')
                                        ->where('cm_item_type', $ctype)
                                        ->where('cm_membertype', $member['member_type']);
                                })
                                ->whereIn('bu_id', function ($q) use ($ctype, $member) {
                                    // Subquery for content_perm
                                    $q->select('cp_item')
                                        ->from('content_perm')
                                        ->where('cp_branch', $member['branchid'])
                                        ->where('cp_item_type', $ctype);
                                });
                        })
                        // Branch level condition
                        ->orWhere(function ($subquery) use ($ctype, $member) {
                            $subquery->where('bu_level', 'Branch')
                                ->where('bu_branchid', $member['branchid'])
                                ->whereIn('bu_id', function ($q) use ($ctype, $member) {
                                    // Subquery for content_mperm
                                    $q->select('cm_item')
                                        ->from('content_mperm')
                                        ->where('cm_item_type', $ctype)
                                        ->where('cm_membertype', $member['member_type']);
                                });
                        });
                    })
                    ->orderBy('bu_sorting', 'asc')
                    ->get();
                    @endphp

                    <div class="accordion-item border-bottom {{ $count < 2 ? 'active' : '' }}">
                        <div class="accordion-header d-flex justify-content-between align-items-center flex-wrap flex-sm-nowrap" id="yearid{{$year[$firstKey]->bu_yr}}">
                            <a class="accordion-button accordion-button-removearrow {{ $count < 2 ? 'collapsed' : '' }}" data-bs-toggle="collapse" data-bs-target="#target{{$year[$firstKey]->bu_yr}}" aria-expanded="false" aria-controls="yearid{{$year[$firstKey]->bu_yr}}" role="button">
                                <span>
                                    <span class="d-flex gap-2 align-items-baseline ms-3">
                                        <span class="h4 mb-1 text-white">{{ $year[$firstKey]->bu_yr }}</span>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <div id="target{{$year[$firstKey]->bu_yr}}" class="accordion-collapse collapse {{ $count < 2 ? 'show' : '' }}" data-bs-parent="#accordionYearParent">

                            <div class="row pt-4">

                                @if(count($newslettersData) == 0)
                                <h2>Newsletter {{$year[$firstKey]->bu_yr}}</h2>
                                <p>Stay tune for more content...</p>
                                @else
                                @foreach($newslettersData as $data)

                                    <div class="bulletin-desc">
                                        <div class="bg-image" style="background-image: url('{{ config('app.backendurl').'storage/'.str_replace('../','',$data->bu_img_cover) }}'"></div>

                                        <h4>{{ $data->bu_name }}</h4>
                                        <h3>{{ $data->bu_yr }}</h3>
                                        <ul>
                                            <a href="{{ config('app.backendurl').'storage/'.str_replace('../','',$data->bu_file_path) }}" target="_blank">
                                                <li>View</li>
                                            </a>
                                            <a href="{{ config('app.backendurl').'storage/'.str_replace('../','',$data->bu_file_path) }}" download>
                                                <li>Download</li>
                                            </a>
                                        </ul>
                                    </div>

                                @endforeach
                                @endif
                            </div>


                        </div>

                    </div>

                @endforeach
            </div>
            @endif

        </div>
    </div>
</div>
@endsection