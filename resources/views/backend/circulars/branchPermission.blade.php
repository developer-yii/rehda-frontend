
<div class="permission-title">
    <h4 class="mb-1">Assign Branch Permission</h4>
</div>

    <ul class="list-group">
        @if (count($permissionBranch) > 0)
            @foreach ($permissionBranch as $permission)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a>{{ $permission->BranchName->bname }}</a>
                    <a href="javascript:void(0);" data-id="{{ $permission->cp_id }}" data-cpid="{{ $cp_item }}" data-cpTitle="{{ $cp_item_type }}" class="del-branch-permission"><i
                            class="fa fa-trash-can text-danger"></i></a>
                </li>
            @endforeach
        @endif
    </ul>

<div class="permission-member mt-1">
    <h4>Assign Branch<span class="required">*</span></h4>
    <small>Please click in below to assign branch, You can select multiple membership.</small>
    <input type="hidden" name="cp_id" id="cp_id" value="{{ $cp_item }}">
    <input type="hidden" name="cp_title" id="cp_title" value="{{ $cp_item_type }}">
    <select name="cp_branch[]" id="cp_branch" class="form-select" multiple>
        @if(count($branchs) > 0)
            @foreach($branchs as $branch)
            <option value="{{ $branch->bid }}">{{ $branch->bname }}</option>
            @endforeach
        @endif
    </select>
</div>
