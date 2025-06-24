<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    // Table name (optional if it matches "forms")
    protected $table = 'forms';

    protected $primaryKey = 'id';

    // Mass assignable attributes
    protected $fillable = [
        'title',
        'description',  // assuming you have this in your migration
    ];

    public function fields()
    {
        return $this->hasMany(FormField::class);
    }
}
