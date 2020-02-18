<?php

namespace App\Http\Controllers;

use App\Mail\contactoAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class emailController extends Controller
{
    public function gestionEmail(Request $request)
    {
        Mail::to('admiminlist@gmail.com')
        ->send(new contactoAdmin($request->email,$request->mensaje,$request->asunto));
    }

}
