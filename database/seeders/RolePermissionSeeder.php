<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'gerenciar usuarios',
            'criar processos',
            'dar seguimento processos',
            'assinar processos',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = [
            'diretor_licicon' => $permissions, // pode tudo
            'gerente_licicon' => ['criar processos', 'dar seguimento processos', 'assinar processos'], // tudo menos gerenciar usuários
            'colaborador_licicon' => ['dar seguimento processos'], // só dar seguimento
            'prefeitura' => ['assinar processos'], // só assinar
        ];

        foreach ($roles as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($perms);
        }

        $this->command->info('Roles e permissões criadas com sucesso!');
    }
}
