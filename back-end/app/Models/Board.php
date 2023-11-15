<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model {
    
    
    use HasFactory;

    private $grid;

    public function __construct() {
        $this->grid = [
            new Cell(), new Cell(), new Cell(),
            new Cell(), new Cell(), new Cell(),
            new Cell(), new Cell(), new Cell()
        ];
    }

    public function getGrid() {
        return $this->grid;
    }

    public function getGridSymbols() {
        $gridSymbols = [];
        foreach ($this->grid as $cell) {
            $gridSymbols[] = $cell->getSymbol();
        }
        return $gridSymbols;
    }

    public function setGrid($grid) {
        $this->grid = $grid;
    }

    public function getCellSymbol($index) {
        return $this->grid[$index]->getSymbol();
    }

    public function setCellSymbol($index, $symbol) {
        $this->grid[$index]->setSymbol($symbol);
    }

    public function getCell($index){
        return $this->grid[$index];
    }


}
