<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $connection='apibank';
    protected $table='registro';
    protected $primaryKey = "id";
    public $timestamps=false;
}