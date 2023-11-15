<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model {


    use HasFactory;


    private $board;
    private $player1;
    private $player2;
    private $currentPlayer;
    private $winner;
    private $status;


    public function __construct() {
        $this->board = new Board();
        $this->player1 = new Player('X');
        $this->player2 = new Player('O');
        $this->currentPlayer = $this->player1;
        $this->winner = null;
        $this->status = 'playing';
    }


    // Essentialy, transforms the game into it's DTO.
    // TODO: Implement a DTO Mapper.

    public function getGameState() {
        return [
            'board' => $this->board->getGridSymbols(),
            'currentPlayer' => $this->currentPlayer->getSymbol(),
            'winner' => $this->winner,
            'status' => $this->status
        ];
    }


    // Game state checking methods.

    public function checkState() {
        $board = $this->board->getGrid();
        $symbol = $this->currentPlayer->getSymbol();

        if ($this->checkTie($board)) {
            $this->status = 'tie';
        }

        if ($this->checkWinner($board, $symbol)) {
            $this->winner = $symbol;
            $this->status = 'won';
        }
    }

    public function checkWinner($board, $symbol) {
        for ($index = 0; $index < 3; $index++) {
            
            if ($this->checkRow($board, $index, $symbol) ||
                $this->checkColumn($board, $index, $symbol) ||
                $this->checkDiagonals($board, $symbol)) {
                return true;
            }

        }

        return false;
    }

    public function checkRow($board, $index, $symbol) {
        return $board[$index*3]->getSymbol() == $symbol &&
               $board[$index*3+1]->getSymbol() == $symbol &&
               $board[$index*3+2]->getSymbol() == $symbol;
    }

    public function checkColumn($board, $index, $symbol) {
        return $board[$index]->getSymbol() == $symbol &&
               $board[$index+3]->getSymbol() == $symbol &&
               $board[$index+6]->getSymbol() == $symbol;
    }

    public function checkDiagonals($board, $symbol) {
        return ($board[0]->getSymbol() == $symbol &&
                $board[4]->getSymbol() == $symbol &&
                $board[8]->getSymbol() == $symbol) ||
               ($board[2]->getSymbol() == $symbol &&
                $board[4]->getSymbol() == $symbol &&
                $board[6]->getSymbol() == $symbol);
    }

    public function checkTie($board) {
        for ($index = 0; $index < 9; $index++) {
            
            if ($board[$index]->getSymbol() == null) {
                return false;
            }
        
        }
        
        return true;   
    }


    // Game state updating methods.

    public function updateCell($index) {
        $symbol = $this->currentPlayer->getSymbol();

        if (!($this->board->getCell($index)->isEmpty() && 
              $this->status == 'playing')) {
                return;
        }
    
        $this->board->setCellSymbol($index, $symbol);
        $this->updateGameState();
        
    }

    public function updateGameState() {
        $this->checkState();
        
        if ($this->status == 'playing' ) {
            $this->switchPlayer();
        }
    }
    
    private function switchPlayer () {
        $this->currentPlayer = $this->currentPlayer == $this->player1 ?
        $this->player2 : $this->player1;
    }


    // Setters

    public function setWinner($winner) {
        $this->winner = $winner;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setBoard($board) {
        $this->board = $board;
    }

    public function setCurrentPlayer($currentPlayer) {
        $this->currentPlayer = $currentPlayer;
    }

}
