<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {

        $data = [
            'titulo' => 'Seja bem vindo(a)!', 
        ];
        
        return view('Home/index', $data);
    }

    public function email()
    {
        $email = \Config\Services::email();

        $email->setFrom('your@example.com', 'Your Name');
        $email->setTo('sowadok608@chokxus.com');
        // $email->setCC('another@another-example.com');
        // $email->setBCC('them@their-example.com');

        $email->setSubject('Email Test');
        $email->setMessage('Testing the email class.');

        if ($email->send()) {
            echo 'Email sent successfully';
        } else {
            echo $email->printDebugger();
        }
    }
}
