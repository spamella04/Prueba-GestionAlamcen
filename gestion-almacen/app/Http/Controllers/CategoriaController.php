<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Listar todas las categorias

        $categorias = Categoria::all();
        return response()->json(['status' => 'success', 'data' => $categorias]);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try{
                
                $categoria = new Categoria();
                $categoria->nombre = $request->nombre;
                $categoria->descripcion = $request->descripcion;
                $categoria->save();
    
                return response()->json(['status' => 'success', 'message' => 'Categoria creada con exito']);

        }catch(\Exception $e){

            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $value)
    {
        // Buuscar una categoria por id o nombre

        try{

            $categoria = Categoria::where('id', $value)->orWhere('nombre',$value)->first();
            return response()->json(['status' => 'success', 'data' => $categoria]);
            
        } catch(\Exception $e){

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
            
            $categoria = Categoria::find($id);
            $categoria->nombre = $request->nombre;
            $categoria->descripcion = $request->descripcion;
            $categoria->save();

            return response()->json(['status' => 'success', 'message' => 'Categoria actualizada con exito']);
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
            
            $categoria = Categoria::find($id);
            $categoria->delete();

            return response()->json(['status' => 'success', 'message' => 'Categoria eliminada con exito']);
    } catch(\Exception $e){

        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);

    }
    }
}
