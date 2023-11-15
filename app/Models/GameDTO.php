<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameDTO extends Model {


    use HasFactory;

    protected $fillable = ['board', 'currentPlayer', 'winner', 'status'];

}
