<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function boot() {

        static::updated(function($model){

        });
        static::updating(function ($model) {
            /*$column = $model->primaryKey;
            $record = DB::connection($model->connection)
                ->table($model->table)
                ->where($column, $model->id)
            ->first();
            $updateLog = new UpdateLog();
            $updateLog->connection = $model->connection;
            $updateLog->object = $model->table;
            $updateLog->object_id = $model->id;
            $updateLog->data = json_encode($record);
            $updateLog->created_at = time();
            $updateLog->save();*/
        });
        parent::boot();
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

    public static function getAll($columns = ['*'], $status = null) {

        if (is_array($status) || is_int($status)) {
            return (new static)->select($columns)
                ->whereIn('status', $status);
        } else {

            return (new static)->select($columns);
        }
    }

    public static function getActiveOnly($columns = ['*'], $status = 1) {
        return (new static)->select($columns)
            ->where('status', $status);
    }

    public static function getById($id, $forceStatus = false){

        $result = (new static)->where('id',(int)$id);

        if($forceStatus){
            $result = $result->where('status', 1);
        }
        return $result->first();
    }

    public function getQualifiedKeyName() {
        $table = $this->getTable();
        $parts = explode('as', $table);
        $alias = trim($parts[0]);
        if(count($parts)==2){
            $alias = trim($parts[1]);
        }
        return $alias.'.'.$this->getKeyName();
    }
}
