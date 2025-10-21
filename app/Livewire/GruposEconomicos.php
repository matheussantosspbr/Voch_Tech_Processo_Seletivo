<?php

namespace App\Livewire;

use App\Models\GruposEconomicosModel;
use App\Models\LogsModel;
use App\Models\SystemLogModel;
use Exception;
use Illuminate\Http\Request;
use Livewire\Component;

class GruposEconomicos extends Component
{
    public $grupo_economico = '';

    public function render()
    {
        $grupos_economicos = GruposEconomicosModel::all();
        return view('livewire.grupos-economicos', compact('grupos_economicos'));
    }

    public function save()
    {
        try{
            GruposEconomicosModel::create([
                'nome' => $this->grupo_economico,
            ]);

            LogsModel::createLog('Criou o grupo econômico ' . $this->grupo_economico, '/grupos_economicos');

            $this->redirect('/grupos_economicos');
        }catch(Exception $e){
            SystemLogModel::createLog(
                'create',
                '/grupos_economicos',
                __FUNCTION__,
                __CLASS__,
                $e->getMessage()
            );
            
            $this->redirect('/dashboard');
        }

    }

    public function deleteGroup(Request $request)
    {
        try{
            $id_grupo_economico = $request->input('id_grupo_economico');

            $grupo = GruposEconomicosModel::where(['id_grupo_economico' => $id_grupo_economico])->first();

            if (!$grupo) {
                return response()->json(['message' => 'Grupo não encontrado.'], 404);
            }

            $grupo->delete();
            
            LogsModel::createLog('Deletou o grupo econômico ' . $grupo->nome, '/grupos_economicos');

            return response()->json(['success' => true, 'message' => 'Grupo excluído com sucesso!']);
        }catch(Exception $e){
            SystemLogModel::createLog(
                'delete',
                '/grupos_economicos',
                __FUNCTION__,
                __CLASS__,
                $e->getMessage()
            );
            
            $this->redirect('/dashboard');
        }

        
    }

    public function updateGroup(Request $request)
    {

        $validated = $request->validate([
            'id_grupo_economico' => 'required|uuid|exists:grupos_economicos,id_grupo_economico',
            'nome' => 'required|string|max:255',
        ], [
            'id_grupo_economico.required' => 'O ID do grupo econômico é obrigatório.',
            'id_grupo_economico.uuid' => 'O ID do grupo econômico deve ser um UUID válido.',
            'id_grupo_economico.exists' => 'O Id do grupo econômico informado não existe.',
            'nome.required' => 'O nome é obrigatório.',
            'nome.string' => 'O nome deve ser um texto.',
            'nome.max' => 'O nome deve ter no máximo 255 caracteres.',
        ]);

        try {
            
            $grupo = GruposEconomicosModel::findOrFail($validated['id_grupo_economico']);
            $nameGrupoAnt = $grupo->nome;

            $grupo->update([
                'nome' => $validated['nome'],
            ]);

            LogsModel::createLog('Atualizou o grupo econômico ' . $nameGrupoAnt . ' para ' . $validated['nome'], '/grupos_economicos');

            return response()->json([
                'success' => true,
                'message' => 'Grupo econômico atualizado com sucesso!',
            ], 200);

        } catch (\Exception $e) {

            SystemLogModel::createLog(
                'update',
                '/grupos_economicos',
                __FUNCTION__,
                __CLASS__,
                $e->getMessage()
            );

            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar o grupo econômico.',
            ], 500);
        }
    }



    
}
 