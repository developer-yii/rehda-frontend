<tr>
    <td><p>{{ $index }}</p></td>
    <td>
        <p>{{ $item }}</p>
        @if(isset($subItem))
            <p>- {{ $subItem }}</p>
        @endif
    </td>
    <td><p>{{ isset($waived) && $waived ? '(waived)' : number_format($amount, 2) }}</p></td>
    <td><p>-</p></td>
    <td><p>{{ isset($waived) && $waived ? '(waived)' : number_format($amount, 2) }}</p></td>
</tr>