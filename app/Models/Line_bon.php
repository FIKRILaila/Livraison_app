<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Line_bon extends Model
{
    use HasFactory;
    protected $fillable = [
        'bon_id',
        'colis_id',
        'valide'
    ];
}
