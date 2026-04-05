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

        /*
        $user = UserModel::findOr(20, ['username', 'nama'], function() {
            abort(404);
        });
        */

        //findOrFail
        /*
        $user = UserModel::findOrFail(1);
        */

        /*
        // NOT FOUND EXCEPTION
        $user = UserModel::where('username', 'manager9')->firstOrFail();
        */

        /*
        // RETREIVING AGGREGRATES
        $user = UserModel::where('level_id', 2)->count();
        dd($user);
        */

        /*
        // firstOrCreate
        $user = UserModel::firstOrCreate(
            [
                'username' => 'manager',
                'nama' => 'Manager',
            ],
        );
        */

        // firstOrCreate
        // Digunakan untuk mencari username = manager22. Jika tidak ditemukan maka data tersebut akan diinsert ke tabel
        /*
        $user = UserModel::firstOrCreate(
            [
                'username' => 'manager22',
                'nama' => 'Manager Dua Dua',
                'password' => Hash::make('12345'),
                'level_id' => 2
            ],
        );
        */

        //firstOrNew
        //Method untuk mencari sesuatu. Bila Tidak ditemukan akan dibuat objek baru tanpa disimpan didatabase
        $user = UserModel::firstOrNew (
            [
                'username' => 'manager23',
                'nama' => 'Manager Tiga Tiga',
                'password' => Hash::make('12345'),
                'level_id' => 2
            ],
        );

        return view('user', ['data' => $user]);

        //isDirty, isClean
        //Digunakan untuk mengecek perubahan
        //isDirty = tidak terjadi perubahan
        //isClean = terjadi perubahan
        $user = UserModel::create (
            [
                'username' => 'manager55',
                'nama' => 'Manager55',
                'password' => Hash::make('12345'),
                'level_id' => 2,
            ]
        );
        $user->username = 'manager56';

        $user->isDirty(); //true
        $user->isDirty('username'); //true
        $user->isDirty('nama'); //false
        $user->isDirty(['nama', 'username']);//true

        $user->isClean(); //false
        $user->isClean('username'); //false
        $user->isClean('nama'); //true
        $user->isClean(['nama', 'username']); //false

        $user->save();

        $user->isDirty(); //false
        $user->isClean(); //true
        dd($user->isDirty());

        //wasChanged
        //untuk mengecek perubahan apakah benar-benar tersimpan
        $user = UserModel::create (
            [
                'username' => 'manager11',
                'nama' => 'Manager11',
                'password' => Hash::make('12345'),
                'level_id' => 2,
            ]
        );
        $user->username = 'manager12';

        $user->save();

        $user->wasChanged();
        $user->wasChanged('username');
        $user->wasChanged(['username', 'level_id']); //true
        $user->wasChanged('nama');
        dd($user->wasChanged(['nama', 'username'])); //true

        //CRUD ~ Read
        $user = UserModel::all();
        return view('user', ['data' => $user]);
    }
}