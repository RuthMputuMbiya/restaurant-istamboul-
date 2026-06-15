<?php
// app/Http/Controllers/Gerant/ReservationController.php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['client', 'table'])->get();
        return view('gerant.reservations.index', compact('reservations'));
    }
    public function annuler(Reservation $reservation)
    {
        $reservation->update(['statut' => 'annulee']);
        return back();
    }
}