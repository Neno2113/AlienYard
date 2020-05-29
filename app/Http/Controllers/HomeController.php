<?php

namespace App\Http\Controllers;

use App\Factura;
use App\MaestroPedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function ventas12meses()
    {

        $sqlquery = "SELECT DATE_FORMAT(fecha, '%M') as mes, SUM(total) as total FROM factura GROUP BY mes ORDER BY fecha DESC limit 0,12";
        $result = DB::select($sqlquery);


        $data = [
            'code' => 200,
            'status' => 'success',
            'result' => $result
        ];


        // return view('home',compact('fechas'));
        return response()->json($data, $data['code']);
    }

    public function ventas10dias()
    {

        $sqlquery = "SELECT CONCAT(DAY(fecha), '-', MONTH(fecha)) as fecha, SUM(total) as total FROM factura GROUP BY fecha ORDER BY fecha DESC limit 0,10";
        $result = DB::select($sqlquery);



        $data = [
            'code' => 200,
            'status' => 'success',
            'result' => $result
        ];

        return response()->json($data, $data['code']);
    }

    public function ordenesNuevas(){
        $ordenes = MaestroPedido::where('estado_id', '3')->get();

       $numero = count($ordenes);

        $data = [
            'code' => 200,
            'status' => 'success',
            'ordenesTomadas' => $numero
        ];

        return response()->json($data, $data['code']);
    }

    public function ordenesProceso(){
        $ordenes = MaestroPedido::where('estado_id', '4')->get();

       $numero = count($ordenes);

        $data = [
            'code' => 200,
            'status' => 'success',
            'ordenesProceso' => $numero
        ];

        return response()->json($data, $data['code']);
    }

    public function ordenesLista(){
        $ordenes = MaestroPedido::where('estado_id', '5')->get();

       $numero = count($ordenes);

        $data = [
            'code' => 200,
            'status' => 'success',
            'ordenesLista' => $numero
        ];

        return response()->json($data, $data['code']);
    }

    public function ventasDelDia(){
        $venta = "SELECT IFNULL(SUM(total),0) as total_venta FROM factura WHERE DATE(fecha) = curdate()";
        $result = DB::select($venta);
        $dia;

        for ($i=0; $i < count($result) ; $i++) { 
            $dia = $result[$i]->total_venta;
        }

        $data = [
            'code' => 200,
            'status' => 'success',
            'result' => $result,
            'dia' => $dia
        ];

        return response()->json($data, $data['code']);
    }

}
