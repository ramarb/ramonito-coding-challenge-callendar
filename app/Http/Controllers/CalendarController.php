<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Validator;

class CalendarController extends Controller
{
    //
    public function index(){

        //die(date('Y-m-d',strtotime('360')));

        $curent_date = date('Y-m-d');

        $view_data = [
            'current_month' => date('F',strtotime($curent_date)),
            'current_year'=>date('Y'),
            'last_date' => date('t',strtotime($curent_date))
        ];

        return view('calendar', $view_data);
    }

    public function save(){

        $validator = Validator::make(Request::all(),[
            'event' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'day' => 'required'
        ]);

        $return = Request::input();

        $from_date = Request::input('from_date');
        $to_date = Request::input('to_date');

        $validator->after(function($validator){
            if(Request::input('from_date') > Request::input('to_date')){
                $validator->errors()->add('to_date', 'to_date must be greater than from_date');
            }

            if(date('m',strtotime(Request::input('to_date'))) !== date('m',strtotime(Request::input('from_date')))){
                $validator->errors()->add('to_date', 'Please enter the same month');
            }
        });


        $month = date('F', strtotime($from_date));
        $year = date('Y', strtotime($from_date));

        $uniqid = uniqid();

        if(!$validator->fails()){

            for($i = date('j',strtotime($from_date)); $i <= date('j',strtotime($to_date)); $i++){

                $the_date = "{$month} {$i} {$year}";

                if(in_array(date('D', strtotime($the_date)),Request::input('day'))){
                    $return['events'][] = str_replace(" ", "_", date('F j Y', strtotime($the_date)));
                }
            }

            $return['uniqid'] = $uniqid;

            $event = new \App\Model\Event();

            $event->name = $return['event'];
            $event->from_date = $from_date;
            $event->to_date = $to_date;
            $event->day = json_encode($return['day']);

            $event->save();

            return $return;
        }else{
            return ['error' => $validator->errors(),'uniqid' => $uniqid];
        }


    }
}
