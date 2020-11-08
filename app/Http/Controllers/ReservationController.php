<?php

namespace App\Http\Controllers;
use App\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        
        
    // if(request()->ajax())
    // {
    // $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
    // $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
    // $data = Reservation::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','title','start', 'end']);
    // return Response::json($data);
    // }
        $data['eventos']=Reservation::all();
        return Response()->json($data['eventos']);
    }


    public function store(Request $request)
    {     
            if (!$request->ajax()) return redirect('/');
            $reservation=Reservation::create($request->all());

    }

    

    public function update(Request $request)
    {		
       		
       		if (!$request->ajax()) return redirect('/');

            $category =  Reservation::findOrFail($request->id);

            $category->name_category = $request->name_category;
            $category->description_category = $request->description_category;
            $category->condition_category = '1';
            $category->save();
            
    }
}
