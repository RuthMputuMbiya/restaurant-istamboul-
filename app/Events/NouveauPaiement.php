<?php

namespace App\Events;

use App\Models\Commande;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NouveauPaiement implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $commande;
    
    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }
    
    public function broadcastOn()
    {
        return new Channel('serveur');
    }
    
    public function broadcastAs()
    {
        return 'nouveau-paiement';
    }
}