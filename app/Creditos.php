<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creditos extends Model
{
    protected $table = 'creditos';
	protected $fillable = ['clientes_id','planes_id','montos_prestamo_id','usuarios_creo','usuarios_cobrador','saldo','interes','cuota_diaria','cuota_minima','estado'];
}
