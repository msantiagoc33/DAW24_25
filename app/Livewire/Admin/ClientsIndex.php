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
        $clients = Client::orderBy('id', 'desc')->paginate(12);

        return view('livewire.admin.clients-index', compact('clients'));
    }
}
