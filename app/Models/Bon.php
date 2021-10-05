<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bon extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'livreur_id',
        'region_id',
        'magasin_retour',
        'ref',
        'type',
        'etat'
    ];
}
