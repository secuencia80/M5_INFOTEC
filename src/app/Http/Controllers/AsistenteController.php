<?php

namespace App\Http\Controllers;

use App\Models\Asistente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class AsistenteController extends Controller
{
    // Mostrar lista de asistentes
    public function index()
    {
        $asistentes = Asistente::all();
        $respuesta = [
            'asistentes' => $asistentes,
            'status' => 200
        ];
        return response()->json($respuesta);
    }

    // Crear nuevo asistente
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
            'eventoid' => 'required|exists:eventos,id'
        ]);

        if ($validator->fails()) {
            $respuesta = [
                'message' => 'Datos faltantes o inválidos',
                'status' => 400
            ];
            return response()->json($respuesta, 400);
        }

        $asistente = Asistente::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'eventoid' => $request->eventoid
        ]);

        if (!$asistente) {
            $respuesta = [
                'message' => 'Error al crear el asistente',
                'status' => 500
            ];
            return response()->json($respuesta, 500);
        }

        $respuesta = [
            'asistente' => $asistente,
            'status' => 201
        ];
        return response()->json($respuesta, 201);
    }

    // Mostrar asistente específico
    public function show($id)
    {
        $asistente = Asistente::find($id);
        if (!$asistente) {
            $respuesta = [
                'message' => 'Asistente no encontrado',
                'status' => 404
            ];
            return response()->json($respuesta, 404);
        }
        $respuesta = [
            'asistente' => $asistente,
            'status' => 200
        ];
        return response()->json($respuesta);
    }

    // Actualizar asistente
    public function update(Request $request, $id)
    {
        $asistente = Asistente::find($id);
        if (!$asistente) {
            $respuesta = [
                'message' => 'Asistente no encontrado',
                'status' => 404
            ];
            return response()->json($respuesta, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
            'eventoid' => 'required|exists:eventos,id'
        ]);

        if ($validator->fails()) {
            $respuesta = [
                'message' => 'Datos faltantes o inválidos',
                'status' => 400
            ];
            return response()->json($respuesta, 400);
        }

        $asistente->nombre = $request->nombre;
        $asistente->email = $request->email;
        $asistente->telefono = $request->telefono;
        $asistente->eventoid = $request->eventoid;
        $asistente->save();

        $respuesta = [
            'asistente' => $asistente,
            'status' => 200
        ];
        return response()->json($respuesta);
    }

    // Eliminar asistente
    public function destroy($id)
    {
        $asistente = Asistente::find($id);
        if (!$asistente) {
            $respuesta = [
                'message' => 'Asistente no encontrado',
                'status' => 404
            ];
            return response()->json($respuesta, 404);
        }

        $asistente->delete();
        $respuesta = [
            'message' => 'Asistente eliminado',
            'status' => 200
        ];
        return response()->json($respuesta);
    }
}
