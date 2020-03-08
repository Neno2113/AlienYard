<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoriaIngrediente;
use App\Ingredientes;
use App\Inventario;
use Yajra\DataTables\Facades\DataTables;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ingredienteController extends Controller
{
    public function storeCategoria(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'code' => 400,
                'status'=> 'error',
                'message' => $validator->errors()
            ];
        }else{
            $id = $request->input('id');

            if(!empty($id)){
                $categoria = CategoriaIngrediente::find($id);

                
                $nombre = $request->input('nombre');

                
                $categoria->nombre = $nombre;
                $categoria->save();

    
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'categoria' => $categoria
                ];
            }else{

                $nombre = $request->input('nombre');

                $categoria = new CategoriaIngrediente();
    
                $categoria->nombre = $nombre;
                $categoria->save();
    
    
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'categoria' => $categoria
                ];
            }

           
        }
        return response()->json($data, $data['code']);
    }


    public function categorias()
    {
        $categorias = CategoriaIngrediente::query();

        return DataTables::eloquent($categorias)
            ->addColumn('Expandir', function ($categoria) {
                return "";
            })
            ->addColumn('Ver', function ($categoria) {
                return '<button id="btnEdit" onclick="ver(' . $categoria->id . ')" class="btn btn-info btn-sm" > <i class="fas fa-eye"></i></button>';
               
            })
            ->addColumn('Editar', function ($categoria) {
                return '<button id="btnEdit" onclick="mostrar(' . $categoria->id . ')" class="btn btn-warning btn-sm mr-1"> <i class="fas fa-pencil-alt"></i></button>'.
                '<button onclick="eliminar(' . $categoria->id . ')" class="btn btn-danger btn-sm ml-1"> <i class="fas fa-trash-alt"></i></button>';
            })
           
            ->rawColumns(['Editar', 'Ver'])
            ->make(true);
    }

    public function destroy($id){
        $categoria = CategoriaIngrediente::find($id);

        if(is_object($categoria)){
            $categoria->delete();

            $data = [
                'code' => 200,
                'status' => 'success',
                'categoria' => $categoria
            ];
        }else{
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'no se encontro la categoria'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function show($id){
        $categoria = CategoriaIngrediente::find($id);

        if(is_object($categoria)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'categoria' => $categoria
            ];
        }else{
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'no se encontro el usuario'
            ];
        }

        return response()->json($data, $data['code']);
    }


    public function store(Request $request){
        
        $id = $request->input('id');
        $id_categoria = $request->input('categoria');
        $nombre = $request->input('nombre');
        $disponible = $request->input('disponible');
        $costo = $request->input('costo');
        $fecha_ingreso = $request->input('fechaIngreso');

        if(empty($id)){
            $validar = $request->validate([
                'categoria' => 'required',
                'disponible' => 'required',
                'costo' => 'required',
                'fechaIngreso' => 'required'
            ]);
           

            $ingrediente = new Ingredientes();
            $ingrediente->id_categoria = $id_categoria;
            $ingrediente->nombre = $nombre;
            $ingrediente->save();

            $costo = trim($costo, 'RD$_');
            $disponible= trim($disponible, "_");


            $inventario = new Inventario();
            $inventario->id_ingrediente = $ingrediente->id;
            $inventario->disponible = $disponible;
            $inventario->costo = $costo;
            $inventario->fecha_ingreso = $fecha_ingreso;
            $inventario->save();

            $data = [
                'code' => 200,
                'status' => 'success',
                'ingrediente' => $ingrediente,
                'message' => 'Ingrediente agregado correctamente"'
            ];
       
        }else{
            $validar = $request->validate([
                'categoria' => 'required',
                'disponible' => 'required',
                'costo' => 'required',
                'fechaIngreso' => 'required'
            ]);
  
            $ingrediente = Ingredientes::find($id);
            $ingrediente->id_categoria = $id_categoria;
            $ingrediente->nombre = $nombre;
            $ingrediente->save();

            $costo = trim($costo, 'RD$_' );
            $disponible= trim($disponible, "_");


            $inventario = Inventario::where('id_ingrediente', $id)->get()->first();
            $inventario->disponible = $disponible;
            $inventario->costo = $costo;
            $inventario->fecha_ingreso = $fecha_ingreso;
            $inventario->save();


            $data = [
                'code' => 200,
                'status' => 'success',
                'ingrediente' => $ingrediente,
                'message' => 'Ingrediente actualizado correctamente'
            ];
        }


        return response()->json($data, $data['code']);
    }

    public function categoriasSelect(){
        $categoria = CategoriaIngrediente::all();

        if(!empty($categoria)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'categoria' => $categoria
            ];
        }else{
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Ocurrio un error'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function ingredientes()
    {
        $ingredientes = DB::table('ingrediente')->join('categoriaingrediente', 'ingrediente.id_categoria', '=', 'categoriaingrediente.id')
        ->join('inventario', 'inventario.id_ingrediente','=', 'ingrediente.id')    
        ->select([
                'ingrediente.id', 'ingrediente.nombre', 'categoriaingrediente.nombre as categoria', 
                'inventario.disponible', 'inventario.costo', 'inventario.fecha_ingreso'
            ]);

        return DataTables::of($ingredientes)
        ->editColumn('fecha_ingreso', function ($ingrediente) {
            return date("d-m-20y", strtotime($ingrediente->fecha_ingreso));
        })
        ->editColumn('costo', function ($ingrediente) {
            return number_format($ingrediente->costo);
        })
        ->addColumn('Opciones', function ($ingrediente) {
            return '<button id="btnEdit" onclick="mostrar(' . $ingrediente->id . ')" class="btn btn-warning btn-sm mr-1"> <i class="fas fa-pencil-alt"></i></button>'.
            '<button onclick="eliminar(' . $ingrediente->id . ')" class="btn btn-danger btn-sm ml-1"> <i class="fas fa-trash-alt"></i></button>';
        })

        ->rawColumns(['Opciones'])
        ->make(true);
    }

    public function destroyIngrediente($id){
        $ingrediente = Ingredientes::find($id);

        if(is_object($ingrediente)){
            $ingrediente->delete();

            $inventario = Inventario::where('id_ingrediente', $id)->get()->last();
            if(is_object($inventario)){
                $inventario->delete();
            }

            $data = [
                'code' => 200,
                'status' => 'success',
                'ingrediente' => $ingrediente
            ];
        }else{
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'no se encontro la categoria'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function showIngrediente($id){
        $ingrediente = Ingredientes::find($id)->load('categoria');

        if(is_object($ingrediente)){
            $inventario = Inventario::where('id_ingrediente', $ingrediente->id)->get()->first();
            $inventario->costo = str_replace('.00', '', $inventario->costo);
            // $inventario->fecha_ingreso =  date("d-m-20y", strtotime($inventario->fecha_ingreso));


            $data = [
                'code' => 200,
                'status' => 'success',
                'ingrediente' => $ingrediente,
                'inventario' => $inventario
            ];
        }else{
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'no se encontro el usuario'
            ];
        }

        return response()->json($data, $data['code']);
    }
}
