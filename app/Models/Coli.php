<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coli extends Model
{
    use HasFactory;
    protected $fillable = [
        'code_bar',
        'code',
        'paye',
        'destinataire',
        'adresse',
        'telephone',
        'commentaire',
        'quartier',
        'ville_id',
        'prix',
        'etat',
        'ouvrir',
        'retourner',
        'envoyer',
        'fragile',
        'remplacer',
        'client_id',
        'article_id',
        'reported_at'
    ];
}
