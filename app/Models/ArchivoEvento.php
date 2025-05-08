<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoEvento extends Model
{
    protected $table = 'archivo_eventos';

    protected $fillable = [
        'nombre_original', 
        'tamaño',
        'mime',
        'evento_id',
        'user_id'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
