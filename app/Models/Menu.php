<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = "menus";

    protected $fillable = ['menu_category_id', 'menu_img', 'menu_name', 'tax', 'price', 'status'];

    public function scopeActive($query){
        return $query->where('status', 1);
    }

    public function scopeLimitFields($query){
        return $query->select($this->fillable);
    }

    public function menu_category(){
        return $this->belongsTo(MenuCategories::class);
    }
}
