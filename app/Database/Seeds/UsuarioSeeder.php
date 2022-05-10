<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $usuarioModel = new \App\Models\UsuarioModel;

        $usuario = [
            'nome' => 'Leon',
            'email' => 'leon@gmail.com',
            'cpf' => '759.859.440-69',
            'telefone' => '99 - 9999-9999',
        ];

        $usuarioModel->protect(false)->insert($usuario);

        $usuario = [
            'nome' => 'cordylus',
            'email' => 'cordylus@gmail.com',
            'cpf' => '085.923.310-30',
            'telefone' => '88 - 8888-8888',
        ];

        $usuarioModel->protect(false)->insert($usuario);

        dd($usuarioModel->errors());
    }
}
