<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture_rapport extends Model
{
    use HasFactory;
    protected $fillable = [
        'facture_id',
        'rapport_id',
    ];
}
