<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creditos extends Model
{
    protected $table = 'creditos';
	protected $fillable = ['clientes_id','planes_id','montos_prestamo_id','usuarios_creo','usuarios_cobrador','saldo','interes','cuota_diaria','cuota_minima','estado'];

	public function planes()
	{
		return $this->hasMany('App\Planes', 'id', 'planes_id');
	}

	public function montos()
	{
		return $this->hasMany('App\MontosPrestamo', 'id', 'montos_prestamo_id');
	}

	public function usuariocreador()
	{
		return $this->hasMany('App\Usuarios', 'id', 'usuarios_creo');
	}

	public function usuariocobrador()
	{
		return $this->hasMany('App\Usuarios', 'id', 'usuarios_cobrador');
	}
}
