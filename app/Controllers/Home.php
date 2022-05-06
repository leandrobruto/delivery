<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function email()
    {
        $email = \Config\Services::email();

        $email->from('your@example.com', 'Your Name');
        $email->to('someone@example.com');
        // $email->cc('another@another-example.com');
        // $email->bcc('them@their-example.com');

        $email->subject('Email Test');
        $email->message('Testing the email class.');

        if ($email->send()) {
            echo 'Email sent successfully';
        } else {
            echo $email->printDebugger();
        }
    }
}
