<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
// use Illuminate\Auth\Access\Gate;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;


class UsersIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;

    //  útil cuando tienes una paginación y quieres reiniciar la página a la primera cada vez que se realiza una búsqueda nueva.
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $users = User::where('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('email', 'LIKE', '%' . $this->search . '%')->paginate(); // De 15 en 15

            
        return view('livewire.admin.users-index', compact('users'));
    }
}
