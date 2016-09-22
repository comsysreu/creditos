<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $table = 'usuarios';
	protected $fillable = ['tipo_usuarios_id','nombre','user','estado','sucursales_id'];

	protected $hidden = ['password', 'password_2','remember_token'];
}
