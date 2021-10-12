<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'client_id',
        'image',
        'reference',
        'variante1',
        'variante2',
        'variante3',
        'variante4',
        'valeur1',
        'valeur2',
        'valeur3',
        'valeur4'
    ];
}
