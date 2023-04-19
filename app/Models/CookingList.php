<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CookingList extends Model
{
    use HasFactory;
    protected $fillable = ['menu_id','user_id'];
    public function users()
    {
        return $this->hasOne(User::class);
    }
    public function menus()
    {
        return $this->hasmany(Menu::class);
    }
}
