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
    public function index(Request $request)
    {
        $office_id = $request->office_id;
        if (!isset($office_id)) $office_id = Auth::user()->office_id;
        $start = $request->start;
        $end = $request->end;
        
        $user = Auth::user();
        $offices = Office::all();

        if ($start == null && $end == null){
            $commutes = Commute::where('office_id', $office_id)->paginate(3);
        } elseif($start != null && $end == null){
            $commutes = Commute::where('office_id', $office_id)
                                ->whereDate('arrival', '>=' , $start)
                                ->paginate(3);
        } elseif($start == null && $end != null){
            $commutes = Commute::where('office_id', $office_id)
                                ->whereDate('departure', '<=' , $end)
                                ->paginate(3);          
        } else{
            $commutes = Commute::where('office_id', $office_id)
                                ->whereDate('arrival', '>=' , $start)
                                ->whereDate('departure', '<=' , $end)
                                ->paginate(3);  
        }
        return view('commute.index',[
            'commutes' => $commutes,
            "offices" => $offices,
            "user_id" => $user->id,
            "office_id" => $office_id
        ]);
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
        $office_id = $request->office_id;

        $current_date = \Carbon\Carbon::now()->toDateString();
        //????????????????????????????????????????????????????????????????????????
        $commute_current_user = Commute::where('user_id', Auth::id())
                                        ->where('office_id', $office_id)
                                        ->whereDate('created_at', $current_date)
                                        ->get();
        if (count($commute_current_user) > 1) return redirect()->route('commute.index');

        $user = Auth::user();
        $offices = Office::all();
        $office = Office::find($office_id);

        $current_date_time = \Carbon\Carbon::now()->toDateTimeString();
        if ($request->arrival == '??????') {
            Commute::Create(['user_id' => Auth::id(), 'office_id' => $request->office_id, 'arrival' =>$current_date_time]); 
            $user->working = true;
            $user->save();

            $slack = \App\Models\Commute::first();
            $message = $user->name . "?????????" . $user->office->location . "????????????????????????????????????";
            $slack->notify(new Slack($message));

            // ??????????????????????????????Slack??????????????????
            $office_now = Commute::where('office_id', $office_id)
                                    ->where('departure', null)
                                    ->get();
            if (count($office_now) >= $office->limit){
                $slack = \App\Models\Commute::first();
                $message = $office->location."???????????????????????????".$office->limit."???????????????????????????????????????????????????????????????";
                $slack->notify(new Slack($message));                
            }
        }else{
            Commute::where('user_id', Auth::id())
                    ->where('departure', null)
                    ->update(['departure' => $current_date_time]);
            $user->working = false;
            $user->save();

            $slack = \App\Models\Commute::first();
            $message = $user->name . "?????????" . $user->office->location . "???????????????????????????????????????";
            $slack->notify(new Slack($message));
        }

        $commutes = Commute::where('office_id', $office_id)->paginate(3);

        return view('commute.index',[
            'commutes' => $commutes,
            "offices" => $offices,
            "user_id" => $user->id,
            "office_id" => $office_id
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Commute::find($id);
        if ($result->departure == null) Auth::user()->update(['working' => false]);
        $result->delete();
        return redirect()->route('commute.index');
    }
}
