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
        'ref',
        'type',
        'etat'
    ];
}
