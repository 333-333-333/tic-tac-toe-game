<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Player model:
 * It represents a player of the Tic Tac Toe (Gato) game.
 * It has a symbol property that can be 'X' or 'O'.
 */


class Player extends Model {


    use HasFactory;

    private $symbol;

    public function __construct($symbol) {
        $this->symbol = $symbol;
    }

    public function getSymbol() {
        return $this->symbol;
    }


}

