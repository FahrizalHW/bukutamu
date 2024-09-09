<?php

namespace App\Http\Controllers;

use App\Models\akun_tujuan;
use Illuminate\Http\Request;
use App\Models\AkunTujuan;

class AkunTujuanController extends Controller
{

public function showAkunTujuanModal()
{
    $akunTujuan = akun_tujuan::all();

    return view('form.form', compact('akunTujuan'));
}
}
