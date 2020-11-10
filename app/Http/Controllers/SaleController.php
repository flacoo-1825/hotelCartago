<?php

namespace App\Http\Controllers;
use App\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    
	public function index(Request $request)
    {   
         
       	if (!$request->ajax()) return redirect('/');
         $search = $request->search;
         $valor = $request->valor;
         
        if ($search==''){
            $sales = Sale::orderBy('id', 'desc')->paginate(10);
        }
        else{
            $sales = Sale::where($valor, 'like', '%'. $search . '%')->orderBy('id', 'desc')->paginate(10);
        }
 
        return [
                'pagination'      => [
                'total'              => $sales->total(),
                'current_page' => $sales->currentPage(),
                'per_page'       => $sales->perPage(),
                'last_page'      => $sales->lastPage(),
                'from'              => $sales->firstItem(),
                'to'                  => $sales->lastItem(),
            ],
            'sales' => $sales
        ];
        // $sales = sale::get();
        // return $sales;
      
    } 


    public function store(Request $request)
    {     
            if (!$request->ajax()) return redirect('/');
            // $sale=Sale::create($request->all());
            $listSale = $request->sale;

            for ($i=0; $i < count($listSale) ; $i++) { 
                $sale = new Sale();
                $sale->checkbook_id = NULL ;
                $sale->product_id = $listSale[$i]['product_id'] ;
                $sale->taxe_id = NULL ;
                $sale->number_bill_sales = $listSale[$i]['number_facture'] ;
                $sale->quantity_sales = $listSale[$i]['cantidad_product'] ;
                $sale->price_unit_sales = $listSale[$i]['sale_product'] ;
                $sale->dian_bill = 'No' ;
                $sale->total_sales = $listSale[$i]['total'] ;
                $sale->state_bill = 1 ;
                $sale->save();
            }
    }

    

    public function update(Request $request)
    {		
        if (!$request->ajax()) return redirect('/');
             
        $listSale = $request->sale;
        $number_reception = $request->number_reception;

        for ($i=0; $i < count($listSale) ; $i++) { 

            $sale =  Sale::findOrFail($listSale[$i]['id']);
           
            $sale->number_bill_sales = $number_reception;
            $sale->state_bill = 0 ;
            $sale->save();
        }
  
    }


    public function activo(Request $request)
    {	
      	
      	if (!$request->ajax()) return redirect('/');

        $sale =  Sale::findOrFail($request->id);
        $sale->condition_sale = '1';
        $sale->save();
    }



    public function inactivo(Request $request)
    {
     	if (!$request->ajax()) return redirect('/');

        $sale =  Sale::findOrFail($request->id);
        $sale->condition_sale = '0';
        $sale->save();
    }


      public function listSales(Request $request)
    {   
         
       if (!$request->ajax()) return redirect('/');

        $number_facture = $request->number_facture;

        $sales = Sale::join('products', 'sales.product_id', '=' ,'products.id')
                        ->select('sales.id','sales.number_bill_sales','sales.quantity_sales',
                        'sales.price_unit_sales','sales.total_sales','products.name_product')
                        ->where('number_bill_sales','=',$number_facture)
                        ->orderBy('id', 'desc')->get();
       
        // return [
                
        //     'sales' => $sales
        // ];

        return $sales;
    }
}

