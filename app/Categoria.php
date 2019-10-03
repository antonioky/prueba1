<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model 
{
    protected $table ='categorias';
    protected $primarykey='id';
    protected $fillable=['nombre','descripcion','condicion'];

    //protected $timestamps =true;

    public function articulos()
    {
        return $this->hasMany('App\Articulo');
    }
}
