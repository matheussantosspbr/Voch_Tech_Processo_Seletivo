<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SystemLogModel extends Model
{
    protected $table = 'system_logs';
    protected $primaryKey = 'id_log_system';
    protected $keyType = 'string';
    protected $fillable = [
        'id_log_system',   
        'user',
        'method',
        'rote',
        'function',
        'class',
        'description',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_log_system)) {
                $model->id_log_system = (string) Str::uuid();
            }
        });
    }

    public static function createLog($method, $rote, $function, $class, $description)
    {
        return self::create([
            'user' => auth()->user()->name,
            'method'  => $method,
            'rote'    => $rote,
            'function' => $function,
            'class' => $class,
            'description' => $description
        ]);
    }
}
