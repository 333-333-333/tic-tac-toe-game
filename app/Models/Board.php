<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Board model:
 * It represents the board of the Tic Tac Toe (Gato) game.
 * It has a grid property that is a 3x3 matrix of Cell objects.
 */

class Board extends Model {


    use HasFactory;

    private $grid;

    public function __construct() {
        $this->grid = [
            [new Cell(), new Cell(), new Cell()],
            [new Cell(), new Cell(), new Cell()],
            [new Cell(), new Cell(), new Cell()]
        ];
    }

    public function getGrid() {
        return $this->grid;
    }

    public function setGrid($grid) {
        $this->grid = $grid;
    }

    public function getCellSymbol($row, $col) {
        return $this->grid[$row][$col]->getSymbol();
    }

    public function setCellSymbol($row, $col, $symbol) {
        $this->grid[$row][$col]->setSymbol($symbol);
    }


}
