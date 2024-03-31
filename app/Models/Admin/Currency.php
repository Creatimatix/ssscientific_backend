<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    const currencyStatus = [
        1 => "Active",
        0 => "Inactive",
    ];
    use HasFactory;

    protected $fillable = [
        'name',
        'symbol',
        'status',
    ];
    public static function getVals($key){
        $config = null;
        if(is_array($key)){
            $results = Config::whereIn('name', $key)->get();

            if($results){
                foreach ($results as $result){
                    $config[$result->name] = $result->value;
                }
            }
        }else{
            $data = Config::where('name', $key)
                ->get()
                ->first();
            if($data){
                $config = $data->value;
            }
        }
        return $config;
    }

}
