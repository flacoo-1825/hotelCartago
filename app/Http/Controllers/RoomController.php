<?php

namespace App\Http\Controllers;
use App\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    
	public function index(Request $request)
    {   
         
       	if (!$request->ajax()) return redirect('/');
         $search = $request->search;
         $valor = $request->valor;
         
        if ($search==''){
            $rooms = Room::orderBy('id', 'desc')->paginate(10);
        }
        else{
            $rooms = Room::where($valor, 'like', '%'. $search . '%')->orderBy('id', 'desc')->paginate(10);
        }
 
        return [
                'pagination'      => [
                'total'              => $rooms->total(),
                'current_page' => $rooms->currentPage(),
                'per_page'       => $rooms->perPage(),
                'last_page'      => $rooms->lastPage(),
                'from'              => $rooms->firstItem(),
                'to'                  => $rooms->lastItem(),
            ],
            'rooms' => $rooms
        ];
        // $rooms = Room::get();
        // return $rooms;
      
    }


    public function store(Request $request)
    {     
            if (!$request->ajax()) return redirect('/');
            $room=Room::create($request->all());

    }

    

    public function update(Request $request)
    {		
       		
       		if (!$request->ajax()) return redirect('/');

            $room =  Room::findOrFail($request->id);

            $room->name_type_room = $request->name_type_room;
            $room->description_type_room = $request->description_type_room;
            $room->state_type_room = '1';
            $room->save();
            
    }


    public function activo(Request $request)
    {	
      	
      	if (!$request->ajax()) return redirect('/');

        $room =  Room::findOrFail($request->id);
        $room->condition = '1';
        $room->save();
    }



    public function inactivo(Request $request)
    {
     	if (!$request->ajax()) return redirect('/');

        $room =  Room::findOrFail($request->id);
        $room->condition = '0';
        $room->save();
    }

    public function statebusy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $room =  Room::findOrFail($request->id);
        $room->state = 'Ocupada';
        $room->save();
    }

    public function statefree(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $room =  Room::findOrFail($request->id);
        $room->state = 'Disponible';
        $room->save();
    }


      public function listRoomActive(Request $request)
    {   
         
       if (!$request->ajax()) return redirect('/');
         $search = $request->search;
         $valor = $request->valor;
         
        if ($search==''){
            $room = Room::where('condition','=','1')
                          ->orderBy('id', 'desc')->paginate(18);
        }
        else{
            $room = Room::where('condition','=','1')
                          ->where($valor, 'like', '%'. $search . '%')->orderBy('id', 'desc')->paginate(18);
        }
 
        return [
                'pagination'      => [
                'total'              => $room->total(),
                'current_page' => $room->currentPage(),
                'per_page'       => $room->perPage(),
                'last_page'      => $room->lastPage(),
                'from'              => $room->firstItem(),
                'to'                  => $room->lastItem(),
            ],
            'room' => $room
        ];
    }
}
