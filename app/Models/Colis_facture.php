<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colis_facture extends Model
{
    use HasFactory;
    protected $fillable = [
        'colis_id',
        'facture_id'
    ];
}
