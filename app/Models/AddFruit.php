<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AddFruit extends Model
{
    use HasFactory;

    protected $table='add_fruits';
    protected $fillable=['image_name','rate','fruit_name'];

    
}
