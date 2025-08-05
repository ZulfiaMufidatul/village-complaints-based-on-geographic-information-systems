<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportPdf(Request $request)
    {
        // dd($request->all());
        if ($request->filled('start') && $request->filled('end')) {
            $data = Complaint::whereBetween('created_at', [$request->start, $request->end])->get();
        } else {
            $data = Complaint::all();
        }
        $pdf = Pdf::loadView('export.complaints-pdf', compact('data'));
        return $pdf->download('Aduan-Infrastruktur.pdf');
    }
}
