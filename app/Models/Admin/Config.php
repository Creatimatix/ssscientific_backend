<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
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

    public static function get($key){
        if(is_array($key)){
            return Config::whereIn('name', $key)->get();
        }else{
            return Config::where('name', $key)
                ->get()
                ->first();
        }
    }
}
