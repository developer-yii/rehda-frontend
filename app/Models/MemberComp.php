<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberComp extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'member_comps';
    protected $primaryKey = 'did';
    const CREATED_AT = 'd_created_at';
    const UPDATED_AT = 'd_mod_at';
    const DELETED_AT = 'd_deleted_at';

    // Add the mass assignable attributes
    protected $fillable = [
        'd_mid',
        'd_mid',
        'd_parentcomp',
        'd_compname',
        'd_compadd',
        'd_compaddcity',
        'd_compaddstate',
        'd_compaddpcode',
        'd_compaddcountry',
        'd_comp_weburl',
        'd_offno',
        'd_faxno',
        'd_compssmno',
        'd_datecompform',
        'd_paidcapital',
        'd_f9ssm',
        'd_f24',
        'd_f49',
        'd_anualretuncopy',
        'd_devlicense',
        'd_devlicensecopy',
        'd_remarks',
        'd_status',
        'd_refer_branch',
        'd_mod_at',
        'd_mod_by',
        'd_compadd_3',
        'mykad_copy',
        'acknowledgement_form',
        'attachment_form',
        'nomination_form',
    ];

    // Relationship with Member
    public function member()
    {
        return $this->belongsTo(Member::class, 'd_mid', 'mid');
    }

    public function memberUserProfile()
    {
        return $this->hasOne(MemberUserProfile::class, 'up_mid', 'did');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'd_compaddstate', 'state_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'd_compaddcountry', 'country_id');
    }
}
