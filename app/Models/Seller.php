<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;
    protected $fillable = ['price','description','image','document','longitude', 'latitude', 'country','active','product_id','user_id'];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function product()
    {
        return $this->belongsTo('App\Models\MasterProduct','product_id');
    }   

    protected $hidden = [
        'product_id','user_id',
        'created_at','updated_at'

    ];
}
