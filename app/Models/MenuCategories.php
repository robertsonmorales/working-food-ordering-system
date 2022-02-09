<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuCategories extends Model
{
    use HasFactory;

    protected $table = "menu_categories";

    protected $fillable = ['category_name', 'status'];

    public function scopeActive($query){
        return $query->where('status', 1);
    }

    public function scopeLimitFields($query){
        return $query->select(array_merge($this->fillable, ['id']));
    }

    public function menus(){
        return $this->hasMany(Menu::class, 'menu_category_id', 'id');
    }
}
