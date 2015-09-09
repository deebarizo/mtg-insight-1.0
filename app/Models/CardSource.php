<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardSource extends Model {
    
    protected $table = 'cards_sources';

    public function card() {
        
        return $this->belongsTo('App\Models\Card');
    }

}