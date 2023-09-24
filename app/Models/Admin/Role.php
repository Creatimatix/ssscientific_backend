<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ROLE_ADMIN  = 1;
    const ROLE_BUSINESS_HEAD  = 2;
    const ROLE_EXECUTIVE  = 3;
    const ROLE_CUSTOMER  = 4;
    const ROLE_VENDOR  = 5;

    const roleType = [
        'customer' => self::ROLE_CUSTOMER,
        'vendor' => Self::ROLE_VENDOR
    ];
    const roleStatus = [
        1 => "Active",
        0 => "Inactive",
    ];
    use HasFactory;

    protected $fillable = ['role_name','status'];
}
