<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budaya extends Model
{
    protected $table = 'budaya';
    protected $primaryKey = 'id_budaya';
    public $timestamps = false;

    protected $fillable = ['nama', 'deskripsi'];
}
