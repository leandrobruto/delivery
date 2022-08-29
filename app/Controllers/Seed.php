<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Seed extends BaseController
{
    public function index()
    {
        $seeder = \Config\Database::seeder();

        $seeder->call('UsuarioSeeder');
        $seeder->call('ExpedienteSeeder');
        $seeder->call('FormasSeeder');
        
        echo 'Semeado.';
    }
}