<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name', 'contact_info', 'created_by'];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}