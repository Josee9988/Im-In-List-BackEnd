<?php

namespace App\Http\Controllers;

use App\Mail\contactoAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class emailController extends Controller
{

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
