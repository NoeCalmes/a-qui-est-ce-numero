<?php
// app/Models/NumeroTelephone.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NumeroTelephone extends Model
{
    public $timestamps = false;
    protected $table = 'numeros_telephones';
    protected $keyType = 'string';
    protected $primaryKey = 'numero';
    protected $fillable = ['numero', 'average_note'];
    public function verifierNumero($numero)
    {
        return $this->where('numero', $numero)->exists();
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'numero', 'numero');
    }
}
