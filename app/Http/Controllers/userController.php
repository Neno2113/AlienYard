<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use  Illuminate\Support\Facades\DB;
use App\User;

class userController extends Controller
{
    public function store(Request $request)
    {

        $id = $request->input('id');
        $nombre = $request->input('name', true);
        $apellido = $request->input('surname', true);
        $edad = $request->input('edad', true);
        $email = $request->input('email', true);
        $username = $request->input('username', true);
        $role = $request->input('role', true);
        $password = $request->input('password', true);
        $direccion = $request->input('direccion', true);
        $telefono = $request->input('telefono', true);
        $celular = $request->input('celular', true);
        $avatar = $request->input('avatar');

        if (empty($id)) {
            $validar = $request->validate([
                'name' => 'required|alpha|',
                'surname' => 'required|alpha',
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ]);
            $pwd = Hash::make($password);

            $user = new User();
            $user->name = $nombre;
            $user->email = $email;
            $user->username = $username;
            $user->password = $pwd;
            $user->role = $role;
            $user->direccion = $direccion;
            $user->telefono = $telefono;
            $user->celular = $celular;
            $user->surname = $apellido;
            $user->edad = $edad;
            $user->avatar = $avatar;

            $user->save();
        } else {
            $validar = $request->validate([
                'name' => 'required|alpha|',
                'surname' => 'required|alpha',
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $pwd = Hash::make($password);

            $user = User::find($id);
            $user->name = $nombre;
            $user->username = $username;
            $user->email = $email;
            $user->password = $pwd;
            $user->role = $role;
            $user->direccion = $direccion;
            $user->telefono = $telefono;
            $user->celular = $celular;
            $user->surname = $apellido;
            $user->edad = $edad;
            $user->avatar = $avatar;

            $user->save();
        }


        $data = [
            'code' => 200,
            'status' => 'success',
            'user' => $user
        ];


        return response()->json($data, $data['code']);
    }


    public function users()
    {
       
        $users = DB::table('users')
            ->select([
                'users.name', 'users.surname', 'users.id',
                'users.role', 'users.email', 'users.edad', 'users.celular'
            ]);

        return DataTables::of($users)
            ->addColumn('Expandir', function ($user) {
                return "";
            })
            ->addColumn('Ver', function ($user) {
                return '<button id="btnEdit" onclick="ver(' . $user->id . ')" class="btn btn-info btn-sm" > <i class="fas fa-eye"></i></button>';
            })
            ->editColumn('role', function ($user) {
                if ($user->role == 1) {
                    return "Administrador";
                } else if ($user->role == 2) {
                    return "Mesero";
                } else if ($user->role == 3) {
                    return "Cocinero";
                } else if ($user->role == 4) {
                    return "General";
                }
            })
            ->addColumn('Editar', function ($user) {
                return '<button id="btnEdit" onclick="mostrar(' . $user->id . ')" class="btn btn-warning btn-sm mr-1"> <i class="fas fa-user-edit "></i></button>' .
                    '<button onclick="eliminar(' . $user->id . ')" class="btn btn-danger btn-sm ml-1"> <i class="fas fa-user-times"></i></button>';
            })

            ->rawColumns(['Editar', 'Ver'])
            ->make(true);
    }

    public function show($id)
    {
     
        $user = User::find($id);

        if (is_object($user)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'user' => $user
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


    public function destroy($id)
    {
        $user = User::find($id);

        if (is_object($user)) {
            $user->delete();

            $data = [
                'code' => 200,
                'status' => 'success',
                'user' => $user
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'no se encontro el user'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function upload(Request $request)
    {
        //validar la imagen 
        $validate = \Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpg,jpeg,png'

        ]);
        // Guardar la imagen
        if ($validate->fails()) {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => $validate->errors()
            ];
        } else {
            $avatar = $request->file('avatar');
            $id = $request->input('user_id');
            $image_name_1 = time() . $avatar->getClientOriginalName();
            // echo $id;
            // die();


            // if (!empty($avatar)) {
            //     $select = DB::select("SHOW TABLE STATUS LIKE 'users'");
            //     $nextId = $select[0]->Auto_increment;

            //     $user = User::find($id);
            //     $user->avatar = $image_name_1;

            //     $user->save();
            // } else {
            //     $data = [
            //         'code' => 400,
            //         'status' => 'error',
            //         'message' => 'WTF'
            //     ];
            // }

            \Storage::disk('avatar')->put($image_name_1, \File::get($avatar));


            $data = [
                'code' => 200,
                'status' => 'success',
                'avatar' => $image_name_1
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function getImage($filename)
    {

        $isset = \Storage::disk('avatar')->exists($filename);
        if ($isset) {

            $file = \Storage::disk('avatar')->get($filename);

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
}
