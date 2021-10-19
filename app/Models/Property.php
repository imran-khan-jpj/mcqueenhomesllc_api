<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'type', 'description', 'NoOfBeds', 'NoOfBaths', 'propertyFor' , 'longitude', 'latitude', 'currentStatus'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function images(){
        return $this->hasMany(PropertyImage::class);
    }
}
