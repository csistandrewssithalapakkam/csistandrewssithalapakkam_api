<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageGallery extends Model
{
    use HasFactory;

        protected $table = 'tbl_image_gallery';
        protected $primaryKey = 'ig_id';
        public $timestamps = true;
        const CREATED_AT = 'created_date';
        const UPDATED_AT = 'updated_date';    protected $fillable = [
        'ig_folder_id',
        'ig_text',
        'ig_image_url',
        'ig_show_flag',
        'ig_image_status',
    ];

    public function folder()
    {
        return $this->belongsTo(ImageFolder::class, 'ig_folder_id', 'if_id');
    }
}
