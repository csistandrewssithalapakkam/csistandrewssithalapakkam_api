<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

        protected $table = 'tbl_user_role';
        protected $primaryKey = 'user_role_id';
        public $timestamps = true;
        const CREATED_AT = 'created_date';
        const UPDATED_AT = 'updated_date';    protected $fillable = [
        'user_role_name',
        'user_role_desc',
        'user_role_active',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'tbl_user_role_mapping', 'role_id', 'user_id');
    }
}
