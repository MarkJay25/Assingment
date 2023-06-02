<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;
    protected $fillable  = [
        'id',
        'ResidentNo',
        'FirstName',
        'MiddleName',
        'LastName',
        'DateofBIrth',
        'PlaceofBirth',
        'CivilStatus',
    ];
    protected $table = 'Residents';
}
