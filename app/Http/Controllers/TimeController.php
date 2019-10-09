<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Time;
use App\Games;

class TimeController extends Controller
{
    public function GetAllTimesOnDay($idDay){
        $times = Games::groupBy('idTime')->selectRaw('idTime')->where('idJour', $idDay)->get();
        return $times;
    }

    public function GetTimeById($id){
        $time = Time::where('id', $id)->first();
        return $time;
    }
}
