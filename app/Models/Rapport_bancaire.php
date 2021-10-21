<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapport_bancaire extends Model
{
    use HasFactory;
    protected $fillable = [
        'reference'
    ];
}
