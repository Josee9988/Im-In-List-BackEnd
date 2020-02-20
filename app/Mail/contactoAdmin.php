<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class contactoAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $mensaje;
    public $asunto;

    /**
     * __construct
     * Summary: Crea una nueva instancia de mensaje con las variables recibidas
     *
     * @param  mixed $email    - Email del usuario que recibe
     * @param  mixed $mensaje  - Mensaje del usuario
     * @param  mixed $asunto   - Asunto del mail del usuario
     *
     * @return void
     */
    public function __construct($email,$mensaje,$asunto)
    {   
        $this->email = $email;
        $this->mensaje = $mensaje;
        $this->asunto = $asunto;
    }

    /**
     * build
     * Summary: Coje los datos recibidos y mediante una vista se envia el mail
     *
     * @return void
     */
    public function build()
    {
        return $this->from($this->email)->subject($this->asunto)->view('mail');
    }
}
