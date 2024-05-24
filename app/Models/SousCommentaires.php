<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class SousCommentaires extends Model
{
    protected $table = 'sous_commentaires';
    protected $primaryKey = 'id';
    protected $allowedFields = ['commentaire_id', 'date_sous_commentaire', 'sous_commentaire'];
    public $timestamps = false;


    // Les relations éventuelles avec d'autres modèles peuvent être définies ici
    public function commentaire()
    {
        return $this->belongsTo(Commentaire::class, 'commentaire_id');
    }
}





