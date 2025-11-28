<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroBanner extends Model
{
    use HasFactory;

        protected $table = 'tbl_hero_banner';
        protected $primaryKey = 'hb_id';
        public $timestamps = true;
        const CREATED_AT = 'created_date';
        const UPDATED_AT = 'updated_date';    protected $fillable = [
        'hb_text',
        'hb_image_url',
        'hb_status',
    ];
}
