<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UnidadesModel extends Model
{
    protected $table = 'unidades';
    protected $primaryKey = 'id_unidade';
    protected $keyType = 'string';
    protected $fillable = [
        'id_unidade',
        'nome_fantasia',
        'razao_social',
        'cnpj',
        'id_bandeira',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_unidade)) {
                $model->id_unidade = (string) Str::uuid();
            }
        });
    }

    public function bandeiras()
    {
        return $this->belongsTo(
            BandeirasModel::class,
            'id_bandeira',
            'id_bandeira'
        );
    }
}
