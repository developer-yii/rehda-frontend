<ul class="list-group">
@foreach ($orders  as $order)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="{{ route('active-members.generateStatement', ['year' => $order->orderyear, 'compid' => $request->pid]) }}" target="_blank">{{ $order->orderyear }} <i class="fa fa-external-link-square"></i></a>
    </li>
@endforeach
</ul>