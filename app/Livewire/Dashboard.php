<?php

namespace App\Livewire;

use App\Models\BandeirasModel;
use App\Models\ColaboradoresModel;
use App\Models\GruposEconomicosModel;
use App\Models\UnidadesModel;
use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $gruposEconomicos, $bandeiras, $unidades, $colaboradores;

    public $dataGraph = [
        'days'  => [],
        'count' => []
    ];

    public function render()
    {
        $this->gruposEconomicos = GruposEconomicosModel::count();
        $this->bandeiras        = BandeirasModel::count();
        $this->unidades         = UnidadesModel::count();
        $this->colaboradores    = ColaboradoresModel::count();

        $dataFiltro = Carbon::now()->subDays(30)->format('Y-m-d');

        $data = GruposEconomicosModel::where('created_at', '>=', $dataFiltro)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('d/m/Y'));

        foreach ($data as $date => $items) {
            $this->dataGraph['days'][]  = $date;
            $this->dataGraph['count'][] = count($items);
        }

        $this->dataGraph['days']  = array_reverse($this->dataGraph['days']);
        $this->dataGraph['count'] = array_reverse($this->dataGraph['count']);

        return view('livewire.dashboard');
    }
}
