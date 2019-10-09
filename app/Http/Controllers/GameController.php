<?php

namespace App\Http\Controllers;

use App\Games;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function GetAllGames(){
        $games = Games::all();
        return $games;
    }   
    
    public function GetGamesCountOnDay($id){
        $gamesCount = Games::counMachtsOnDay($id)->get();
        return $gamesCount;
    }

    public function GetGamesOnDayAndTime($idDay, $idTime){
        $games = Games::MatchsOnDayAndTime($idDay, $idTime)->get();
        return $games;
    }
    
}
