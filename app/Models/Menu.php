<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    protected $table = 'menus';
    use HasFactory;
    use SoftDeletes;   

    protected $fillable = ['name','user_id'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function cooking_lists()
    {
        return $this->belongsTo(CookingList::class);
    }
    public function food_menus()
    {
        return $this->hasMany(FoodMenu::class,"menu_id");
    }
}