<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\DayController;
use App\Http\Controllers\GameController;

class IndexController extends Controller
{
    public function LoadDaysAndGamesCount(){
        $dc = new DayController();
        $gc = new GameController();

        $days = $dc->GetAllDays();
        $daysInfos = array();

        foreach($days as $day){
            array_push($daysInfos, array($day->id, $day->nomJour, count($gc->GetGamesCountOnDay($day->id))));
        }

        return view('welcome', compact('daysInfos'));
    }
}
