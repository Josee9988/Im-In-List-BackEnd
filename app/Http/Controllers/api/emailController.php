<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\contactoAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class emailController extends Controller
{

    /**
     * gestionEmail
     * Summary: Envia un mail al admin
     *
     * @param  mixed $request -Datos para enviar el email
     *
     * @return void
     */
    public function gestionEmail(Request $request)
    {
        $peticionUrl = file_get_contents($this->url . '?secret=' . $this->private_key . '&response=' . $request->captcha);
        $estadoCaptcha = json_decode($peticionUrl)->success;

        if ($estadoCaptcha) {
            Mail::to('admiminlist@gmail.com')
                ->send(new contactoAdmin($request->email, $request->mensaje, $request->asunto));
        } else {
            return response()->json(['message' => 'Error, Actividad sospechosa']);
        }
        return response()->json(['message' => 'Error, Email no enviado'], 500);
    }
}
