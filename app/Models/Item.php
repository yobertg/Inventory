<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'description', 'price', 'quantity', 'category_id', 'supplier_id', 'created_by'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}