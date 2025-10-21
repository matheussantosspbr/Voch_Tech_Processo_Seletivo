<?php

namespace App\Livewire;

use App\Models\BandeirasModel;
use App\Models\LogsModel;
use App\Models\SystemLogModel;
use App\Models\UnidadesModel;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Unidades extends Component
{
    public $unidades = [];
    public $unidade;
    public $id_bandeira;
    public $bandeiras = [];
    public $cnpj, $razao_social, $nome_fantasia;

    public function render()
    {
        $this->unidades = UnidadesModel::with('bandeiras')->get();
        $this->bandeiras = BandeirasModel::all();
        return view('livewire.unidades');
    }

    public function save()
    {
        $this->validate([
            'cnpj' => [
                'required',
                function ($attribute, $value, $fail) {
                    $cnpj = preg_replace('/\D/', '', $value);

                    if (strlen($cnpj) != 14) {
                        session()->flash('error', 'CNPJ inválido.');
                        return $fail('CNPJ inválido.');
                    }

                    if (preg_match('/^(.)\1*$/', $cnpj)) {
                        session()->flash('error', 'CNPJ inválido.');
                        return $fail('CNPJ inválido.');
                    }

                    $multiplicador1 = [5,4,3,2,9,8,7,6,5,4,3,2];
                    $multiplicador2 = [6,5,4,3,2,9,8,7,6,5,4,3,2];

                    $soma = 0;
                    for ($i=0; $i<12; $i++) $soma += $cnpj[$i]*$multiplicador1[$i];
                    $dv1 = ($soma % 11 < 2) ? 0 : 11 - ($soma % 11);
                    if ($cnpj[12] != $dv1) {
                        session()->flash('error', 'CNPJ inválido.');
                        return $fail('CNPJ inválido.');
                    }

                    $soma = 0;
                    for ($i=0; $i<13; $i++) $soma += $cnpj[$i]*$multiplicador2[$i];
                    $dv2 = ($soma % 11 < 2) ? 0 : 11 - ($soma % 11);
                    if ($cnpj[13] != $dv2) {
                        session()->flash('error', 'CNPJ inválido.');
                        return $fail('CNPJ inválido.');
                    }

                    // Verifica unicidade no banco
                    if (UnidadesModel::where('cnpj', $cnpj)->exists()) {
                        session()->flash('error', 'CNPJ já cadastrado.');
                        return $fail('CNPJ já cadastrado.');
                    }
                },
            ],
        ]);

        try{
            UnidadesModel::create([
                'razao_social' => $this->razao_social,
                'nome_fantasia' => $this->nome_fantasia,
                'cnpj' => preg_replace('/\D/', '', $this->cnpj),
                'id_bandeira' => $this->id_bandeira,
            ]);

            LogsModel::createLog('Criou a unidade ' . $this->nome_fantasia, '/unidades');

            session()->forget('error');

            $this->redirect('/unidades');

        }catch(\Exception $e){
            SystemLogModel::createLog(
                'create',
                '/unidades',
                __FUNCTION__,
                __CLASS__,
                $e->getMessage()
            );
            
            $this->redirect('/dashboard');
        }

    }

    public function deleteUnit(Request $request)
    {
        try{
            $id_unidade = $request->input('id_unidade');

            $unidade = UnidadesModel::where(['id_unidade' => $id_unidade])->first();

            if (!$unidade) {
                return response()->json(['message' => 'Unidade não encontradas'], 404);
            }

            $unidade->delete();

            LogsModel::createLog('Deletou a unidade ' . $unidade->nome_fantasia, '/unidades');
            return response()->json(['success' => true, 'message' => 'Unidade excluída com sucesso!']);
            
        }catch(\Exception $e){
            SystemLogModel::createLog(
                'delete',
                '/unidades',
                __FUNCTION__,
                __CLASS__,
                $e->getMessage()
            );
            
            $this->redirect('/dashboard');
        }
    }

    public function updateUnit(Request $request)
    {
    $validated = $request->validate([
        'id_unidade' => 'required|uuid|exists:unidades,id_unidade',
        'nomeFantasia' => 'required|string|max:255',
        'razaoSocial' => 'required|string|max:255',
        'cnpj' => [
            'required',
            function($attribute, $value, $fail) {
                $cnpj = preg_replace('/\D/', '', $value);

                if (strlen($cnpj) != 14) {
                    session()->flash('error', 'CNPJ inválido.');
                    return $fail('CNPJ inválido.');
                };
                if (preg_match('/^(.)\1*$/', $cnpj)){
                    session()->flash('error', 'CNPJ inválido.');
                    return $fail('CNPJ inválido.');
                };

                $multiplicador1 = [5,4,3,2,9,8,7,6,5,4,3,2];
                $multiplicador2 = [6,5,4,3,2,9,8,7,6,5,4,3,2];

                $soma = 0;
                for ($i=0; $i<12; $i++) $soma += $cnpj[$i]*$multiplicador1[$i];
                $dv1 = ($soma % 11 < 2) ? 0 : 11 - ($soma % 11);
                if ($cnpj[12] != $dv1) {
                    session()->flash('error', 'CNPJ inválido.');
                    return $fail('CNPJ inválido.');
                };

                $soma = 0;
                for ($i=0; $i<13; $i++) $soma += $cnpj[$i]*$multiplicador2[$i];
                $dv2 = ($soma % 11 < 2) ? 0 : 11 - ($soma % 11);
                if ($cnpj[13] != $dv2) {
                    session()->flash('error', 'CNPJ inválido.');
                    return $fail('CNPJ inválido.');
                };
            },
            Rule::unique('unidades', 'cnpj')->ignore($request->id_unidade, 'id_unidade'),
        ],
        'id_bandeira' => 'required|uuid|exists:bandeiras,id_bandeira',
    ], [
        'id_unidade.required' => 'O ID da unidade é obrigatório.',
        'id_unidade.uuid' => 'O ID da unidade deve ser um UUID válido.',
        'id_unidade.exists' => 'A unidade informada não existe.',
        'nomeFantasia.required' => 'O nome fantasia é obrigatório.',
        'razaoSocial.required' => 'A razão social é obrigatória.',
        'cnpj.required' => 'O CNPJ é obrigatório.',
        'cnpj.unique' => 'O CNPJ informado já está cadastrado.',
        'id_bandeira.required' => 'A bandeira é obrigatória.',
    ]);

    try {
        $unidade = UnidadesModel::findOrFail($validated['id_unidade']);

        $cnpjLimpo = preg_replace('/\D/', '', $validated['cnpj']);

        $nomeUnidadeAnt = $unidade->nome_fantasia;

        $unidade->update([
            'nome_fantasia' => $validated['nomeFantasia'],
            'razao_social' => $validated['razaoSocial'],
            'cnpj' => $cnpjLimpo,
            'id_bandeira' => $validated['id_bandeira'],
        ]);

        LogsModel::createLog('Atualizou a unidade ' . $nomeUnidadeAnt . ' para ' . $validated['nomeFantasia'], '/unidades');

        return response()->json([
            'success' => true,
            'message' => 'Unidade atualizada com sucesso!',
        ], 200);

    } catch (\Exception $e) {

        SystemLogModel::createLog(
            'update',
            '/unidades',
            __FUNCTION__,
            __CLASS__,
            $e->getMessage()
        );

        return response()->json([
            'success' => false,
            'message' => 'Erro ao atualizar a unidade.'
        ], 500);
    }
    }
}
