<?php

namespace App\Livewire;

use App\Models\ColaboradoresModel;
use App\Models\LogsModel;
use App\Models\SystemLogModel;
use App\Models\UnidadesModel;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Colaboradores extends Component
{
    public $colaboradores = [];
    public $colaborador;
    public $id_unidade;
    public $unidades = [];
    public $nome, $email, $cpf;

    public function render()
    {
        $this->colaboradores = ColaboradoresModel::with('unidades')->get();
        $this->unidades = UnidadesModel::all();
        return view('livewire.colaboradores');
    }

    public function save()
    {
        $this->validate([
            'cpf' => [
                'required',
                function ($attribute, $value, $fail) {
                    $cpf = preg_replace('/\D/', '', $value);

                    if (strlen($cpf) != 11) {
                        session()->flash('error', 'CPF inválido.');
                        return $fail('CPF inválido.');
                    }
                    if (preg_match('/^(.)\1*$/', $cpf)) {
                        session()->flash('error', 'CPF inválido.');
                        return $fail('CPF inválido.');
                    }

                    $soma = 0;
                    for ($i = 0; $i < 9; $i++) $soma += $cpf[$i] * (10 - $i);
                    $dv1 = ($soma % 11 < 2) ? 0 : 11 - ($soma % 11);
                    if ($cpf[9] != $dv1) {
                        session()->flash('error', 'CPF inválido.');
                        return $fail('CPF inválido.');
                    }

                    $soma = 0;
                    for ($i = 0; $i < 10; $i++) $soma += $cpf[$i] * (11 - $i);
                    $dv2 = ($soma % 11 < 2) ? 0 : 11 - ($soma % 11);
                    if ($cpf[10] != $dv2) {
                        session()->flash('error', 'CPF inválido.');
                        return $fail('CPF inválido.');
                    }

                    if (ColaboradoresModel::where('cpf', $cpf)->exists()) {
                        session()->flash('error', 'CPF já cadastrado.');
                        return $fail('CPF já cadastrado.');
                    }
                },
            ],
        ]);

        try{
            ColaboradoresModel::create([
                'nome' => $this->nome,
                'email' => $this->email,
                'cpf' => preg_replace('/\D/', '', $this->cpf),
                'id_unidade' => $this->id_unidade,
            ]);

            LogsModel::createLog('Criou o colaborador ' . $this->nome, '/colaboradores');
            
            session()->forget('error');

            $this->redirect('/colaboradores');

        }catch(\Exception $e){
            SystemLogModel::createLog(
                'create',
                '/colaboradores',
                __FUNCTION__,
                __CLASS__,
                $e->getMessage()
            );
            
            $this->redirect('/dashboard');
        }

        
    }

    public function deleteCollaborator(Request $request)
    {
        

        try{
            $id_colaborador = $request->input('id_colaborador');

            $colaborador = ColaboradoresModel::where(['id_colaborador' => $id_colaborador])->first();

            if (!$colaborador) {
                return response()->json(['message' => 'Colaborador não encontrado'], 404);
            }

            $colaborador->delete();

            LogsModel::createLog('Deletou o colaborador ' . $colaborador->nome, '/colaboradores');
            return response()->json(['success' => true, 'message' => 'Colaborador excluído com sucesso!']);
        }catch(\Exception $e){
            SystemLogModel::createLog(
                'delete',
                '/colaboradores',
                __FUNCTION__,
                __CLASS__,
                $e->getMessage()
            );
            
            $this->redirect('/dashboard');
        }
    }

    public function updateCollaborator(Request $request)
    {
        $validated = $request->validate([
            'id_colaborador' => 'required|uuid|exists:colaboradores,id_colaborador',
            'nome' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'cpf' => [
                'required',
                function($attribute, $value, $fail) {
                    $cpf = preg_replace('/\D/', '', $value);

                    if (strlen($cpf) != 11) {
                        session()->flash('error', 'CPF inválido.');
                        return $fail('CPF inválido.');
                    }

                    if (preg_match('/^(.)\1*$/', $cpf)){
                        session()->flash('error', 'CPF inválido.');
                        return $fail('CPF inválido.');
                    }

                    $soma = 0;
                    for ($i = 0; $i < 9; $i++) $soma += $cpf[$i] * (10 - $i);
                    $dv1 = ($soma % 11 < 2) ? 0 : 11 - ($soma % 11);
                    if ($cpf[9] != $dv1) {
                        session()->flash('error', 'CPF inválido.');
                        return $fail('CPF inválido.');
                    }

                    $soma = 0;
                    for ($i = 0; $i < 10; $i++) $soma += $cpf[$i] * (11 - $i);
                    $dv2 = ($soma % 11 < 2) ? 0 : 11 - ($soma % 11);
                    if ($cpf[10] != $dv2) {
                        session()->flash('error', 'CPF inválido.');
                        return $fail('CPF inválido.');
                    }
                },
                Rule::unique('colaboradores', 'cpf')->ignore($request->id_colaborador, 'id_colaborador'),
            ],
            'id_unidade' => 'required|uuid|exists:unidades,id_unidade',
        ], [
            'id_colaborador.required' => 'O ID do colaborador é obrigatório.',
            'id_colaborador.uuid' => 'O ID da colaborador deve ser um UUID válido.',
            'id_colaborador.exists' => 'O colaborador informada não existe.',
            'nome.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.unique' => 'O CPF informado já está cadastrado.',
            'id_unidade.required' => 'A unidade é obrigatória.',
        ]);

        try {
            $colaborador = ColaboradoresModel::findOrFail($validated['id_colaborador']);

            $cpfLimpo = preg_replace('/\D/', '', $validated['cpf']);

            $nomeColaboradorAnt = $colaborador->nome;


            $colaborador->update([
                'nome' => $validated['nome'],
                'email' => $validated['email'],
                'cpf' => $cpfLimpo,
                'id_unidade' => $validated['id_unidade'],
            ]);

            LogsModel::createLog('Atualizou o colaborador ' . $nomeColaboradorAnt . ' para ' . $validated['nome'], '/colaboradores');

            return response()->json([
                'success' => true,
                'message' => 'Colaborador atualizado com sucesso!',
            ], 200);

        } catch (\Exception $e) {

            SystemLogModel::createLog(
                'update',
                '/colaboradores',
                __FUNCTION__,
                __CLASS__,
                $e->getMessage()
            );

            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar o colaborador.'
            ], 500);
        }
    }


}
