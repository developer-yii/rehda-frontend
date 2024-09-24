
<div class="permission-title">
    <h4 class="mb-1">Assign Membership Permission</h4>
</div>

    <ul class="list-group">
        @if (count($permissionMember) > 0)
            @foreach ($permissionMember as $permission)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a>{{ $permission->memberTypeName->typename }}</a>
                    <a href="javascript:void(0);" data-id="{{ $permission->cm_id }}" data-cmid="{{ $cm_item }}" data-cmTitle="{{ $cm_item_type }}" class="del-permission"><i
                            class="fa fa-trash-can text-danger"></i></a>
                </li>
            @endforeach
        @endif
    </ul>

<div class="permission-member mt-1">
    <h4>Assign Membership<span class="required">*</span></h4>
    <small>Please click in below to assign membership, You can select multiple membership.</small>
    <input type="hidden" name="cm_id" id="cm_id" value="{{ $cm_item }}">
    <input type="hidden" name="cm_title" id="cm_title" value="{{ $cm_item_type }}">
    <select name="cm_membertype[]" id="cm_membertype" class="form-select" multiple>
        @if(count($memberTypes) > 0)
            @foreach($memberTypes as $memberType)
            <option value="{{ $memberType->mt_id }}">{{ $memberType->typename }}</option>
            @endforeach
        @endif
    </select>
</div>
