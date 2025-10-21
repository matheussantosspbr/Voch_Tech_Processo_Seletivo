<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LogsModel extends Model
{
    protected $table = 'logs';
    protected $primaryKey = 'id_log';
    protected $keyType = 'string';
    protected $fillable = [
        'id_log',   
        'usuario',
        'descricao',
        'rota',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_log)) {
                $model->id_log = (string) Str::uuid();
            }
        });
    }

    public static function createLog($descricao, $rota)
    {
        return self::create([
            'usuario' => auth()->user()->email,
            'descricao'  => $descricao,
            'rota'    => $rota,
        ]);
    }
}
