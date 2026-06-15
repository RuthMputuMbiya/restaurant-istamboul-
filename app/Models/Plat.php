<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plat extends Model
{
    protected $table = 'plats';
    protected $fillable = ['nom', 'prix', 'image', 'description'];
    
    // Relation avec les commandes
    public function commandeItems()
    {
        return $this->hasMany(CommandeItem::class);
    }
}