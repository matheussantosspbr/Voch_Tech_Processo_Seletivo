<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BandeirasModel extends Model
{
    protected $table = 'bandeiras';
    protected $primaryKey = 'id_bandeira';
    protected $keyType = 'string';
    protected $fillable = [
        'id_bandeira',
        'nome',
        'id_grupo_economico',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_bandeira)) {
                $model->id_bandeira = (string) Str::uuid();
            }
        });
    }

    public function gruposEconomicos()
    {
        return $this->belongsTo(
            GruposEconomicosModel::class,
            'id_grupo_economico',
            'id_grupo_economico'
        );
    }
}
