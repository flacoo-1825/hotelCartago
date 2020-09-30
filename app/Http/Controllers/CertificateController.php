<?php

namespace App\Http\Controllers;
use App\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    
	public function index(Request $request)
    {   
         
       	if (!$request->ajax()) return redirect('/');
         $search = $request->search;
         $valor = $request->valor;
         
        if ($search==''){
            $certificates = Certificate::orderBy('id', 'desc')->paginate(10);
        }
        else{
            $certificates = Certificate::where($valor, 'like', '%'. $search . '%')->orderBy('id', 'desc')->paginate(10);
        }
 
        return [
                'pagination'      => [
                'total'              => $certificates->total(),
                'current_page' => $certificates->currentPage(),
                'per_page'       => $certificates->perPage(),
                'last_page'      => $certificates->lastPage(),
                'from'              => $certificates->firstItem(),
                'to'                  => $certificates->lastItem(),
            ],
            'certificates' => $certificates
        ];
        // $rooms = certificates::get();
        // return $rooms;
      
    }


    public function store(Request $request)
    {     
            if (!$request->ajax()) return redirect('/');
            $certificates=Certificate::create($request->all());

    }

    

    public function update(Request $request)
    {		
       		
            if (!$request->ajax()) return redirect('/');

            $certificates =  Certificate::findOrFail($request->id) ;

            $certificates->cityOrigin_certificate = $request->cityOrigin_certificate;
            $certificates->number_certificate = $request->number_certificate;
            $certificates->cityDestination_certificate = $request->cityDestination_certificate;
            $certificates->placabike_certificate = $request->placabike_certificate;
            $certificates->placaCar_certificate = $request->placaCar_certificate;
            $certificates->adults_certificate = $request->adults_certificate;
            $certificates->children_certificate = $request->children_certificate;
            $certificates->entry_certificate = $request->entry_certificate;
            $certificates->exit_certificate = $request->exit_certificate;
            $certificates->observation_certificate = $request->observation_certificate;
            $certificates->save();
            
    }


    public function searchClient(Request $request){

        // $cc_certificates = '2425';

        if (!$request->ajax()) return redirect('/');
        $cc_certificates = $request->cc_client;
        $certificates = Certificate::where('cedula_client',$cc_certificates)->first();
        if (!$certificates) {
            return ['client'=>['name_client'=>'Usuario no registrado']];
        }else{
            $certificates = Certificate::where('cedula_client' ,$cc_certificates)
                        // ->select('id','cedula_client','name_client','firstSurname_client','secondSurname_client',
                        // 'narionality_client')
                        ->get();

            return ['client'=>$certificates[0]];
        }

     }



}
