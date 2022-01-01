<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProduct extends Model
{
    use HasFactory;
    protected $table="master_products";
    protected $fillable = ['code','name'];

    protected $hidden = [
        'created_at','updated_at'
    ];
}
