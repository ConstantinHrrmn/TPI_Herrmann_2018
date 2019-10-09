<?php

namespace App\Http\Controllers;

use App\Day;
use Illuminate\Http\Request;

class DayController extends Controller
{
    public function GetAllDays(){
        $days = Day::all();
        return $days;
    }

    public function GetDayById($id){
        $selected = Day::where('id', $id)->first();
        return $selected;
    }
}
