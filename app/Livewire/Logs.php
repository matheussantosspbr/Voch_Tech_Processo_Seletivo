<?php

namespace App\Livewire;

use App\Models\LogsModel;
use Livewire\Component;

class Logs extends Component
{
    public $logs;

    public function render()
    {
        $this->logs = LogsModel::orderBy('created_at', 'desc')->get();
        return view('livewire.logs');
    }
}
