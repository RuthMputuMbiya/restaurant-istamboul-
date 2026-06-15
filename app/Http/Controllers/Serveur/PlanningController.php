<?php

namespace App\Http\Controllers\Serveur;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PlanningController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['table', 'client'])->get();
        return view('serveur.planning.index', compact('reservations'));
    }
}