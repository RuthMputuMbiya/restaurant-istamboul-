<?php
// app/Models/Menu.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    
    protected $fillable = [
        'categorie_id',
        'nom',
        'slug',
        'description',
        'prix',
        'devise',
        'image',
        'temps_preparation',
        'disponible',
        'populaire'
    ];
    
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }
    
    public function ligneCommandes()
    {
        return $this->hasMany(LigneCommande::class, 'menu_id');
    }
}