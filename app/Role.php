<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const PERM_PROCESS_IMPREST = 0;
    const PERM_EDIT_IMPREST = 1;
    const PERM_FINALIZE_IMPREST =2;
    const PERM_PROCESS_SURRENDER_IMPREST = 3;
    const PERM_EDIT_SURRENDER_IMPREST = 4;
    const PERM_FINALIZE_SURRENDER_IMPREST = 5;
    const PERM_VIEW_USER = 6;
    const PERM_EDIR_USER = 7;
    const PERM_DELETE_USER = 8;
    const PERM_VIEW_DEPARTMENT = 9;
    const PERM_EDIT_DEPARTMENT = 10;
    const PERM_DELETE_DEPARTMENT = 11;


   protected $fillable = ['name', 'permissions'];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
