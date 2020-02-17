<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class emailController extends Controller
{
    public function gestionEmail(Request $request){

        $data = array(
            'name'=>'prueba'
        );

        Mail::send('mail',$data,function($message){

            $message->from('a@gmail.com');
            $message->to('admiminlist@gmail.com');
        });

    }
}
