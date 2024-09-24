@foreach ($memberCerts as $cert)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="{{ asset('storage').'/'.$cert->certificate_path }}" target="_blank">{{$cert->mc_yr}} <i class="fa fa-external-link-square"></i></a>
        <a href="javascript:void(0);" data-id="{{$cert->mc_id}}" class="del-cert"><i class="fa fa-trash-can text-danger"></i></a>
    </li>
@endforeach