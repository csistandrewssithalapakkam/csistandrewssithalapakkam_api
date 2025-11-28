<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageFolder extends Model
{
    use HasFactory;

        protected $table = 'tbl_image_folder';
        protected $primaryKey = 'if_id';
        public $timestamps = true;
        const CREATED_AT = 'created_date';
        const UPDATED_AT = 'updated_date';    protected $fillable = [
        'if_name',
        'if_status',
    ];

    public function images()
    {
        return $this->hasMany(ImageGallery::class, 'ig_folder_id', 'if_id');
    }
}
