<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Admin\Quote;
use App\Models\Admin\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    const UNSUBSCRIBE_EMAIL = 1;

    const ZONES = [
        "North",
        "South",
        "West",
        "East"
    ];
    protected $fillable = [
        'company_name',
        'first_name',
        'last_name',
        'email',
        'gst_no',
        'pan_no',
        'phone_number',
        'password',
        'id_manager',
        'role_id',
        'zone',
        'vendor_code',
        'status',
        'address',
        'apt_no',
        'zipcode',
        'city',
        'state',
    ];

    const userTypes = [
        'customer' => "Customer",
        'vendor' => "Vendor",
        'user' => "User",
    ];
    const changeTypes = [
        'customer' => "customers",
        'vendor' => "vendors",
        'user' => "users",
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = ['full_name','billing_address'];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public static function getTableName($alias = '')
    {
        $table = with(new static)->getTable();
        if($alias!==''){
            $parts = explode('as', $table);
            $_table = trim($parts[0]).' as '.$alias;
            return $_table;
        }
        return $table;
    }

    public function getFullName(){
        return trim($this->first_name.' '.$this->last_name);
    }

    public static function getApprover($userId){
            $user = User::where('id',$userId)->get()->first();
        if($user){
            return $user->full_name;
        }else{
            return 'NA';
        }
    }

    public function role(){
        return $this->belongsTo(Role::class,'role_id','id');
    }

    public function executiveQuotes()
    {
        return $this->hasMany(Quote::class, 'created_by');
    }

    public function businessHeadSubordinates()
    {
        return $this->hasMany(User::class, 'id_manager');
    }

    public function getBillingAddressAttribute() {
        $array = [
            $this->address,
            $this->apt_no,
            $this->city,
            $this->state,
            $this->zipcode,
        ];

        $array = array_filter($array);
        return implode(', ', $array).' '.$this->zip_code;
    }
}


