<?php

// app/Models/TableResto.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableResto extends Model
{
    protected $table = 'tables_resto';

    protected $fillable = [
        'numero',
        'capacite',
        'zone',
        'statut',
        'est_active'
    ];

    /**
     * Relation avec les réservations
     * IMPORTANT: Spécifier la clé étrangère 'table_id'
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'table_id');
    }

    /**
     * Relation avec les commandes
     */
    public function commandes()
    {
        return $this->hasMany(Commande::class, 'table_id');
    }

    /**
     * Vérifier si la table est disponible
     */
    public function estDisponible($date, $heure)
    {
        $reservation = $this->reservations()
            ->where('date_reservation', $date)
            ->where('heure_reservation', $heure)
            ->whereIn('statut', ['en_attente', 'confirmee'])
            ->first();

        return is_null($reservation);
    }

    /**
     * Changer le statut de la table
     */
    public function changerStatut($nouveauStatut)
    {
        $this->statut = $nouveauStatut;
        return $this->save();
    }
}