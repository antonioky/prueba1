<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;

class ArticuloController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar = $request ->buscar;
        $criterio = $request ->criterio;

        if($buscar=='')
        {
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->orderBy('articulos.id', 'desc')->paginate(2);
        }
        else
        {
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->select('articulos.id','articulos.idcategoria','articulos.codigo','articulos.nombre','categorias.nombre as nombre_categoria','articulos.precio_venta','articulos.stock','articulos.descripcion','articulos.condicion')
            ->where('articulos.'.$criterio, 'like', '%' . $buscar . '%')
            ->orderBy('articulos.id', 'desc')->paginate(2);

            
        }
      
        return[
             'pagination' => [
                'total'         => $articulos->total(), /*total de paginas*/ 
                'current_page'  => $articulos->currentPage(), /* pagina ctual*/
                'per_page'      => $articulos->perPage(),/*registros por pagina */
                'last_page'     => $articulos->lastPage(),/*ultima pagina */
                'from'          => $articulos->firstItem(),/*primera pagina */
                'to'            => $articulos->lastItem(),/*ultima pagina */
            ],
            'articulos' => $articulos 
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $articulo = new Articulo();
        $articulo->idcategoria = $request->idcategoria();
        $articulo->codigo=$request->codigo;
        $articulo->nombre=$request->nombre;
        $articulo->precio_venta=$request->precio_venta;
        $articulo->stock=$request->stock;
        $articulo->descripcion=$request->descripcion;
        $articulo->condicion='1';
        $articulo->save();
    }



    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->idcategoria = $request->idcategoria();
        $articulo->codigo=$request->codigo;
        $articulo->nombre=$request->nombre;
        $articulo->precio_venta=$request->precio_venta;
        $articulo->stock=$request->stock;
        $articulo->descripcion=$request->descripcion;
        $articulo->condicion='1';
        $articulo->save();
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion='0';
        $articulo->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion='1';
        $articulo->save();
    }


}
