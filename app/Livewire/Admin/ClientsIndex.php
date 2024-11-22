<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Client;
use Livewire\WithPagination;

class ClientsIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $clients = Client::paginate(5);
        return view('livewire.admin.clients-index', compact('clients'));
    }
}
