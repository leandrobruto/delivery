<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Testes extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Curso de app Food Delivery',
            'subTitle' => 'CodeIgniter4'
        ];

        return view('Testes/index', $data);
    }

    public function novo()
    {
        echo 'novo';
    }    
}
