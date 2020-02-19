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
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email)->subject($this->asunto)->view('mail');
    }
}
