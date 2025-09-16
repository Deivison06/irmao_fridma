<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'gerenciar usuarios',
            'gerenciar conteudo',
            'Solicitacao'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = [
            'master' => $permissions, // master pega tudo
            'admin' => ['gerenciar conteudo', 'Solicitacao'],
            'cidadao' => ['Solicitacao'],
        ];

        foreach ($roles as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($perms);
        }

        $this->command->info('Roles e permissões criadas com sucesso!');
    }
}
