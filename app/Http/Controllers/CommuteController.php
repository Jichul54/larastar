<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use App\Models\Commute;
use App\Models\Office;
use Carbon\Carbon; 
use App\Notifications\Slack;


class CommuteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('commute.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $offices = Office::all();

        $current_date_time = \Carbon\Carbon::now()->toDateTimeString();
        if ($request->arrival == '出社') {
            Commute::Create(['user_id' => Auth::id(), 'office_id' => $request->office_id, 'arrival' =>$current_date_time]); 
            $user->working = true;
            $user->save();

            $slack = \App\Models\Commute::first();
            $message = $user->name . "さんが" . $user->office->location . "オフィスに出社しました。";
            $slack->notify(new Slack($message));
        }else{
            Commute::where('user_id', Auth::id())
                    ->where('departure', null)
                    ->update(['departure' => $current_date_time]);
            $user->working = false;
            $user->save();

            $slack = \App\Models\Commute::first();
            $message = $user->name . "さんが" . $user->office->location . "オフィスから退社しました。";
            $slack->notify(new Slack($message));
        }

        $office = $request->office_id;
        $commutes = Commute::where('office_id', $office)->get();

        return view('commute.index',[
            'commutes' => $commutes,
            "offices" => $offices,
            "user" => $user,
            "office_id" => $request->office_id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $office = $request->office_id;
        $start = strtotime($request->start);
        $end = strtotime($request->end);
        
        $user = Auth::user();
        $offices = Office::all();
        $commutes = Commute::where('office_id', $office)->get();

        if ($start == false && $end == false){

        } elseif($start != false && $end == false){
            for ($n=0; $n<count($commutes); $n++){
                $arrival = strtotime($commutes[$n]->arrival);
                if ($arrival < $start){
                    unset($commutes[$n]);
                }
            }
        } elseif($start == false && $end != false){
            for ($n=0; $n<count($commutes); $n++){
                $departure = strtotime($commutes[$n]->departure);
                if ($end < $departure){
                    unset($commutes[$n]);
                }
            }            
        }
        return view('commute.index',[
            'commutes' => $commutes,
            "offices" => $offices,
            "user" => $user,
            "office_id" => $request->office_id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
