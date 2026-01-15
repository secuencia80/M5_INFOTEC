<?php


namespace App\Http\Controllers;


use App\Models\Evento;  // Agregar el modelo Evento
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;  // Agregar la clase Validator


class EventoController extends Controller
{
    // Mostrar una lista del recurso.
    public function index()
    {
        // Recuperar todos los recursos (eventos)
        $eventos = Evento::all();


        // Retornar los recursos recuperados
        $respuesta = ['eventos' => $eventos, 'status' => 200];
        return response()->json($respuesta);
    }


    // Almacenar un recurso recién creado en el almacenamiento.
    public function store(Request $request)
    {
        // Validar que la petición contenga todos los datos necesarios
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'ubicacion' => 'required',
        ]);


        // Si la petición no contiene todos los datos necesarios, retornar un mensaje de error
        if ($validator->fails()) {
            $respuesta = ['message' => 'Datos faltantes', 'status' => 400];
            return response()->json($respuesta, 400);
        }


        // Crear un nuevo recurso con los datos de la petición
        $evento = Evento::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'ubicacion' => $request->ubicacion,
        ]);


        // Si el recurso no se pudo crear, retornar un mensaje de error
        if (!$evento) {
            $respuesta = ['message' => 'Error al crear el evento', 'status' => 500];
            return response()->json($respuesta, 500);
        }


        // Retornar el recurso creado
        $respuesta = ['evento' => $evento, 'status' => 201];
        return response()->json($respuesta, 201);
    }


    // Mostrar el recurso especificado.
    public function show($id)
    {
        // Recuperar el recurso especificado
        $evento = Evento::find($id);


        // Si el recurso no se pudo recuperar, retornar un mensaje de error
        if (!$evento) {
            $respuesta = ['message' => 'Evento no encontrado', 'status' => 404];
            return response()->json($respuesta, 404);
        }


        // Retornar el recurso recuperado
        $respuesta = ['evento' => $evento, 'status' => 200];
        return response()->json($respuesta);
    }


    // Actualizar el recurso especificado en el almacenamiento.
    public function update(Request $request, $id)
    {
        // Recuperar el recurso especificado
        $evento = Evento::find($id);


        // Si el recurso no se pudo recuperar, retornar un mensaje de error
        if (!$evento) {
            $respuesta = ['message' => 'Evento no encontrado', 'status' => 404];
            return response()->json($respuesta, 404);
        }


        // Validar que la petición contenga todos los datos necesarios
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'ubicacion' => 'required',
        ]);


        // Si la petición no contiene todos los datos necesarios, retornar un mensaje de error
        if ($validator->fails()) {
            $respuesta = ['message' => 'Datos faltantes', 'status' => 400];
            return response()->json($respuesta, 400);
        }


        // Actualizar el recurso especificado con los datos de la petición
        $evento->titulo = $request->titulo;
        $evento->descripcion = $request->descripcion;
        $evento->fecha_inicio = $request->fecha_inicio;
        $evento->fecha_fin = $request->fecha_fin;
        $evento->ubicacion = $request->ubicacion;
        $evento->save();


        // Retornar el recurso actualizado
        $respuesta = ['evento' => $evento, 'status' => 200];
        return response()->json($respuesta);
    }


    // Eliminar el recurso especificado del almacenamiento.
    public function destroy($id)
    {
        // Recuperar el recurso especificado
        $evento = Evento::find($id);


        // Si el recurso no se pudo recuperar, retornar un mensaje de error
        if (!$evento) {
            $respuesta = ['message' => 'Evento no encontrado', 'status' => 404];
            return response()->json($respuesta, 404);
        }


        // Eliminar el recurso especificado
        $evento->delete();


        // Retornar un mensaje de éxito
        $respuesta = ['message' => 'Evento eliminado', 'status' => 200];
        return response()->json($respuesta);
    }
}