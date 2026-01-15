<?php

namespace App\Http\Controllers;

use App\Models\Ponente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class PonenteController extends Controller
{
    // Mostrar lista de ponentes
    public function index()
    {
        $ponentes = Ponente::all();
        $respuesta = [
            'ponentes' => $ponentes,
            'status' => 200
        ];
        return response()->json($respuesta);
    }

    // Crear nuevo ponente
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'biografia' => 'required',
            'especialidad' => 'required'
        ]);

        if ($validator->fails()) {
            $respuesta = [
                'message' => 'Datos faltantes',
                'status' => 400
            ];
            return response()->json($respuesta, 400);
        }

        $ponente = Ponente::create([
            'nombre' => $request->nombre,
            'biografia' => $request->biografia,
            'especialidad' => $request->especialidad
        ]);

        if (!$ponente) {
            $respuesta = [
                'message' => 'Error al crear el ponente',
                'status' => 500
            ];
            return response()->json($respuesta, 500);
        }

        $respuesta = [
            'ponente' => $ponente,
            'status' => 201
        ];
        return response()->json($respuesta, 201);
    }

    // Mostrar ponente específico
    public function show($id)
    {
        $ponente = Ponente::find($id);
        if (!$ponente) {
            $respuesta = [
                'message' => 'Ponente no encontrado',
                'status' => 404
            ];
            return response()->json($respuesta, 404);
        }
        $respuesta = [
            'ponente' => $ponente,
            'status' => 200
        ];
        return response()->json($respuesta);
    }

    // Actualizar ponente
    public function update(Request $request, $id)
    {
        $ponente = Ponente::find($id);
        if (!$ponente) {
            $respuesta = [
                'message' => 'Ponente no encontrado',
                'status' => 404
            ];
            return response()->json($respuesta, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'biografia' => 'required',
            'especialidad' => 'required'
        ]);

        if ($validator->fails()) {
            $respuesta = [
                'message' => 'Datos faltantes',
                'status' => 400
            ];
            return response()->json($respuesta, 400);
        }

        $ponente->nombre = $request->nombre;
        $ponente->biografia = $request->biografia;
        $ponente->especialidad = $request->especialidad;
        $ponente->save();

        $respuesta = [
            'ponente' => $ponente,
            'status' => 200
        ];
        return response()->json($respuesta);
    }

    // Eliminar ponente
    public function destroy($id)
    {
        $ponente = Ponente::find($id);
        if (!$ponente) {
            $respuesta = [
                'message' => 'Ponente no encontrado',
                'status' => 404
            ];
            return response()->json($respuesta, 404);
        }

        $ponente->delete();
        $respuesta = [
            'message' => 'Ponente eliminado',
            'status' => 200
        ];
        return response()->json($respuesta);
    }
}
