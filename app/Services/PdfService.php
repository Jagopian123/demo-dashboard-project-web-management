<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Quotation;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfService
{
    public function generateInvoice(Invoice $invoice)
    {
        $data = [
            'invoice' => $invoice,
            'client' => $invoice->client,
            'project' => $invoice->project,
            'items' => is_string($invoice->items)
            ? json_decode($invoice->items, true)
            : ($invoice->items ?? []),
        ];

        $pdf = Pdf::loadView('pdf.invoice', $data);
        return Pdf::loadView('pdf.invoice', $data);
    }

    public function generateQuotation(Quotation $quotation)
    {
        $data = [
            'quotation' => $quotation,
            'client' => $quotation->client,
            'items' => is_string($quotation->items)
            ? json_decode($quotation->items, true)
            : ($quotation->items ?? []),
        ];

        $pdf = Pdf::loadView('pdf.quotation', $data);
        return Pdf::loadView('pdf.quotation', $data);
    }
}