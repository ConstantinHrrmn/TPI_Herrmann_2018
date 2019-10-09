<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DayController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TimeController;

class PDayController extends Controller
{
    public function LoadPage(Request $request){
        $gc = new GameController();
        $path = substr(\Request::path(), -1);
        $dc = new DayController();
        $selectedDay = $dc->GetDayById($path);     

        $tc = new TimeController();
        $t_ids = $tc->GetAllTimesOnDay($path);
        $matchsAndTime = array();

        foreach($t_ids as $t){
            $t_infos = $tc->GetTimeById($t['idTime']);       
            array_push($matchsAndTime, $t_infos);
        }

        $matchs = array();
        $cpt = 0;

        foreach($t_ids as $t){
            $a = $gc->GetGamesOnDayAndTime($path, $t['idTime']);
            array_push($matchs, $a);
            $cpt++;
        }

        $data = array($selectedDay, $matchsAndTime, $matchs);
        return view('day',compact('data'));
    }
}
