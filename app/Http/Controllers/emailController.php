<?php

namespace App\Http\Controllers;

use App\Mail\contactoAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class emailController extends Controller
{

    private $private_key = '6Ld6lNkUAAAAAHNAgT-wdW4E7efCRfwJdWolGRJZ';
    private $url = 'https://www.google.com/recaptcha/api/siteverify';

    public function gestionEmail(Request $request)
    {
        $peticionUrl = file_get_contents($this->url . '?secret=' . $this->private_key . '&response=' . $request->captcha);
        $estadoCaptcha = json_decode($peticionUrl)->success;

        if ($estadoCaptcha) {
            Mail::to('admiminlist@gmail.com')
                ->send(new contactoAdmin($request->email, $request->mensaje, $request->asunto));
        }else{
            return response()->json([
                'message' => 'Error, Actividad sospechosa',
            ]);
        }

    }

}
