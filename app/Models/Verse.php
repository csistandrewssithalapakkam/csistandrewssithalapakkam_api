<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verse extends Model
{
    use HasFactory;

        protected $table = 'tbl_verse';
        protected $primaryKey = 'verse_id';
        public $timestamps = true;
        const CREATED_AT = 'created_date';
        const UPDATED_AT = 'updated_date';    protected $fillable = [
        'week_date',
        'verse_tamil',
        'verse_english',
        'verse_status',
    ];

    protected $dates = ['week_date'];
}
