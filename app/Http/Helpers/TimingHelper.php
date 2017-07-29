<?php
namespace App\Http\Helpers;

use App\Models\TimingModel;
use Carbon\Carbon;

class TimingHelper{

    public function getRestaurantStatus(){

        $now = Carbon::now();
        $temp_day = $now->dayOfWeek;
        switch ($temp_day){
            case 7:
                $day = 'Sunday';
                break;
            case 1:
                $day = 'Monday';
                break;
            case 2:
                $day = 'Tuesday';
                break;
            case 3:
                $day = 'Wednesday';
                break;
            case 4:
                $day = 'Thursday';
                break;
            case 5:
                $day = 'Friday';
                break;
            case 6:
                $day = 'Saturday';
                break;
        }

       $day_timing = TimingModel::where('day',$day)->first();
       $opening_timing = $day_timing->opening_time;
       $closing_timing = $day_timing->closing_time;
        if(date('H:i') > $opening_timing && date('H:i') < $closing_timing){
            $status = true;
        }
        else{
            $status = false;
        }

        return $status;

    }

}

