<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $view;
    /**
     * Create a new message instance.
     */
    public function __construct($data, $view)
    {
        $this->data = $data;
        $this->view = $view;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('cristianprogramadorunsa@gmail.com','MiTiendApp'),
            subject: 'Nueva orden de compra',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // view: $this->view,
            with: [
                'data' => $this->data,
                ]    
            ,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {

        //remitente
        $email = $this->from(
            'mesagralentradas@unsa.edu.ar',
            config(
                'constants.NOMBRE_SISTEMA',
                'Laravel'
            )
        )
        //asunto
            ->subject('CONFIRMACION DE REGISTRO DE TRAMITE')
            ->view('emails.alta_tramite', array('datos' => $this->datos));
        //adjuntamos los archivos
        if (!is_null($this->datos['files'])) {
            foreach ($this->datos['files'] as $file ) {
                $email->attach(
                    $file['path'], [
                    'as' => $file['as'],
                    'mime' => $file['mime'],
                    ]
                );
            }
        }

        return $email;
    }
}
