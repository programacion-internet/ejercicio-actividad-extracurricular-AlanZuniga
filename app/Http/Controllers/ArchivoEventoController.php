<?php

namespace App\Http\Controllers;

use App\Models\ArchivoEvento;
use App\Models\Evento;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Gate;

use App\Http\Requests\StoreArchivoEventoRequest;
use App\Http\Requests\UpdateArchivoEventoRequest;

class ArchivoEventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Evento $evento)
    {
        if (!$evento->users->contains(auth()->id())) {
            abort(403, 'No te has inscrito a este evento');
        }

        $query = $evento->archivo();
        
        if (!auth()->user()->is_admin) {
            $query->where('user_id', auth()->id());
        }

        $archivos = $query->get();

        return view('eventos.show', compact('evento', 'archivo'));
    }
    public function upload(Request $request, Evento $evento)
    {
        Gate::authorize('upload', $evento);
        
        $request->validate([
            'archivo' => 'required|file|max:10240'
        ]);

        if ($request->file('archivo')->isValid()) {
            $file = $request->file('archivo');
            
            $nombreHash = $file->store('archivos_eventos/' . $evento->id);
            
            ArchivoEvento::create([
                'nombre_original' => $file->getClientOriginalName(),
                'tamaño' => $file->getSize(),
                'mime' => $file->getMimeType(),
                'evento_id' => $evento->id,
                'user_id' => Auth::id()
            ]);
        }

        return redirect()->back()->with('success', 'El archivo se subio con éxito');
    }

    public function download(Evento $evento, ArchivoEvento $archivo)
    {
        Gate::authorize('view', $archivo);
        return Storage::download($archivo->nombre_hash, $archivo->nombre_original);
    }

    public function delete(Evento $evento, ArchivoEvento $archivo)
    {
        Gate::authorize('delete', $archivo);

        Storage::delete($archivo->nombre_hash);
        $archivo->delete();

        return redirect()->back()->with('success', 'Archivo eliminado');
    }
}