<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\contactoAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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

        $validator = Validator::make($request->all(), [
            'asunto' => 'required|string|min:6|max:80',
            'mensaje' => 'required|string|min:10|max:516',
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        if ($estadoCaptcha) {
            Mail::to('admiminlist@gmail.com')
                ->send(new contactoAdmin($request->email, $request->mensaje, $request->asunto));
        } else {
            return response()->json(['message' => 'Error, Actividad sospechosa']);
        }
        return response()->json(['message' => 'Error, Email no enviado'], 500);
    }
}
