<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Game model:
 * It represents the Tic Tac Toe (Gato) game.
 * It has a board property that is a Board object.
 * It has two players, player1 and player2, that are Player objects.
 * It has a currentPlayer property that is a Player object.
 * It has a winner property that is the symbol of the winner player.
 * It has a status property that can be 'playing', 'won' or 'tie'.
 */

class Game extends Model{
 
 
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

    public function getGameState() {
        return [
            'board' => $this->board->getGrid(),
            'currentPlayer' => $this->currentPlayer->getSymbol(),
            'winner' => $this->winner,
            'status' => $this->status
        ];
    }

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

    private function checkWinner($board, $symbol) {
        for ($index = 0; $index < 3; $row++) {
            if ($this.checkRow($board, $index, $symbol) ||
                $this.checkColumn($board, $index, $symbol) ||
                $this.checkDiagonals($board, $symbol)) {
                return true;
            }
        }

        return false;
    }

    private function checkRow($board, $index, $symbol) {
        return $board[$index][0]->getSymbol() == $symbol &&
               $board[$index][1]->getSymbol() == $symbol &&
               $board[$index][2]->getSymbol() == $symbol;
    }

    private function checkColumn($board, $index, $symbol) {
        return $board[0][$index]->getSymbol() == $symbol &&
               $board[1][$index]->getSymbol() == $symbol &&
               $board[2][$index]->getSymbol() == $symbol;
    }

    private function checkDiagonals($board, $symbol) {
        return ($board[0][0]->getSymbol() == $symbol &&
                $board[1][1]->getSymbol() == $symbol &&
                $board[2][2]->getSymbol() == $symbol) ||
               ($board[0][2]->getSymbol() == $symbol &&
                $board[1][1]->getSymbol() == $symbol &&
                $board[2][0]->getSymbol() == $symbol);
    }

    private function checkTie($board) {
        for ($row = 0; $row < 3; $row++) {
            for ($col = 0; $col < 3; $col++) {
                if ($board[$row][$col]->getSymbol() == ' ') {
                    return false;
                }
            }
        }
        return true;   
    }


}
