<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingAnniversary extends Model
{
    use HasFactory;

        protected $table = 'tbl_wedding_anniversary';
        protected $primaryKey = 'wa_id';
        public $timestamps = true;
        const CREATED_AT = 'created_date';
        const UPDATED_AT = 'updated_date';    protected $fillable = [
        'wa_member_id_1',
        'wa_member_id_2',
        'wa_date',
    ];

    protected $dates = ['wa_date'];

    public function member1()
    {
        return $this->belongsTo(Member::class, 'wa_member_id_1', 'member_id');
    }

    public function member2()
    {
        return $this->belongsTo(Member::class, 'wa_member_id_2', 'member_id');
    }
}
