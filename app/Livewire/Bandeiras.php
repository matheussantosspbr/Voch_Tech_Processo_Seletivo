<?php

namespace App\Livewire;

use App\Models\BandeirasModel;
use App\Models\GruposEconomicosModel;
use App\Models\LogsModel;
use App\Models\SystemLogModel;
use Livewire\Component;
use Illuminate\Http\Request;

class Bandeiras extends Component
{
    public $bandeiras = [];
    public $bandeira;
    public $id_grupo_economico;
    public $grupos_economicos = [];

    public function render()
    {
        $this->bandeiras = BandeirasModel::with('gruposEconomicos')->get();
        $this->grupos_economicos = GruposEconomicosModel::all();
        return view('livewire.bandeiras');
    }

    public function save()
    {
        try{
            BandeirasModel::create([
                'nome' => $this->bandeira,
                'id_grupo_economico' => $this->id_grupo_economico,
            ]);

            $this->redirect('/bandeiras');

            LogsModel::createLog('Criou a bandeira ' . $this->bandeira, '/bandeiras');

        }catch(\Exception $e){
            SystemLogModel::createLog(
                'create',
                '/bandeiras',
                __FUNCTION__,
                __CLASS__,
                $e->getMessage()
            );
            
            $this->redirect('/dashboard');
        }
    }

    public function deleteFlag(Request $request)
    {
        try{
            $id_bandeira = $request->input('id_bandeira');

            $bandeira = BandeirasModel::where(['id_bandeira' => $id_bandeira])->first();

            if (!$bandeira) {
                return response()->json(['message' => 'Grupo não encontrado'], 404);
            }

            $bandeira->delete();

            LogsModel::createLog('Deletou a bandeira ' . $bandeira->nome, '/bandeiras');
            return response()->json(['success' => true, 'message' => 'Bandeira excluída com sucesso!']);

        }catch(\Exception $e){
            SystemLogModel::createLog(
                'delete',
                '/bandeiras',
                __FUNCTION__,
                __CLASS__,
                $e->getMessage()
            );
            
            $this->redirect('/dashboard');
        }
    }

    public function updateFlag(Request $request)
    {
        $validated = $request->validate([
            'id_bandeira' => 'required|uuid|exists:bandeiras,id_bandeira',
            'id_grupo_economico' => 'required|uuid|exists:grupos_economicos,id_grupo_economico',
            'nome' => 'required|string|max:255',
        ], [
            'id_bandeira.required' => 'O ID da bandeira é obrigatório.',
            'id_bandeira.uuid' => 'O ID da bandeira deve ser um UUID válido.',
            'id_bandeira.exists' => 'A bandeira informada não existe.',

            'id_grupo_economico.required' => 'O grupo econômico é obrigatório.',
            'id_grupo_economico.uuid' => 'O grupo econômico deve ser um UUID válido.',
            'id_grupo_economico.exists' => 'O grupo econômico informado não existe.',

            'nome.required' => 'O nome é obrigatório.',
            'nome.string' => 'O nome deve ser um texto.',
            'nome.max' => 'O nome deve ter no máximo 255 caracteres.',
        ]);

        try {
            $bandeira = BandeirasModel::findOrFail($validated['id_bandeira']);

            $nomeBandeiraAnt = $bandeira->nome;

            $bandeira->update([
                'nome' => $validated['nome'],
                'id_grupo_economico' => $validated['id_grupo_economico'],
            ]);

            LogsModel::createLog('Atualizou a bandeira ' . $nomeBandeiraAnt . ' para ' . $validated['nome'], '/bandeiras');

            return response()->json([
                'success' => true,
                'message' => 'Bandeira atualizada com sucesso!',
            ], 200);

        } catch (\Exception $e) {

            SystemLogModel::createLog(
                'update',
                '/bandeiras',
                __FUNCTION__,
                __CLASS__,
                $e->getMessage()
            );

            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar a bandeira.'
            ], 500);
        }
    }

}
