<?php

namespace App\Http\Controllers;

use App\Models\Postulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostulacionController extends Controller
{
    /**
     * Guardar nueva postulación
     */
    public function store(Request $request)
    {
        // Validación
        $validator = Validator::make($request->all(), [
            'puesto' => 'required|string|max:255',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'ciudad' => 'required|string|max:255',
            'experiencia' => 'nullable|string|max:255',
            'formacion' => 'required|string|max:255',
            'cv' => 'required|file|mimes:pdf|max:5120', // 5MB máximo
            'carta_presentacion' => 'nullable|string|max:2000',
            'acepto_terminos' => 'required|accepted'
        ], [
            'puesto.required' => 'El puesto es obligatorio',
            'nombres.required' => 'El nombre es obligatorio',
            'apellidos.required' => 'Los apellidos son obligatorios',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser válido',
            'telefono.required' => 'El teléfono es obligatorio',
            'ciudad.required' => 'La ciudad es obligatoria',
            'formacion.required' => 'La formación académica es obligatoria',
            'cv.required' => 'El CV es obligatorio',
            'cv.mimes' => 'El CV debe ser un archivo PDF',
            'cv.max' => 'El CV no debe superar los 5MB',
            'acepto_terminos.accepted' => 'Debes aceptar los términos y condiciones'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Guardar el CV
            $cvPath = null;
            if ($request->hasFile('cv')) {
                $file = $request->file('cv');
                $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                $cvPath = $file->storeAs('postulaciones/cvs', $filename, 'public');
            }

            // Crear la postulación
            $postulacion = Postulacion::create([
                'puesto' => $request->puesto,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'ciudad' => $request->ciudad,
                'experiencia' => $request->experiencia,
                'formacion' => $request->formacion,
                'cv_path' => $cvPath,
                'carta_presentacion' => $request->carta_presentacion,
                'estado' => 'pendiente',
                'ip_address' => $request->ip()
            ]);

            // Aquí puedes agregar envío de email de confirmación
            // Mail::to($postulacion->email)->send(new PostulacionRecibida($postulacion));

            return response()->json([
                'success' => true,
                'message' => '¡Postulación enviada exitosamente! Nos pondremos en contacto contigo pronto.',
                'postulacion_id' => $postulacion->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la postulación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Listar postulaciones (Admin)
     */
    public function index(Request $request)
    {
        $query = Postulacion::orderBy('created_at', 'desc');

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('puesto')) {
            $query->where('puesto', 'like', '%' . $request->puesto . '%');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombres', 'like', "%{$search}%")
                  ->orWhere('apellidos', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $postulaciones = $query->paginate(20);

        return view('admin.postulaciones.index', compact('postulaciones'));
    }

    /**
     * Ver detalle de postulación
     */
    public function show(Postulacion $postulacion)
    {
        return view('admin.postulaciones.show', compact('postulacion'));
    }

    /**
     * Actualizar estado de postulación
     */
    public function updateEstado(Request $request, Postulacion $postulacion)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,en_revision,preseleccionado,rechazado,aceptado',
            'notas_internas' => 'nullable|string|max:2000'
        ]);

        $postulacion->update([
            'estado' => $request->estado,
            'notas_internas' => $request->notas_internas
        ]);

        return redirect()->back()->with('success', 'Estado actualizado exitosamente');
    }

    /**
     * Eliminar postulación
     */
    public function destroy(Postulacion $postulacion)
    {
        // Eliminar el CV
        if ($postulacion->cv_path) {
            Storage::disk('public')->delete($postulacion->cv_path);
        }

        $postulacion->delete();

        return redirect()->route('admin.postulaciones.index')
            ->with('success', 'Postulación eliminada exitosamente');
    }

    /**
     * Descargar CV
     */
    public function downloadCV(Postulacion $postulacion)
    {
        if (!$postulacion->cv_path || !Storage::disk('public')->exists($postulacion->cv_path)) {
            abort(404, 'CV no encontrado');
        }

        return Storage::disk('public')->download($postulacion->cv_path);
    }
}

