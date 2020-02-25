<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoriaIngrediente;
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
}
