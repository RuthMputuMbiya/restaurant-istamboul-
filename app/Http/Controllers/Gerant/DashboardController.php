<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('gerant.dashboard');
    }
}