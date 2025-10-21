<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GruposEconomicosModel extends Model
{
    protected $table = 'grupos_economicos';
    protected $primaryKey = 'id_grupo_economico';
    protected $keyType = 'string';
    protected $fillable = [
        'id_grupo_economico',   
        'nome',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_grupo_economico)) {
                $model->id_grupo_economico = (string) Str::uuid();
            }
        });
    }
}
