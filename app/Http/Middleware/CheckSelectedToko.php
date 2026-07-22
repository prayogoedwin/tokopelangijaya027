<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSelectedToko
{
    public function handle(Request $request, Closure $next)
    {
        // Jika user sudah pilih toko, lanjutkan



        // dd('here');




        if (session()->has('selected_toko_id') && session()->has('selected_toko_nama')) {
            return $next($request);
        }

        if(auth()->user()->hasRole('kasir')){
            return redirect()->route('kasir.kasir_pilihToko');
        }

        // Jika belum pilih toko, redirect ke halaman pilih toko
        return redirect()->route('kasir.pilihtoko');
    }
}