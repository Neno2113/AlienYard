<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\User;
use App\PermisoUsuario;

class PermisoController extends Controller
{
    public function store(Request $request)
    {
        $validar = $request->validate([

            'usuario' => 'required',
            'permiso' => 'required'

        ]);

        if (empty($validar)) {

            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Error en la validacion de datos'
            ];
        } else {


            $permiso = $request->input('permiso');
            $user_id = $request->input('usuario');

            $unico = PermisoUsuario::where('user_id', $user_id)
                ->where('permiso', $permiso)->get()->first();

            if (empty($unico)) {
                $permiso_usuario = new PermisoUsuario();

                $permiso_usuario->user_id = $user_id;
                $permiso_usuario->permiso = $permiso;

                $permiso_usuario->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'permiso' => $permiso_usuario->load('user')
                ];
            } else {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Ya existe este permiso'
                ];
            }
        }

        return response()->json($data, $data['code']);
    }

    public function destroy($id)
    {
        $permiso = PermisoUsuario::find($id);

        if (!empty($permiso)) {
            $permiso->delete();

            $data = [
                'code' => 200,
                'status' => 'success',
                'permiso' => $permiso
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Ocurrio un error durante esta operacion'
            ];
        }
        return response()->json($data, $data['code']);
    }

    public function usuarios()
    {
        $usuarios = User::all();

        $data = [
            'code' => 200,
            'status' => 'success',
            'usuarios' => $usuarios
        ];

        return response()->json($data, $data['code']);
    }

    public function permisos()
    {
        $permisos = DB::table('users')
            ->select([
                'users.name', 'users.surname', 'users.id',
                'users.role', 'users.email'
            ])->where('role', 'NOT LIKE', 'Administrador');

        return DataTables::of($permisos)
            ->editColumn('name', function ($permiso) {
                return $permiso->name . " " . $permiso->surname;
            })
            ->editColumn('role', function ($permiso) {
                if($permiso->role == 1){
                    return "Administrador";
                }elseif($permiso->role == 2){
                    return "Mesero";
                }elseif($permiso->role == 3){
                    return "Cocinero";
                }elseif($permiso->role == 4){
                    return "General";
                }
            })
            ->addColumn('Expandir', function ($permiso) {
                return "";
            })
            ->addColumn('Opciones', function ($permiso) {
                return '<button onclick="mostrar(' . $permiso->id . ')" class="btn btn-primary btn-sm ml-1"> <i class="fas fa-user-cog"></i></button>';
            })
            ->rawColumns(['Opciones'])
            ->make(true);
    }

    public function show($id)
    {
        $permiso_usuario = PermisoUsuario::where('user_id', $id)->get()->load('user');

        if (!empty($permiso_usuario)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'permiso' => $permiso_usuario
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
}
