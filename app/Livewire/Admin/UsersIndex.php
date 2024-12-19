<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
// use Illuminate\Auth\Access\Gate;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;

/**
 * Componente livewire para la gestión de usuarios.
 * 
 * Este componente permite:
 * - Listar usuarios por nombre o correo electrónico.
 * - Paginar los resultados.
 */
class UsersIndex extends Component
{
    use WithPagination;

    /**
     * Tema de paginación de bootstrap.
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * Filtro de búsqueda introducido por el usuario.
     * 
     * @var string
     */
    public $search;

    /**
     * Reinicia la página a la primera cada vez que se realiza una búsqueda nueva.
     * 
     * @return void
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Renderiza la vista del componente con los usuarios que coinciden con el filtro de búsqueda.
     * 
     * - Realiza una búsqueda de usuarios por nombre o correo electrónico.
     * - Pagina los resultados.
     * 
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Busca usuarios por nombre o correo electrónico con paginación.
        $users = User::where('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('email', 'LIKE', '%' . $this->search . '%')->paginate(); // De 15 en 15

        // Renderiza la vista del componente con los usuarios que coinciden con el filtro de búsqueda.  
        return view('livewire.admin.users-index', compact('users'));
    }
}
