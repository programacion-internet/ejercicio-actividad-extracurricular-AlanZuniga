<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventoRequest;
use App\Http\Requests\UpdateEventoRequest;

use App\Mail\ConfirmarInscripcion;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //se muestran eventos futuros
        $eventos = Evento::where('fecha', '>=', now())->get();
        
        return view('eventos.evento-index', compact('eventos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Evento $evento)
    {
        $archivos = auth()->user()->is_admin 
            ? $evento->archivo()->with('user')->get() 
            : $evento->archivo()->where('user_id', auth()->id())->get();
    
        return view('eventos.evento-show', [
            'evento' => $evento,
            'archivo' => $archivo
    ]); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evento $evento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventoRequest $request, Evento $evento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento $evento)
    {
        //
    }
    //uso de gates para autorizar la insrpcion-------------------------------------------
    public function inscribir(Request $request, Evento $evento)
    {
        Gate::authorize('inscribir', $evento);
    
        $user = $request->user();
        $evento->users()->attach($user->id);

        //se envia confirmaciond el correo
        Mail::to($user->email)->send(new InscripcionConfirmada($evento, $user));

        return back()->with('success', 'Inscripción completada');

    }
}
