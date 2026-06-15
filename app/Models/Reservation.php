<?php

// app/Models/Reservation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
   protected $table = 'reservations';
    
    protected $fillable = [
        'client_id',
        'table_id',
        'date_reservation',
        'heure_reservation',
        'nombre_personnes',
        'statut',
        'notes'
    ];

    /**
     * Relation avec le client (User)
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Relation avec la table
     * IMPORTANT: Spécifier la clé étrangère 'table_id'
     */
    public function table()
    {
        return $this->belongsTo(TableResto::class, 'table_id');
    }

    /**
     * Confirmer la réservation
     */
    public function confirmer()
    {
        $this->statut = 'confirmee';
        return $this->save();
    }

    /**
     * Annuler la réservation
     */
    public function annuler()
    {
        $this->statut = 'annulee';
        return $this->save();
    }

    /**
     * Terminer la réservation
     */
    public function terminer()
    {
        $this->statut = 'terminee';
        return $this->save();
    }
}