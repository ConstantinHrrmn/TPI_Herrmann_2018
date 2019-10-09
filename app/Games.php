<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'games';

    public function scopeMatchsOnDayAndTime($query, $day, $time){
        return $query->where('idJour', '=', $day)->where('idTime', '=', $time);
    }

    public function scopeCounMachtsOnDay($query, $day){
        $res = $query->where('idJour', $day)->count();
    }

    public function scopeGetMatchInfos($id){
        
    }

}
