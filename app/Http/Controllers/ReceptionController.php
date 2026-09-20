<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ReceptionController extends Controller
{
    public function index(): View
    {
        return view('reception.index');
    }
}
