<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ColaboradoresModel extends Model
{
    protected $table = 'colaboradores';
    protected $primaryKey = 'id_colaborador';
    protected $keyType = 'string';
    protected $fillable = [
        'id_colaborador',
        'nome',
        'email',
        'cpf',
        'id_unidade',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_colaborador)) {
                $model->id_colaborador = (string) Str::uuid();
            }
        });
    }

    public function unidades()
    {
        return $this->belongsTo(
            UnidadesModel::class,
            'id_unidade',
            'id_unidade'
        );
    }
}
