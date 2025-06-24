<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    protected $table = 'form_fields';

    // Specify primary key (optional because it's 'id' by default)
    protected $primaryKey = 'id';

    // Mass assignable attributes
    protected $fillable = [
        'form_id',
        'label',
        'name_attribute',
        'id_attribute',
        'element_type',
        'required',
        'options',
    ];

    // Cast 'options' JSON column to array automatically
    protected $casts = [
        'options' => 'array',
        'required' => 'boolean',
    ];

    // Relationship to Form
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
