<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        /*
        //FILLABLE
        $data = [
            'level_id' => 2,
            'username' => 'manager_dua',
            'nama' => 'Manager 2',
            'password' => Hash::make('12345')
        ];

        $data = [
            'level_id' => 2,
            'username' => 'manager_tiga',
            'nama' => 'Manager 3',
            'password' => Hash::make('12345')
        ];
        UserModel::create($data);

        $user = UserModel::all();
        */

        /*
        //RETRIEVING SINGLE MODELS
        $user = UserModel::find(1);
        return view('user', ['data' => $user]); //mencari user_id = 1

        $user = UserModel::where('level_id', 1)->first(); //mencari level_id = 1
        $user = UserModel::firstWhere('level_id', 1); //shortcut kode program diatasnya
        */

        //findOr
        /*
        $user = UserModel::findOr(1, ['username', 'nama'], function() {
            abort(404);
        });
        */

        $user = UserModel::findOr(20, ['username', 'nama'], function() {
            abort(404);
        });

        return view('user', ['data' => $user]);
    }
}