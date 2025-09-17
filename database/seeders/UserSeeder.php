<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Diretor Licicon',
                'cpf' => '00000000000',
                'email' => 'diretor@licicon.com',
                'password' => Hash::make('senha123'),
                'role' => 'diretor_licicon'
            ],
            [
                'name' => 'Gerente Licicon',
                'cpf' => '11111111111',
                'email' => 'gerente@licicon.com',
                'password' => Hash::make('senha123'),
                'role' => 'gerente_licicon'
            ],
            [
                'name' => 'Colaborador Licicon',
                'cpf' => '22222222222',
                'email' => 'colaborador@licicon.com',
                'password' => Hash::make('senha123'),
                'role' => 'colaborador_licicon'
            ],
            [
                'name' => 'Prefeitura',
                'cpf' => '33333333333',
                'email' => 'prefeitura@licicon.com',
                'password' => Hash::make('senha123'),
                'role' => 'prefeitura'
            ],
        ];

        foreach ($users as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'cpf' => $userData['cpf'],
                    'password' => $userData['password']
                ]
            );

            $user->syncRoles([$userData['role']]);
        }

        $this->command->info('Usuários iniciais criados com sucesso!');
    }
}
