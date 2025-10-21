<?php

namespace App\Livewire;

use App\Models\BandeirasModel;
use App\Models\ColaboradoresModel;
use App\Models\GruposEconomicosModel;
use App\Models\UnidadesModel;
use Livewire\Component;

class Dashboard extends Component
{
    public $gruposEconomicos, $bandeiras, $unidades, $colaboradores;

    public function render()
    {
        $this->gruposEconomicos = GruposEconomicosModel::count();
        $this->bandeiras = BandeirasModel::count();
        $this->unidades = UnidadesModel::count();
        $this->colaboradores = ColaboradoresModel::count();
        
        return view('livewire.dashboard');
    }


}
