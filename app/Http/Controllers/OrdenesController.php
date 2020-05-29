<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Canal;
use App\MetodoPago;
use App\MaestroPedido;
use App\DetallePedido;
use App\Producto;
use App\Recetas;
use App\Comentario;
use App\Factura;
use App\DetalleFactura;
use  Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OrdenesController extends Controller
{
    public function metodoPagoSelect()
    {
        $metodo = MetodoPago::all();

        if (!empty($metodo)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'metodo' => $metodo
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Ocurrio un error'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function canal()
    {
        $canal = Canal::all();

        if (!empty($canal)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'canal' => $canal
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Ocurrio un error'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'canal' => 'required',
            'metodo' => 'required',
            'delivery' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => $validator->errors()
            ];
        } else {
            $canal = $request->input('canal');
            $metodo = $request->input('metodo');
            $delivery = $request->input('delivery');
            $numeroOrden = $request->input('numeroOrden');

            $orden = new MaestroPedido();
            $orden->user_id = auth()->user()->id;
            $orden->creado_por = auth()->user()->id;
            $orden->canal_id = $canal;
            $orden->numeroOrden = $numeroOrden + 1;
            $orden->metodo_pago = $metodo;
            $orden->delivery = $delivery;
            $orden->estado_pago = 0;
            $orden->estado_id = 3;
            $orden->fecha_creacion = date('Y/m/d h:i:s');

            $orden->save();

            $data = [
                'code' => 200,
                'status' => 'success',
                'orden' => $orden->load('canal')->load('metodoPago')->load('user')
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function storeDetalle($id, Request $request)
    {

        $producto = $id;
        $mPedido = $request->input('pedido');

        if (!empty($mPedido)) {
            $detalle = new DetallePedido();

            $obtProducto = Producto::find($producto);
            $costo = $obtProducto->precio;

            $detalle->id_maestroPedido = $mPedido;
            $detalle->producto_id = $producto;
            $detalle->costo = $costo;
            $detalle->save();

            $data = [
                'code' => 200,
                'status' => 'success',
                'detalle' => $detalle->load('producto')
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'No se encontro ningun pedido'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function destroyDetalle($id)
    {

        $detalle = DetallePedido::find($id);

        if (is_object($detalle)) {
            $detalle->delete();

            $data = [
                'code' => 200,
                'status' => 'success',
                'detalle' => $detalle
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'No se encontro nada'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function updateCosto($id, Request $request)
    {
        $detalle = DetallePedido::find($id);

        if (is_object($detalle)) {
            $costo = $request->input('costo');
            $costo = trim($costo, "RD$");
            $detalle->costo = $costo;
            $detalle->save();

            $data = [
                'code' => 200,
                'status' => 'success',
                'detalle' => $detalle
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'No se encontro nada'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function recetaProducto($id)
    {
        $detalle = DetallePedido::find($id);

        if (is_object($detalle)) {
            $plato = $detalle->producto_id;
            $receta = Recetas::where('id_producto', $plato)->get();
            $producto = Producto::find($plato);
            $data = [
                'code' => 200,
                'status' => 'success',
                'receta' => $receta->load('ingrediente'),
                'producto' => $producto
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'ocurrio un error'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function comentario(Request $request)
    {

        $id = $request->input('plato');
        $termino = $request->input('termino');

        if (!empty($id)) {
            $comentario = new Comentario();

            $comentario->plato = $id;
            $comentario->comentario = $termino;
            $comentario->save();

            $data = [
                'code' => 200,
                'status' => 'success',
                'comentario' => $comentario
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'ocurrio un error'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function destroyComment(Request $request)
    {
        $id = $request->input('plato');
        $termino = $request->input('termino');

        if (!empty($id)) {
            $comentario = Comentario::where('plato', $id)
                ->where('comentario', $termino)->get()->first();

            if (is_object($comentario)) {
                $comentario->delete();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'comentario' => $comentario
                ];
            } else {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'ocurrio un error'
                ];
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Comentario no encontrado'
            ];
        }
        return response()->json($data, $data['code']);
    }

    public function comentarioManual(Request $request)
    {
        $comentario = $request->input('comentario');
        $id = $request->input('plato');

        if (!empty($id)) {
            $detalle = DetallePedido::find($id);

            if (is_object($detalle)) {
                $detalle->comentario = $comentario;
                $detalle->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'comentario' => $detalle
                ];
            } else {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'ocurrio un error'
                ];
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Comentario no encontrado'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function ordenes()
    {
        $ordenes = MaestroPedido::orderBy('id', 'desc')->get();

        if (count($ordenes) <= 0) {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'ocurrio un error'
            ];
        } else {
            $data = [
                'code' => 200,
                'status' => 'success',
                'ordenes' => $ordenes->load('canal')->load('MetodoPago')
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function orden($id)
    {
        $platos = DetallePedido::where('id_maestroPedido', $id)->get();

        if (count($platos) <= 0) {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'ocurrio un error'
            ];
        } else {
            $data = [
                'code' => 200,
                'status' => 'success',
                'ordenes' => $platos->load('producto')
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function platoComentario($id)
    {
        $comentarioManual = DetallePedido::find($id);

        if (is_object($comentarioManual)) {
            $comentarios = Comentario::where('plato', $id)->get();
            $manual = ($comentarioManual->comentario == NULL) ? "" : $comentarioManual->comentario;

            $data = [
                'code' => 200,
                'status' => 'success',
                'comentarios' => $comentarios,
                'comentarioManual' => $manual
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'ocurrio un error'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function destroy($id)
    {
        $orden = MaestroPedido::find($id);

        if (is_object($orden)) {
            $orden->delete();

            $data = [
                'code' => 200,
                'status' => 'success',
                'orden' => $orden
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'ocurrio un error'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function updateState($id)
    {
        $orden = MaestroPedido::find($id);

        if (is_object($orden)) {
            $orden->estado_id = 4;
            $orden->save();


            $data = [
                'code' => 200,
                'status' => 'success',
                'orden' => $orden
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'ocurrio un error'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function updateReady(Request $request)
    {
        $id = $request->input('orden');

        $orden = MaestroPedido::find($id);

        if (is_object($orden)) {
            $orden->estado_id = 5;
            $orden->save();


            $data = [
                'code' => 200,
                'status' => 'success',
                'orden' => $orden
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'ocurrio un error'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function getDigits()
    {
        $orden = MaestroPedido::orderBy('created_at', 'desc')->first();

        if (\is_object($orden)) {
            $sec = $orden->numeroOrden;
        }

        // echo $orden;
        // die();

        if (empty($sec) || $sec == 100) {
            $sec = 0;

            $data = [
                'code' => 200,
                'status' => 'success',
                'sec' => $sec
            ];
        } else {

            $data = [
                'code' => 200,
                'status' => 'success',
                'sec' => $sec
            ];
        }
        return response()->json($data, $data['code']);
    }


    public function ordenesListas()
    {
        $ordenes = DB::table('maestro_pedido')->join('users', 'maestro_pedido.user_id', '=', 'users.id')
            ->join('estado_pedido', 'maestro_pedido.estado_id', '=', 'estado_pedido.id')
            ->join('canal', 'maestro_pedido.canal_id', '=', 'canal.id')
            ->select([
                'maestro_pedido.id', 'maestro_pedido.numeroOrden', 'estado_pedido.estado', 'maestro_pedido.delivery',
                'canal.canal', 'maestro_pedido.estado_pago'
            ])
            ->where('estado_id', '5');
        // ->orWhere('estado_id', '6');

        return DataTables::of($ordenes)
            ->editColumn('numeroOrden', function ($producto) {
                return '<span style="font-size: 15px;" class="badge badge-danger font-weight-bold">' . $producto->numeroOrden . '</span>';
            })
            ->editColumn('canal', function ($producto) {
                return '<span style="font-size: 15px;" class="badge badge-warning font-weight-bold">' . $producto->canal . '</span>';
            })
            ->editColumn('estado', function ($producto) {
                return '<span style="font-size: 15px;" class="badge badge-primary font-weight-bold">' . $producto->estado . '</span>';
            })
            ->editColumn('delivery', function ($producto) {
                return '<span style="font-size: 15px;" class="badge badge-success font-weight-bold">' . $producto->delivery . '</span>';
            })
            ->addColumn('Opciones', function ($orden) {
                return ($orden->estado_pago == 1) ? '<span style="font-size: 15px;" class="badge badge-success font-weight-bold">Facturado</span>' :
                    '<button id="btnEdit" onclick="mostrar(' . $orden->id . ')" class="btn btn-dark btn-sm mr-1"> <i class="fas fa-cash-register"></i></button>';
            })

            ->rawColumns(['Opciones', 'canal', 'delivery', 'estado', 'numeroOrden'])
            ->make(true);
    }

    public function show($id)
    {
        $orden = MaestroPedido::find($id)
            ->load('user')
            ->load('canal')
            ->load('metodoPago')
            ->load('estado');

        if (is_object($orden)) {
            $detalle = DetallePedido::where('id_maestroPedido', $id)->get();

            $data = [
                'code' => 200,
                'status' => 'success',
                'orden' => $orden,
                'detalle' => $detalle->load('producto'),
                'total' => $detalle->sum('costo')
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Ocurrio un error'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function storeFacturaCompleta(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'pedido' => 'required',
            'no_factura' => 'required',
            'tipo_factura' => 'required',
            'total' => 'required',
            'efectivo' => 'required'

        ]);

        if ($validator->fails()) {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => $validator->errors()
            ];
        } else {
            $pedido = $request->input('pedido');
            $no_factura = $request->input('no_factura');
            $tipo_factura = $request->input('tipo_factura');
            $descuento = $request->input('descuento');
            $itbis = $request->input('itbis');
            $total = $request->input('total');
            $pago = $request->input('efectivo');

            $total = trim($total, 'RD$');
            $pago = trim($pago, 'RD$_');
            (!empty($itbis) ? $itbis = trim($itbis, '_%') : 0);
            $descuento = trim($descuento, '_%');
            $no_factura = trim($no_factura, '_');

            $factura = new Factura();

            $factura->pedido = $pedido;
            $factura->user_id = auth()->user()->id;
            $factura->no_factura = $no_factura;
            $factura->fecha = date('Y/m/d h:i:s');
            $factura->tipo_factura = $tipo_factura;
            $factura->descuento = $descuento;
            $factura->itbis = $itbis;
          

            $factura->total = $total;
            $factura->pago = $pago;
            $factura->save();

            $detalle_pedido = DetallePedido::where('id_maestroPedido', $pedido)->get();

            $cambio = $pago - $total;

            for ($i = 0; $i < count($detalle_pedido); $i++) {
                $detalle[$i] = new DetalleFactura();
                $detalle[$i]->factura = $factura->id;
                $detalle[$i]->producto = $detalle_pedido[$i]->producto_id;
                $detalle[$i]->costo = $detalle_pedido[$i]->costo;
                $detalle[$i]->save();
            }

            $data = [
                'code' => 200,
                'status' => 'success',
                'factura' => $factura,
                'detalle' => $detalle_pedido,
                'cambio' => number_format($cambio)
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function ordenFacturada(Request $request)
    {
        $id = $request->input('pedido');

        $orden = MaestroPedido::find($id);

        if (is_object($orden)) {
            $orden->estado_pago = 1;
            $orden->procesado_por = auth()->user()->id;
            $orden->hora_pago = date('Y/m/d h:i:s');
            $orden->estado_id = 6;
            $orden->save();


            $data = [
                'code' => 200,
                'status' => 'success',
                'orden' => $orden
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'No se encontro la orden'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function storeFacturaManual(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'pedido' => 'required',
            'no_factura' => 'required',
            'tipo_factura' => 'required'

        ]);

        if ($validator->fails()) {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => $validator->errors()
            ];
        } else {
            $pedido = $request->input('pedido');
            $no_factura = $request->input('no_factura');
            $tipo_factura = $request->input('tipo_factura');
            // $descuento = $request->input('descuento');
            // $itbis = $request->input('itbis');
            // $total = $request->input('total');
            // $pago = $request->input('efectivo');


            $no_factura = trim($no_factura, '_');

            $factura = new Factura();

            $factura->pedido = $pedido;
            $factura->user_id = auth()->user()->id;
            $factura->no_factura = $no_factura;
            $factura->fecha = date('Y/m/d h:i:s');
            $factura->tipo_factura = $tipo_factura;
            $factura->total = 0;
            // $factura->descuento = $descuento;
            // $factura->itbis = $itbis;
            // $itbis_real = $itbis / 100;
            // $descuento_porc = $descuento / 100;
            $factura->save();


            $data = [
                'code' => 200,
                'status' => 'success',
                'factura' => $factura
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function agregarDetalle($id, Request $request)
    {
        $factura = $request->input('factura');

        $orden_detalle = DetallePedido::find($id);

        if (!empty($factura) && is_object($orden_detalle)) {
            $costo = $orden_detalle->costo;
            $producto = $orden_detalle->producto_id;

            $detalle = new DetalleFactura();

            $detalle->factura = $factura;
            $detalle->producto = $producto;
            $detalle->costo = $costo;
            $detalle->save();

            $data = [
                'code' => 200,
                'status' => 'success',
                'detalle' => $detalle
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Ocurrio un error'
            ];
        }
        return response()->json($data, $data['code']);
    }

    public function terminarFacturaManual(Request $request)
    {
        $id = $request->input('factura');
        $descuento = $request->input('descuento');
        $itbis = $request->input('itbis');
        $total = $request->input('total');
        $pago = $request->input('efectivo');

        $factura = Factura::find($id);

        if (is_object($factura)) {
            $total = trim($total, 'RD$_');
            $pago = trim($pago, 'RD$_');
            (!empty($itbis) ? $itbis = trim($itbis, '_%') : 0);
            $descuento = trim($descuento, '_%');

            $factura->descuento = $descuento;
            $factura->itbis = $itbis;

            $factura->total = $total;
            $factura->pago = $pago;
            $factura->save();

            $cambio = $pago - $total;

            $data = [
                'code' => 200,
                'status' => 'success',
                'factura' => $factura,
                'cambio' => $cambio
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Ocurrio un error'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function imprimir($id)
    {
        $factura = Factura::find($id)->load('orden')->load('user');

        if (is_object($factura)) {

            $factura->fecha_impresion = date('Y/m/d h:i:s');
            $factura->save();

            $detalle = DetalleFactura::where('factura', $factura->id)->get()->load('plato');
            $total = $factura->total;

            $cambio = $factura->pago - $total;  

            $factura->fecha = date('d/m/20y', strtotime($factura->fecha));
            $factura->fecha_impresion = date('d/m/20y h:i:s', strtotime($factura->fecha_impresion));
            $pdf = \PDF::loadView('sistema.ordenes.factura', \compact(
                'factura',
                'detalle',
                'total',
                'cambio'

            ))->setPaper('a2', 'portrait');
            return $pdf->download('factura.pdf');
            return view('sistema.ordenes.factura', \compact(
                'factura',
                'detalle',
                'total',
                'cambio'
            ));
        } else {
        }
    }

    public function aplicar(Request $request){
        $monto = $request->input('monto');
        $descuento = $request->input('descuento');
        $itbis = $request->input('itbis');
        

        $descuento = trim($descuento, '_%');
        // $descuento = ($descuento == "") ? 0 : $descuento;
     
        $itbis = trim($itbis, '_%');
        // $itbis = ($itbis == "") ? 0 : $itbis;
     
        $monto = trim($monto, 'RD$_');

        $descuento = $descuento / 100;
        $itbis = $itbis / 100;

        $monto_itbis = $monto * $itbis;
        $monto_desc = $monto * $descuento;
        $subtotal = $monto + $monto_itbis;

        $total = $subtotal - $monto_desc;

        $data = [
        'code' => 200,
        'status' => 'success',
        'total' => $total,
        'subtotal' => $subtotal
        ];
        
        return response()->json($data, $data['code']);
    }
}
