<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Birthday extends Model
{
    use HasFactory;

        protected $table = 'tbl_birthdays';
        protected $primaryKey = 'bd_id';
        public $timestamps = true;
        const CREATED_AT = 'created_date';
        const UPDATED_AT = 'updated_date';    protected $fillable = [
        'bd_member_id',
        'bd_date',
    ];

    protected $dates = ['bd_date'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'bd_member_id', 'member_id');
    }
}
