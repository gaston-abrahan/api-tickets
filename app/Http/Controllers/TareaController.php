<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tarea;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TareaController extends Controller
{
    public function ListarTareas(Request $request)
    {
        try {
            return Tarea::all();
        } catch (\Exception $e) {
            return response(['error' => 'Ocurrió un problema al solicitar las tareas'], 500);
        }
    }


    public function InsertarTarea(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'titulo' => 'required|max:255',
                'contenido' => 'nullable',
                'estado' => 'required|max:50',
                'autor' => 'required|max:100',
            ]);

            if ($validation->fails())
                return response($validation->errors(), 403);

            $tarea = new Tarea();

            $tarea->titulo = $request->post('titulo');
            $tarea->contenido = $request->post('contenido');
            $tarea->estado = $request->post('estado');
            $tarea->autor = $request->post('autor');

            $tarea->save();

            return $tarea;
        } catch (\Exception $e) {
            return response(['error' => 'Ocurrió un problema al guardar la tarea'], 500);
        }
    }

    public function EliminarTarea(Request $request, $id)
    {
        try {
            $tarea = Tarea::findOrFail($id);

            $tarea->delete();

            return [
                "mensaje" => "La tarea con ID $id se eliminó correctamente"
            ];
        } catch (ModelNotFoundException $e) {
            return response(['error' => 'La tarea no se encontró'], 404);
        } catch (\Exception $e) {
            return response(['error' => 'Ocurrió un problema al eliminar la tarea'], 500);
        }
        
    }

    public function ListarUnaTarea(Request $request, $id)
    {
        try {
            $tarea = Tarea::findOrFail($id);
            return $tarea;
        } catch (ModelNotFoundException $e) {
            return response(['error' => 'La tarea no se encontró'], 404);
        } catch (\Exception $e) {
            return response(['error' => 'Ocurrió un problema al solicitar la tarea'], 500);
        }
    }
    
    public function BuscarPorAutor(Request $request, $autor)
    {
        try {
            $tarea = Tarea::where('autor', $autor)->get();

            if ($tarea->isEmpty()) {
                return response(['message' => 'No se encontraron tareas con ese autor'], 404);
            }

            return $tarea;
        } catch (\Exception $e) {
            return response(['error' => 'Ocurrió un problema al buscar tareas por autor'], 500);
        }
    }


    public function ModificarTarea(Request $request, $id)
    {
        try {
            $tarea = Tarea::findOrFail($id);

            $validation = Validator::make($request->all(), [
                'titulo' => 'required|max:255',
                'contenido' => 'nullable',
                'estado' => 'required|max:50',
                'autor' => 'required|max:100',
            ]);

            if ($validation->fails())
                return response($validation->errors(), 403);

            $tarea->update($request->all());

            $tarea->save();

            return $tarea;
        } catch (ModelNotFoundException $e) {
            return response(['error' => 'La tarea no se encontró'], 404);
        } catch (\Exception $e) {
            return response(['error' => 'Ocurrió un problema al modificar la tarea'], 500);
        }
    }

    public function BuscarPorTitulo(Request $request, $titulo)
    {
        try {
            $tarea = Tarea::where('titulo', $titulo)->get();

            if ($tarea->isEmpty()) {
                return response(['message' => 'No se encontraron tareas con ese título'], 404);
            }

            return $tarea;
        } catch (\Exception $e) {
            return response(['error' => 'Ocurrió un problema al buscar tareas por título'], 500);
        }
    }


    public function BuscarPorEstado(Request $request, $estado)
    {
        try {
            $tarea = Tarea::where('estado', $estado)->get();

            if ($tarea->isEmpty()) {
                return response(['message' => 'No se encontraron tareas con ese estado'], 404);
            }

            return $tarea;
        } catch (\Exception $e) {
            return response(['error' => 'Ocurrió un problema al buscar tareas por estado'], 500);
        }
    }
}
