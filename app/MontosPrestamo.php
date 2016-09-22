<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MontosPrestamo extends Model
{
    protected $table = 'montos_prestamo';
	protected $fillable = ['monto','sucursales_id'];
}
