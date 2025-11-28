<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerRequest extends Model
{
    use HasFactory;

        protected $table = 'tbl_prayer_request';
        protected $primaryKey = 'pr_id';
        public $timestamps = true;
        const CREATED_AT = 'created_date';
        const UPDATED_AT = 'updated_date';    protected $fillable = [
        'pr_subject',
        'pr_message',
        'pr_submitted_by',
        'pr_submitted_date',
        'pr_status',
    ];

    protected $dates = ['pr_submitted_date'];
}
