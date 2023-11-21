<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PurchaseUpdate extends Mailable
{
    use Queueable, SerializesModels;
    var $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;   
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdfPath = storage_path('\\app\\pdfs\\'.$this->data['filename']);
        // $pdf = PDF::loadView('emails.purchase_generate', ['data' => $this->data]);
        // dd($pdfPath);
        //remitente
        $email = $this->from(
            'cristianprogramadorunsa@gmail.com',
            config(
                'miTiendAPP'
            )
        )
        //asunto
            ->subject('SE ACTUALIZO UNA ORDEN DE COMPRA')
            ->view('emails.email_purchase_update', array('data' => $this->data))
            ->attach(storage_path('app\\pdfs\\'.$this->data['filename']));
        //adjuntamos los archivos
        // if (!is_null($this->data['files'])) {
        //     foreach ($this->data['files'] as $file ) {
        //         $email->attach(
        //             $file['path'], [
        //             'as' => $file['as'],
        //             'mime' => $file['mime'],
        //             ]
        //         );
        //     }
        // }

        return $email;
    }
}

