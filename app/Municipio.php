<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model {

    protected $table = 'municipios';
    protected $guarded = [];

    public static function buscar($id){
      return Municipio::where('departamento_id', '=', $id)->orderBy('nombre', 'asc')->get();
    }
}
