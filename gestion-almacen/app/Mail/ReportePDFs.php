<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportePDFs extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->view('emails.reportes')
            ->subject('Reportes de Inventario')
            ->attach(storage_path('app/public/listado_productos.pdf'))
            ->attach(storage_path('app/public/reporte_stock.pdf'));
    }
}
