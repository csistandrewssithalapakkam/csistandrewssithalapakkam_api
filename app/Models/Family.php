<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

        protected $table = 'tbl_family';
        protected $primaryKey = 'family_id';
        public $timestamps = true;
        const CREATED_AT = 'created_date';
        const UPDATED_AT = 'updated_date';    protected $fillable = ['family_status'];

    public function members()
    {
        return $this->hasMany(Member::class, 'family_id', 'family_id');
    }
}
