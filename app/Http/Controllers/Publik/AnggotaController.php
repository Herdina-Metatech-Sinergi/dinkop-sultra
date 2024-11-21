<?php

namespace App\Http\Controllers\Publik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    //

    public function cek_anggota(){
        return view('publik.cek-anggota');
    }
}
