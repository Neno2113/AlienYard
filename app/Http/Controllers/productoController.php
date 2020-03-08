<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoriaProducto;
use App\Ingredientes;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class productoController extends Controller
{
    public function storeCategoria(Request $request)
    {

        $validar = $request->validate([
            'nombre' => 'required'
        ]);

        if (empty($validar)) {

            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Error en la validacion de datos'
            ];
        } else {

            $id = $request->input('id');

            if(!empty($id)){
                $categoria = CategoriaProducto::find($id);

                
                $nombre = $request->input('nombre');

                
                $categoria->nombre = $nombre;
                $categoria->save();

    
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'categoria' => $categoria,
                    'message' => 'Categoria creada correctamente!'
                ];
            }else{

                $nombre = $request->input('nombre');

                $categoria = new CategoriaProducto();
    
                $categoria->nombre = $nombre;
                $categoria->save();
    
    
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'categoria' => $categoria,
                    'message' => 'Categoria actualizada correctamente!'
                ];
            }
        }

        return response()->json($data, $data['code']);
    }

    public function categorias()
    {
        $categorias = CategoriaProducto::query();

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
        $categoria = CategoriaProducto::find($id);

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
        $categoria = CategoriaProducto::find($id);

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


    public function categoriasSelect(){
        $categoria = CategoriaProducto::all();

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

    public function ingredienteSelect(){
        $ingrediente = Ingredientes::all();

        if(!empty($ingrediente)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'ingrediente' => $ingrediente
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

    public function upload(Request $request)
    {
        //validar la imagen 
        $validate = \Validator::make($request->all(), [
            'producto_imagen' => 'required|image|mimes:jpg,jpeg,png'
           
        ]);
        // Guardar la imagen
        if ($validate->fails()) {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => $validate->errors()
            ];
        } else {
            $producto = $request->file('producto_imagen');
            $image_name_1 = time() . $producto->getClientOriginalName();
           
            \Storage::disk('producto')->put($image_name_1, \File::get($producto));
      

            $data = [
                'code' => 200,
                'status' => 'success',
                'producto' =>$image_name_1
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function getImage($filename){
        
        $isset = \Storage::disk('producto')->exists($filename);
        if($isset){
           
            $file = \Storage::disk('producto')->get($filename);

            //Devolver imagen
            return new Response($file, 200);

        }else{
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'La imagen no existe'
            ];
        }

        return response()->json($data, $data['code']);
    }


}
