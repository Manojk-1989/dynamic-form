<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->string('name_attribute')->nullable();
            $table->string('id_attribute')->nullable();
            $table->enum('element_type', ['text', 'number', 'textarea', 'select', 'radio', 'checkbox']);
            $table->boolean('required')->default(false);
            $table->json('options')->nullable()->comment('options as JSON array [{value, description}]');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
