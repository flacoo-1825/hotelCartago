<?php

namespace App\Http\Controllers;
use App\bill;
use App\Sale;
use Illuminate\Http\Request;

class BillController extends Controller
{
    
	public function index(Request $request)
    {   
         
       	if (!$request->ajax()) return redirect('/');
         $search = $request->search;
         $valor = $request->valor;
         
        if ($search==''){
            $bills = Bill::orderBy('id', 'desc')->paginate(10);
        }
        else{
            $bills = Bill::where($valor, 'like', '%'. $search . '%')->orderBy('id', 'desc')->paginate(10);
        }
 
        return [
                'pagination'      => [
                'total'              => $bills->total(),
                'current_page' => $bills->currentPage(),
                'per_page'       => $bills->perPage(),
                'last_page'      => $bills->lastPage(),
                'from'              => $bills->firstItem(),
                'to'                  => $bills->lastItem(),
            ],
            'bills' => $bills
        ];
        // $bills = Bill::get();
        // return $bills;
      
    }


    public function store(Request $request)
    {     
            if (!$request->ajax()) return redirect('/');
            $bill=bill::create($request->all());
            

            // $client = new Client();

            // $bill->room_id = $request->cedula_bill;
            // $bill->customer_id = $request->name_bill;
            // $bill->certificate_id = $request->firstSurname_bill;
            // $bill->taxe_id = $request->secondSurname_bill;
            // $bill->number_bill = $request->birth_date_bill;
            // $bill->faker_number_bill = $request->gender_bill;
            // $bill->date_entry_bill = $request->age_bill;
            // $bill->date_exit_bill = $request->address_bill;
            // $bill->dian_bill = $request->city_bill;
            // $bill->total_bill = $request->nationality_bill;
            // $bill->state_bill = $request->state_bill;
            // $bill->state_bill = $request->phone_bill;
            // $client->save();
     

        //     'customer_id' , 
        // 'room_id',
        // 'certificate_id',
        // 'taxe_id',
        // 'number_bill',
        // 'faker_number_bill',
        // 'date_entry_bill',
        // 'date_exit_bill',
        // 'dian_bill',
        // 'total_bill',
        // 'state_bill',
    }

    

    public function update(Request $request)
    {		
               
        $listbill = $request->bill;
        $number_reception = $request->number_reception;

        for ($i=0; $i < count($listbill) ; $i++) { 

            $bill =  Bill::findOrFail($listbill[$i]['id']);
           
            $bill->number_bill_bills = $number_reception;
            $bill->state_bill = 0 ;
            $bill->save();
        }
  
    }


    public function activo(Request $request)
    {	
      	
      	if (!$request->ajax()) return redirect('/');

        $bill =  Bill::findOrFail($request->id);
        $bill->condition_bill = '1';
        $bill->save();
    }



    public function inactivo(Request $request)
    {
     	if (!$request->ajax()) return redirect('/');

        $bill =  Bill::findOrFail($request->id);
        $bill->condition_bill = '0';
        $bill->save();
    }


      public function listBills(Request $request)
    {   
         
    //    if (!$request->ajax()) return redirect('/');

        // $number_facture = '4604Fact';
        $number_facture = $request->number_bill;
        
        $bills = Bill::join('rooms', 'bills.room_id', '=' ,'rooms.id')
                        ->join('customers', 'bills.customer_id', '=' ,'customers.id')
                        ->join('certificates', 'bills.certificate_id', '=' ,'certificates.id')
                        ->select('bills.id','bills.number_bill','bills.date_entry_bill',
                        'bills.date_exit_bill','bills.total_bill',
                        'customers.name_client','customers.firstSurname_client','customers.cedula_client',
                        'customers.name_client','customers.nationality_client','customers.phone_client', 
                        'customers.secondSurname_client','rooms.number','rooms.price','rooms.client_id',
                        'rooms.condition','rooms.price_air','rooms.frozen')
                        ->where('bills.number_bill','=',$number_facture)
                        ->orderBy('id', 'desc')->get();
      
        $sales = Sale::join('products', 'sales.product_id', '=' ,'products.id')
        ->select('sales.id','sales.number_bill_sales','sales.quantity_sales',
        'sales.price_unit_sales','sales.total_sales','products.name_product')
        ->where('number_bill_sales','=',$number_facture)
        ->orderBy('id', 'desc')->get();
       
        return [
                
            'bills' => $bills,
            'sales' => $sales
        ];

        // return $bills;
    }
}

