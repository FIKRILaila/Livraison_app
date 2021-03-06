<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;
    protected $fillable = [
        'reference',
        'etat_f',
        'Montant',
        'date',
        'client_id'
    ];
}
