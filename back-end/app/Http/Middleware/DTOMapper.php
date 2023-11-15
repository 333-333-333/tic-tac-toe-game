<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\GameDTO;
use App\Models\Game;
use App\Models\Board;
use App\Models\Cell;
use App\Models\Player;


class DTOMapper
{
    public function handle(Request $request, Closure $next) {
        $rules = [
            'board' => 'required',
            'currentPlayer' => 'required',
            'winner' => 'nullable',
            'status' => 'required|in:playing',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        return $next($request);
    }

    public function toGame(GameDTO $dto) {
        $game = new Game();
        $game->setBoard($this->toBoard($dto->board));
        $game->setCurrentPlayer($this->toPlayer($dto->currentPlayer));
        $game->setWinner($dto->winner);
        $game->setStatus($dto->status);
        return $game;
    }

    public function toBoard($board) {
        $gameBoard = new Board();
        
        foreach ($board as $index => $symbol) {
            $gameBoard->setCell($index, $symbol);
        }
        return $gameBoard;
    }

    public function toPlayer($symbol) {
        return new Player($symbol);
    }


}
