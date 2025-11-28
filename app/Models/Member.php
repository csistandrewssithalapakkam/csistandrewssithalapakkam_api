<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

        protected $table = 'tbl_members';
        protected $primaryKey = 'member_id';
        public $timestamps = true;
        const CREATED_AT = 'created_date';
        const UPDATED_AT = 'updated_date';    protected $fillable = [
        'family_id',
        'subscription_id',
        'member_name',
        'member_email',
        'member_contact_no',
        'member_address',
        'member_dob',
        'member_status',
    ];

    protected $dates = ['member_dob'];

    public function family()
    {
        return $this->belongsTo(Family::class, 'family_id', 'family_id');
    }

    public function birthdays()
    {
        return $this->hasOne(Birthday::class, 'bd_member_id', 'member_id');
    }
}
