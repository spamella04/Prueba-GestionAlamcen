<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use PDF;
use Mail;
use App\Mail\ReportePDFs;



class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mostrar todos los productos

        $productos = Producto::all();
        return response()->json(['status' => 'success', 'data' => $productos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try{

            $producto = new Producto();
            $producto->nombre = $request->nombre;
            $producto->precio = $request->precio;
            $producto->stock = $request->stock;
            $producto->categoria_id = $request->categoria_id;
            $producto->save();

            return response()->json(['status' => 'success', 'message' => 'Producto creado con exito']);

        }
        catch(\Exception $e){
                
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $value)
    {
        try {
            // Buscar productos cuyo nombre o categoría coincidan con el valor
            $productos = Producto::where('nombre', 'LIKE', "%$value%")
                ->orWhereHas('categoria', function ($query) use ($value) {
                    $query->where('nombre', 'LIKE', "%$value%");
                })
                ->get();
            
            return response()->json(['status' => 'success', 'data' => $productos]);
    
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try{

            $producto = Producto::find($id);
            $producto->nombre = $request->nombre;
            $producto->precio = $request->precio;
            $producto->stock = $request->stock;
            $producto->categoria_id = $request->categoria_id;
            $producto->save();

            return response()->json(['status' => 'success', 'message' => 'Producto actualizado con exito']);
        }
        catch(\Exception $e){
                
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{
                
                $producto = Producto::find($id);
                $producto->delete();
    
                return response()->json(['status' => 'success', 'message' => 'Producto eliminado con exito']);

        }
        catch(\Exception $e){

            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);

        }
    }

    //Generacion de reportes

    public function enviarReportesCorreo($correo)
    {
       
        Mail::to($correo)->send(new ReportePDFs());
    }

    public function generarReportes(Request $request)
    {
        try {

            $request->validate([
                'correo' => 'required|email',
            ]);
           
            $productosPorCategoria = Producto::with('categoria')->get()->groupBy('categoria.nombre');
    
           
            $productos = Producto::all();
            $stockTotal = $productos->sum('stock');
            $valorTotalInventario = $productos->sum(function($producto) {
                return $producto->precio * $producto->stock;
            });
    
            // Generar PDFs
            $pdfListadoProductos = PDF::loadView('reportes.listado_productos', compact('productosPorCategoria'));
            $pdfListadoProductos->save(storage_path('app/public/listado_productos.pdf'));
    
            $pdfStock = PDF::loadView('reportes.reporte_stock', compact('stockTotal', 'valorTotalInventario'));
            $pdfStock->save(storage_path('app/public/reporte_stock.pdf'));
    
            // Enviar PDFs por correo
            $this->enviarReportesCorreo($request->correo); 
    
            return response()->json(['status' => 'success', 'message' => 'Reportes generados y enviados con éxito.']);
    
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

}





