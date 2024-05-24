<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    protected $table = 'commentaires';
    protected $primaryKey = 'id';
    public $timestamps = false;

   
    protected $fillable = ['numero', 'choix_commentaire', 'commentaire', 'date-commentaire'];
    

    public function numeroTelephone()
    {
        return $this->belongsTo(NumeroTelephone::class, 'numero');
    }

    public function sousCommentaires()
    {
        return $this->hasMany(SousCommentaires::class, 'commentaire_id');
    }

    // Fonction pour incrémenter le nombre de likes

}
