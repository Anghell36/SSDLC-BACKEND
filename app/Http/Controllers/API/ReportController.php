<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Mail;

class ReportController extends Controller
{
    public function productsReport()
        {
                $pdf = Pdf::loadView('reports.products', ['products' => Product::all()]);
                $fileName = 'products_report.pdf';
                $pdf->save(storage_path("app/public/$fileName"));

                // Enviar por correo
         Mail::raw('Adjunto el reporte de productos.', function($message) use ($fileName) {
         $message->to('destino@correo.com')->subject('Reporte de Productos')->attach(storage_path("app/public/$fileName"));
                                                                                        });

        return response()->download(storage_path("app/public/$fileName"));
         }

        public function usersReport()
        {
            $pdf = Pdf::loadView('reports.users', ['users' => User::all()]);
            $fileName = 'users_report.pdf';
            $pdf->save(storage_path("app/public/$fileName"));

        Mail::raw('Adjunto el reporte de usuarios.', function($message) use ($fileName) {
            $message->to('destino@correo.com')->subject('Reporte de Usuarios')->attach(storage_path("app/public/$fileName"));
            });

        return response()->download(storage_path("app/public/$fileName"));
    }
}
