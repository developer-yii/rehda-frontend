@extends('layouts.frontend.app')
@section('title', 'Home')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/home.css') }}">
@endsection
@section('content')

    <section class="section-py">
        <div class="container" id="menu-items">
            <!-- Popular Articles: Start -->
            @if (!empty($room) && $room != null)

            @else
                <h5 class="text-center mb-4">{{ __('translation.label_room_not_found') }}</h5>
            @endif
        </div>
    </section>
    <!-- Popular Articles: End -->
    <!--Passcode Modal -->
    <div class="modal modal-top fade" id="validtePasscode" tabindex="-1" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <form class="modal-content" id="validteRoomPasscode" method="post">
                @csrf
                <input type="hidden" id="room" class="room" name="room_id" value="{{ @$room->id }}"/>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTopTitle">{{ __('translation.label_passcode_room_no').' '.@$room->room_no }}</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                            <input type="text" id="passcode" class="form-control passcode" name="passcode" placeholder="{{ __('translation.placeholder_enter_passcode')}}"/>
                            <span class="error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">{{ __('translation.label_submit') }}</button>
                </div>
            </form>
        </div>
    </div>
    <!--End Modal -->
@endsection

@section('page-js')
    <script>
        var getItemsList = "{{ route('order.getitems') }}";
        var getOrderItems = "{{ route('order.getorderitems') }}";
        var saveItems = "{{ route('order.saveitems') }}";
        var saveMaintenance = "{{ route('order.savemaintenance') }}";
        var saveSpaPackage = "{{ route('order.save.spapackage') }}";
        var saveCarType = "{{ route('order.save.cartype') }}";
        var deleteOrderItem = "{{ route('order.delete') }}";
        var validateRoomPasscode = "{{ route('order.validate.passcode') }}";
        var room_id = "{{ $room->id ?? '' }}";
    </script>
    <script src="{{ asset('assets/js/pages/home.js?v=' . assetVersion() . time()) }}"></script>
@endsection
