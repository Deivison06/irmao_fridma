<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsuarioRequest;
use Spatie\Permission\Models\Permission;

class UsuarioController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        try {
            $users = $this->userService->getPaginatedUsers(10);

            return view('Admin.Usuarios.index', compact('users'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erro ao carregar usuários: ' . $e->getMessage());
        }
    }


    public function create()
    {
        $roles = Role::all(); // traz todos os objetos Role
        $permissions = Permission::all(); // não esqueça de carregar as permissões
        return view('Admin.Usuarios.create', compact('roles', 'permissions'));
    }

    public function store(UsuarioRequest $request)
    {
        try {
            $this->userService->createUser($request->validated());
            return redirect()->route('admin.usuarios.index')
                ->with('success', 'Usuário criado com sucesso!');
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar usuário: ' . $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        $roles = Role::all(); // agora cada $role é um objeto Role
        $permissions = Permission::all(); // se estiver usando permissões também

        return view('Admin.Usuarios.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(UsuarioRequest $request, User $user)
    {
        try {
            $this->userService->updateUser($user, $request->validated());
            return redirect()->route('admin.users.index')
                ->with('success', 'Usuário atualizado com sucesso!');
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar usuário: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            $this->userService->deleteUser($user);
            return redirect()->route('admin.users.index')
                ->with('success', 'Usuário excluído com sucesso!');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao excluir usuário: ' . $e->getMessage());
        }
    }

    public function toggleStatus(User $user)
    {
        try {
            $this->userService->toggleUserStatus($user);
            $status = $user->active ? 'ativado' : 'desativado';
            return redirect()->back()
                ->with('success', "Usuário {$status} com sucesso!");
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao alterar status do usuário: ' . $e->getMessage());
        }
    }
}
