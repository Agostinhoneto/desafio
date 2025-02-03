<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DespesaRegistrada extends Mailable
{
    use Queueable, SerializesModels;

    public $despesa;

    /**
     * Create a new message instance.
     *
     * @param  mixed  $despesa
     * @return void
     */
    public function __construct($despesa)
    {
        $this->despesa = $despesa;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.despesa_registrada')
                    ->subject('Nova Despesa Registrada');
    }
}
