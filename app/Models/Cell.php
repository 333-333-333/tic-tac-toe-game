<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Cell model:
 * It represents a cell of the board grid in the Tic Tac Toe (Gato) game.
 * It has a symbol property that can be 'X', 'O' or ' '.
 */

class Cell extends Model {


    use HasFactory;

    private $symbol;

    public function __construct() {
        $this->symbol = null;
    }

    public function setSymbol($symbol) {
        $this->symbol = $symbol;
    }

    public function getSymbol() {
        return $this->symbol;
    }

    public function isEmpty() {
        return $this->symbol == null;
    }
    

}
