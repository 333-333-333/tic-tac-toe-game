<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Board;
use App\Models\Player;
use App\Models\Cell;
use App\Models\GameDTO;

class GameController extends Controller {


    protected $game;

    public function processUpdateCell(Request $request, $index) {
        $requestData = $request->json()->all();
        $game = $this->createGameFromDTO(new GameDTO($requestData));
        
        $game->updateCell($index);

        return response()->json($game->getGameState());
    }

    public function startGame() {
        $this->game = new Game();
        return response()->json($this->game->getGameState());
    }

    private function createGameFromDTO(GameDTO $gameDTO) {
        $game = new Game();
        $boardArray = $gameDTO->board;
        $board = $this->createBoardFromArray($boardArray);
        $game->setBoard($board);
        $currentSymbol = $gameDTO->currentPlayer;
        $currentPlayer = $this->createPlayerFromSymbol($currentSymbol);
        $game->setCurrentPlayer($currentPlayer);
        $game->setWinner($gameDTO->winner);
        $game->setStatus($gameDTO->status);

        return $game;
    }

    private function createBoardFromArray($boardArray) {
        $board = new Board();

        // Creates cell grid
        $grid = [];
        foreach ($boardArray as $symbol) {
            $cell = new Cell();
            $cell->setSymbol($symbol);
            $grid[] = $cell;
        }

        $board->setGrid($grid);

        return $board;
    }

    private function createPlayerFromSymbol($symbol) {
        return new Player($symbol);
    }

}
