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
        $user = UserModel::with('level')->get();
        return view('user', ['data' => $user]);
        //$user = UserModel::with('level')->get();
        //dd($user);
        
        //$user = UserModel::all();
        //return view('user', ['data' => $user]);
        /*
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
        */
        /*
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
        */
        /*
        $user = UserModel::firstOrNew (
            [
                'username' => 'manager23',
                'nama' => 'Manager Tiga Tiga',
                'password' => Hash::make('12345'),
                'level_id' => 2
            ],
        );
        */
        //$user->save(); //Menyimpan didatabase
        /*
        $user = UserModel::firstOrNew (
            [
                'username' => 'manager',
                'nama' => 'Manager',
            ],
        );
        */
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
        /*
        $user = UserModel::firstOrCreate(
            [
                'username' => 'manager',
                'nama' => 'Manager',
            ],
        );
        */

        //Menampilkan jumlah data bila level_id=2
        //$user = UserModel::where('level_id', 2)->count();
        //dd($user);

        //finOrFail & firstOrFail
        //$user = UserModel::findOrFail(1);
        //$user = UserModel::where('username', 'manager9')->firstOrFail();
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

        /*
        $data = [
            'username' => 'customer-1',
            'nama' => 'Pelanggan',
            'password' => Hash::make('12345'),
            'level_id' => 4
        ];
        UserModel::insert($data);
        */

        /*
        $data = [
            'nama' => 'Pelanggan Pertama',
        ];
        UserModel::where('username', 'customer-1')->update($data);
        */

        //DATA UNTUK $fillable
        /*
        $data = [
            'level_id' => 2,
            'username' => 'manager_dua',
            'nama' => 'Manager 2',
            'password' => Hash::make('12345')
        ];
        UserModel::create($data);
        */

        /*
        $data = [
            'level_id' => 2,
            'username' => 'manager_tiga',
            'nama' => 'Manager 3',
            'password' => Hash::make('12345')
        ];
        UserModel::create($data);
        */
        
        // Akses model UserModel
        //$user = UserModel::all();

        //RETRIEVING SINGLE MODELS
        /*
        $user = UserModel::find(1);
        $user = UserModel::where('level_id', 1)->first();
        $user = UserModel::firstWhere('level_id', 1);
        */
        //return view('user', ['data' => $user]);
        //return view('user', ['jumlah' => $user]);
    }

    public function tambah() {
        return view('user_tambah');
    }

    public function tambah_simpan(Request $request) {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make('$request->password'),
            'level_id' => $request->level_id
        ]);

        return redirect('/user');
    }

    public function ubah($id) {
        $user = USerModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }

    public function ubah_simpan($id, Request $request) {
        $user = UserModel::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make('$request->password');
        $user->level_id = $request->level_id;

        $user->save();
        return redirect('/user');
    }

    public function hapus($id) {
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }
}