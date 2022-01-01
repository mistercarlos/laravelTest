<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;

    protected $fillable = ['price','proposal','image','document','longitude', 'latitude', 'country','favorite','product_id','user_id'];
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
