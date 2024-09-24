@extends('layouts.app')

@section('title', 'Branch Newsletter | sorting')

@section('content')

    {{-- Content --}}
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @can('dashboard-view')
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">{{ __('translation.label_dashboard') }}</a>
                        </li>
                    @endcan
                    @can('newsletter-view')
                        <li class="breadcrumb-item active">Branch Newsletters Sort</li>
                    @endcan
                </ol>
            </nav>
        </div>

        {{-- Newsletter List Sort Table  --}}
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title mb-3">Branch Newsletters</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="accordion mt-3" id="accordionExample">
                        <div class="card accordion-item active">
                            <h2 class="accordion-header" id="headingOne">
                                <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                    data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">
                                    Sort Newsletter
                                    <small class="text-light fw-medium ms-3">Drag the item below to sort </small>
                                </button>
                            </h2>
                            <div id="accordionOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="table-responsive sorting-table-newsletter text-nowrap mt-3">
                                        <table class="table sorting-table">
                                            <tbody id="sort-table-newsletter">
                                                @if (count($newsletters) > 0)
                                                    @foreach ($newsletters as $newsletter)
                                                        <tr data-id="{{ $newsletter->bu_id }}" class="newseletter-tr">
                                                            <td>
                                                                <p>
                                                                    <i class="fa fa-arrows-alt"></i>
                                                                    {{ $newsletter->bu_name . ' ' . $newsletter->bu_yr }}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <div class="d-flex mt-3">
                                            <button id="saveOrder" class="btn btn-primary me-2">Save</button>
                                            <a href="{{ route('newsletters.index')}}" class="btn btn-label-secondary waves-effect">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script>
        var updateSort = "{{ route('newsletters.sortUpdate') }}"
    </script>
    <script src="{{ addPageJsLink('sort-newsletters.js?v=' . assetVersion() . time()) }}"></script>
@endsection
