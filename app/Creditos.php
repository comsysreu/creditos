<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creditos extends Model
{
    protected $table = 'creditos';
	protected $fillable = ['clientes_id','planes_id','montos_prestamo_id','usuarios_creo','usuarios_cobrador','saldo','interes','deudatotal','cuota_diaria','cuota_minima','fecha_inicio','fecha_fin','estado'];

	public function planes()
	{
		return $this->hasOne('App\Planes', 'id', 'planes_id');
	}

	public function montos()
	{
		return $this->hasOne('App\MontosPrestamo', 'id', 'montos_prestamo_id');
	}

	public function usuariocreador()
	{
		return $this->hasOne('App\Usuarios', 'id', 'usuarios_creo');
	}

	public function usuariocobrador()
	{
		return $this->hasOne('App\Usuarios', 'id', 'usuarios_cobrador');
	}
	public function cliente()
	{
		return $this->hasOne('App\Clientes','id','clientes_id');
	}
	public function detalleCreditos()
	{
		return $this->hasMany('App\CreditosDetalle','creditos_id','id');
	}
}
