<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coli extends Model
{
    use HasFactory;
    protected $fillable = [
       'code_bar',
       'destinataire',
       'adresse',
       'telephone',
       'commentaire',
       'quartier',
       'ville_id',
       'prix',
       'etat',
       'ouvrir',
       'fragile',
       'change',
       'client_id',
       'livreur_id'
    ];
}
