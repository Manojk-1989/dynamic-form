<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSubmittedForm extends Model
{
    use HasFactory;

    protected $table = 'user_submitted_forms';

    protected $fillable = [
        'form_id',
        'user_submitted_form_data',
    ];

    protected $casts = [
        'user_submitted_form_data' => 'array',
    ];
}
