<?php

namespace App\Http\Helper;

class DocumentosHelper
{
    public static function formatCNPJ($cnpj)
    {
        if (strlen($cnpj) !== 14) {
            return $cnpj;
        }

        return preg_replace(
            "/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/",
            "$1.$2.$3/$4-$5",
            $cnpj
        );
    }

    public static function formatCPF($cpf)
    {
        if (strlen($cpf) !== 11) {
            return $cpf;
        }

        return preg_replace(
            "/(\d{3})(\d{3})(\d{3})(\d{2})/",
            "$1.$2.$3-$4",
            $cpf
        );
    }

}