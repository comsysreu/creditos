<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 'clientes';
	protected $fillable = ['nombre','apellido','dpi','telefono','estado_civil','sexo','categoria','color'];

	public function creditos()
	{
		return $this->hasMany('App\Creditos', 'clientes_id', 'id');
	}
}
