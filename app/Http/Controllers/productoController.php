<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoriaProducto;
use App\CategoriaIngrediente;
use App\Ingredientes;
use App\producto;
use App\Recetas;
use Illuminate\Support\Facades\Validator;
use  Illuminate\Support\Facades\DB;
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

            if (!empty($id)) {
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
            } else {

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
                return '<button id="btnEdit" onclick="mostrar(' . $categoria->id . ')" class="btn btn-warning btn-sm mr-1"> <i class="fas fa-pencil-alt"></i></button>' .
                    '<button onclick="eliminar(' . $categoria->id . ')" class="btn btn-danger btn-sm ml-1"> <i class="fas fa-trash-alt"></i></button>';
            })

            ->rawColumns(['Editar', 'Ver'])
            ->make(true);
    }

    public function destroy($id)
    {
        $categoria = CategoriaProducto::find($id);

        if (is_object($categoria)) {
            $categoria->delete();

            $data = [
                'code' => 200,
                'status' => 'success',
                'categoria' => $categoria
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'no se encontro la categoria'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function show($id)
    {
        $categoria = CategoriaProducto::find($id);

        if (is_object($categoria)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'categoria' => $categoria
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'no se encontro el usuario'
            ];
        }

        return response()->json($data, $data['code']);
    }


    public function categoriasSelect()
    {
        $categoria = CategoriaProducto::all();

        if (!empty($categoria)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'categoria' => $categoria
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

    public function ingredienteSelect(Request $request)
    {
        $categoria = $request->input('categoria');


        $ingrediente = Ingredientes::where('id_categoria', $categoria)->get();

        if (!empty($ingrediente)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'ingrediente' => $ingrediente
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

    public function ingredienteCategoriaSelect()
    {
        $ingrediente = CategoriaIngrediente::all();

        if (!empty($ingrediente)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'categoria' => $ingrediente
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
                'producto' => $image_name_1
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function getImage($filename)
    {

        $isset = \Storage::disk('producto')->exists($filename);
        if ($isset) {

            $file = \Storage::disk('producto')->get($filename);

            //Devolver imagen
            return new Response($file, 200);
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'La imagen no existe'
            ];
        }

        return response()->json($data, $data['code']);
    }


    public function store(Request $request)
    {

        $id = $request->input('id');
        $nombre = $request->input('nombre');
        $categoria = $request->input('categoria');
        $costo = $request->input('costo');
        $imagen = $request->input('imagen');

        if (empty($id)) {
            $validar = $request->validate([
                'nombre' => 'required|unique:producto',
                'categoria' => 'required',
                'costo' => 'required',
                'imagen' => 'required'
            ]);

            $costo = trim($costo, 'RD$_');

            $producto = new Producto();
            $producto->id_categoria = $categoria;
            $producto->precio = $costo;
            $producto->nombre = $nombre;
            $producto->imagen = $imagen;

            $producto->save();


            $data = [
                'code' => 200,
                'status' => 'success',
                'producto' => $producto,
                'message' => 'Producto creado correctamente"'
            ];
        } else {
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

            $costo = trim($costo, 'RD$_');
            $disponible = trim($disponible, "_");


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

    public function storeReceta(Request $request)
    {
        $producto = $request->input('producto');
        $ingrediente = $request->input('id_ingrediente');

        $validar = $request->validate([
            'id_ingrediente' => 'required|unique:recetas',
        ]);

        if (!empty($producto)) {
            $receta = new Recetas();
            $receta->id_producto = $producto;
            $receta->id_ingrediente = $ingrediente;
            $receta->save();

            $data = [
                'code' => 200,
                'status' => 'success',
                'receta' => $receta->load('producto')->load('ingrediente')
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No hay ningun producto para guardar'
            ];
        }

        return response($data, $data['code']);
    }

    public function delIngrediente($id){
        $receta = Recetas::find($id);

        if(is_object($receta)){

            $receta->delete();

            $data = [
                'code' => 200,
                'status' => 'success',
                'receta' => $receta
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

    
    public function productos()
    {
        $productos = DB::table('producto')->join('categoriaproducto', 'producto.id_categoria', '=', 'categoriaproducto.id')
            ->select([
                'producto.id', 'producto.nombre', 'categoriaproducto.nombre as categoria',
                'producto.precio'
            ]);

        return DataTables::of($productos)
            ->editColumn('precio', function ($producto) {
                return number_format($producto->precio);
            })
            ->addColumn('Opciones', function ($producto) {
                return '<button id="btnEdit" onclick="mostrar(' . $producto->id . ')" class="btn btn-warning btn-sm mr-1"> <i class="fas fa-pencil-alt"></i></button>' .
                    '<button onclick="eliminar(' . $producto->id . ')" class="btn btn-danger btn-sm ml-1"> <i class="fas fa-trash-alt"></i></button>';
            })

            ->rawColumns(['Opciones'])
            ->make(true);
    }

    public function destroyProducto($id)
    {
        $producto = producto::find($id);

        if (is_object($producto)) {
            $producto->delete();

            $data = [
                'code' => 200,
                'status' => 'success',
                'producto' => $producto
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'no se encontro la categoria'
            ];
        }

        return response()->json($data, $data['code']);
    }

    
    public function showProducto($id)
    {
        $receta = Recetas::where('id_producto', $id)->get()->load('producto')->load('ingrediente');

        if (!empty($receta)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'receta' => $receta
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'no se encontro el usuario'
            ];
        }

        return response()->json($data, $data['code']);
    }


}
