<?php

// app/Models/Categorie.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Categorie extends Model
{
    use Sluggable;

    protected $fillable = [
        'nom',
        'slug',
        'description',
        'image',
        'ordre'
    ];

    /**
     * Configuration du slug
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nom'
            ]
        ];
    }

    /**
     * Relation avec les menus (plats)
     * Une catégorie contient plusieurs plats
     */
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}