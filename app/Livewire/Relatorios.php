<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\GruposEconomicosModel;
use App\Models\BandeirasModel;
use App\Models\UnidadesModel;
use App\Models\ColaboradoresModel;
use App\Models\SystemLogModel;
use Exception;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Relatorios extends Component
{
    public $report_title;
    public $report = [];
    public $filter = [];
    public $colunas = [];
    public $col_dinamic = [];

    public function render()
    {
        return view('livewire.relatorios');
    }

    private function formatReport(){
        $cols = Schema::getColumnListing($this->report_title);
        $this->col_dinamic = Schema::getColumnListing($this->report_title);

        $this->colunas = array_map(function($cols) {
            switch($cols) {
                case 'created_at':
                    return 'Data de Criação';
                case 'updated_at':
                    return 'Ultima Atualização';
                default:
                    return Str::title(str_replace('_', ' ', $cols));
            }
        }, $cols);
    }

    public function getReport()
    {
        try{
            switch ($this->report_title) {
                case 'grupos_economicos':
                    $this->report =GruposEconomicosModel::all();
                    break;
                case 'bandeiras':
                    $this->report = BandeirasModel::all();
                    break;
                case 'unidades':
                    $this->report = UnidadesModel::all();
                    break;
                case 'colaboradores':
                    $this->report = ColaboradoresModel::all();
                    break;
                default:
                    $this->report = [];
                    break;
            }
            $this->formatReport();

        }catch(Exception $e){
            SystemLogModel::createLog(
                'get',
                '/relatorios',
                __FUNCTION__,
                __CLASS__,
                $e->getMessage()
            );

            $this->redirect('/dashboard');
        }
    }

    public function filterReport()
    {
        try{
            switch ($this->report_title) {
                case 'grupos_economicos':
                    $this->report = GruposEconomicosModel::where('nome', 'like', '%'. ($this->filter['field_name'] ?? '') .'%')
                        ->orderBy($this->filter['field_order_title'] ?? 'created_at', $this->filter['field_order'] ??'asc')
                        ->get();
                    break;
                case 'bandeiras':
                    $this->report = BandeirasModel::where('nome', 'like', '%' . ($this->filter['field_name'] ?? '') . '%')
                        ->when(!empty($this->filter['field_id_rel']), function ($query) {
                            $query->where('id_grupo_economico', $this->filter['field_id_rel']);
                        })
                        ->orderBy($this->filter['field_order_title'] ?? 'created_at', $this->filter['field_order'] ?? 'asc')
                        ->get();
                    break;
                case 'unidades':
                    $this->report = UnidadesModel::where('nome_fantasia', 'like', '%' . ($this->filter['field_name_fantasy'] ?? '') . '%')
                        ->when(!empty($this->filter['field_corporate_reason']), function ($query) {
                            $query->where('razao_social', 'like', '%' . $this->filter['field_corporate_reason'] . '%');
                        })
                        ->when(!empty($this->filter['field_cnpj']), function ($query) {
                            $query->where('cnpj', 'like', $this->filter['field_cnpj']);
                        })
                        ->when(!empty($this->filter['field_id_rel']), function ($query) {
                            $query->where('id_bandeira', $this->filter['field_id_rel']);
                        })
                        ->orderBy($this->filter['field_order_title'] ?? 'created_at', $this->filter['field_order'] ?? 'asc')
                        ->get();
                    break;
                case 'colaboradores':
                    $this->report = ColaboradoresModel::where('nome', 'like', '%' . ($this->filter['field_name'] ?? '') . '%')
                        ->when(!empty($this->filter['field_email']), function ($query) {
                            $query->where('email', 'like', '%' . $this->filter['field_email'] . '%');
                        })
                        ->when(!empty($this->filter['field_cpf']), function ($query) {
                            $query->where('cpf', $this->filter['field_cpf']);
                        })
                        ->when(!empty($this->filter['field_id_rel']), function ($query) {
                            $query->where('id_unidade', $this->filter['field_id_rel']);
                        })
                        ->orderBy($this->filter['field_order_title'] ?? 'created_at', $this->filter['field_order'] ?? 'asc')
                        ->get();
                    break;
                default:
                    $this->report = [];
                    break;
            }
            
        }catch(Exception $e){
            SystemLogModel::createLog(
                'get',
                '/relatorios',
                __FUNCTION__,
                __CLASS__,
                $e->getMessage()
            );

            $this->redirect('/dashboard');
        }
    }

    public function export()
    {
        try{
            $fileName = 'relatorio_' . ($this->report_title ?? 'dados') . '.csv';

            return response()->streamDownload(function() {

                $output = fopen('php://output', 'w');

                $rowHead = [];

                foreach ($this->colunas as $col) {

                    array_push($rowHead, mb_convert_encoding($col, 'ISO-8859-1', 'UTF-8'));
                    
                }

                fputcsv($output, $rowHead, ';');

                foreach ($this->report as $row) {
                    $rowArray = $row instanceof \Illuminate\Database\Eloquent\Model ? $row->toArray() : (array)$row;

                    $linha = [];
                    foreach ($this->col_dinamic as $col) {
                        $value = $rowArray[$col] ?? '';

                        if (in_array($col, ['created_at', 'updated_at']) && $value) {
                            $value = date('d/m/Y H:i', strtotime($value));
                        }

                        if (in_array($col, ['cnpj', 'cpf', 'documento', 'id'])) {
                            $value = "'" . $value;
                        }

                        $linha[] = $value;
                    }

                    fputcsv($output, mb_convert_encoding($linha, 'ISO-8859-1', 'UTF-8'), ';');
                }

                fclose($output);

            }, $fileName, [
                'Content-Type' => 'text/csv',
            ]);
        }catch(Exception $e){
            SystemLogModel::createLog(
                'get',
                '/relatorios',
                __FUNCTION__,
                __CLASS__,
                $e->getMessage()
            );

            $this->redirect('/dashboard');
        }
    }
}