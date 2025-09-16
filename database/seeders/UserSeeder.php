<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Master Admin',
                'cpf' => '00000000000',
                'email' => 'master@cristinocastroonline.com',
                'password' => Hash::make('U2JxmL31k'),
                'role' => 'master'
            ],
            [
                'name' => 'Admin',
                'cpf' => '11111111111',
                'email' => 'admin@cristinocastroonline.com',
                'password' => Hash::make('X9XYPD8cQ'),
                'role' => 'admin'
            ],
            [
                'name' => 'cidadao',
                'cpf' => '22222222222',
                'email' => 'cidadao@cristinocastroonline.com',
                'password' => Hash::make('X9XYPD8cQ'),
                'role' => 'cidadao'
            ],
        ];

        foreach ($users as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']], // procura pelo email
                [
                    'name' => $userData['name'],
                    'cpf' => $userData['cpf'], 
                    'password' => $userData['password']
                ]
            );

            $user->syncRoles([$userData['role']]); // garante que ele terá apenas essa role
        }

        $this->command->info('Usuários iniciais criados com sucesso!');
    }
}
