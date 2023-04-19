<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShoppingItem extends Model
{
    use HasFactory;
    protected $fillable = ['food_id','amount','user_id'];
}
