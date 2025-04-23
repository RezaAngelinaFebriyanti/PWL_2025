<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\LevelModel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user'; //mendefinisikan nama tabel yg digunakan oleh model ini
    protected $primaryKey = 'user_id'; //mendefiniskan pk dari tabel yg digunakan
    protected $fillable = ['username', 'password', 'nama', 'level_id', 'created_at', 'update_at','profile_photo'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    public function getRoleName(){
        return $this->level->level_nama;
    }

    public function hasRole($role){
        return $this->level->level_id == $role;
    }

    public function getRole(){
        return $this->level->level_kode;
    }
}