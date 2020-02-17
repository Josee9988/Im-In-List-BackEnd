<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class emailController extends Controller
{
    public function gestionEmail(Request $request){

        Mail::send('mail',$request->contenido,function($message){

            $message->from('$request->email');
            $message->to('admiminlist@gmail.com')->subject();
        });

    }
}
