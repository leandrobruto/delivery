<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $usuarioModel = new \App\Models\UsuarioModel;

        $usuario = [
            'nome' => 'Ademiro',
            'email' => 'ademiro@admin.com',
            'password' => '123qweasd',
            'cpf' => '759.859.440-69',
            'telefone' => '99 - 9999-9999',
            'is_admin' => true,
            'ativo' => true,
        ];

        $usuarioModel->skipValidation(true)->protect(false)->insert($usuario);

        // dd($usuarioModel->errors());
    }
}
