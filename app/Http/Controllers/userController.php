<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

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
            $role = $request->input('role', true);
            $password = $request->input('password', true);
            $direccion = $request->input('direccion', true);
            $telefono = $request->input('telefono', true);
            $celular = $request->input('celular', true);

            if(empty($id)){
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
                $user->password = $pwd;
                $user->role = $role;
                $user->direccion = $direccion;
                $user->telefono = $telefono;
                $user->celular = $celular;
                $user->surname = $apellido;
                $user->edad = $edad;
    
                $user->save();
            }else{
                $validar = $request->validate([
                    'name' => 'required|alpha|',
                    'surname' => 'required|alpha',
                    'email' => 'required|email',
                    'password' => 'required'
                ]);
                
                $user = User::find($id);
                $user->name = $nombre;
                $user->email = $email;
                $user->password = $password;
                $user->role = $role;
                $user->direccion = $direccion;
                $user->telefono = $telefono;
                $user->celular = $celular;
                $user->surname = $apellido;
                $user->edad = $edad;
    
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
        $users = User::query();

        return DataTables::eloquent($users)
            ->addColumn('Expandir', function ($user) {
                return "";
            })
            ->addColumn('Ver', function ($user) {
                return '<button id="btnEdit" onclick="ver(' . $user->id . ')" class="btn btn-info btn-sm" > <i class="fas fa-eye"></i></button>';
               
            })
            ->addColumn('Editar', function ($user) {
                return '<button id="btnEdit" onclick="mostrar(' . $user->id . ')" class="btn btn-warning btn-sm mr-1"> <i class="fas fa-user-edit "></i></button>'.
                '<button onclick="eliminar(' . $user->id . ')" class="btn btn-danger btn-sm ml-1"> <i class="fas fa-user-times"></i></button>';
            })
           
            ->rawColumns(['Editar', 'Ver'])
            ->make(true);
    }

    public function show($id){
        $user = User::find($id);

        if(is_object($user)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'user' => $user
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
