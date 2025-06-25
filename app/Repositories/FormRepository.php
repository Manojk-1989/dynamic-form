<?php

namespace App\Repositories;

use App\Models\{Form, FormField};
use App\Interfaces\FormRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FormRepository implements FormRepositoryInterface
{
    // public function all()
    // {
    //     return Form::all();
    // }
    public function getAllForms()
    {
        return Form::withCount('fields')->latest()->paginate(10);
    }

    public function find($id)
    {
        return Form::findOrFail($id);
    }

    public function create(array $data): ?Form
    {
        try {
            return DB::transaction(function () use ($data) {
                // Create the Form first
                $form = Form::create([
                    'title' => $data['title'],
                    'description' => $data['description'] ?? null,
                ]);

                // Prepare arrays for bulk insert
                $labels     = $data['label'] ?? [];
                $names      = $data['name'] ?? [];
                $types      = $data['field_type'] ?? [];
                $requireds  = $data['required'] ?? [];
                $optionsArr = $data['options_or_values'] ?? [];

                $fieldsToInsert = [];

                foreach ($labels as $index => $label) {
                    $options = null;

                    if (!empty($optionsArr[$index]) && strtolower($optionsArr[$index]) !== 'null') {
                        $decoded = json_decode($optionsArr[$index], true);
                        $options = is_array($decoded) ? $decoded : null;
                    }

                    $fieldsToInsert[] = [
                        'form_id'        => $form->id,
                        'label'          => $label,
                        'name_attribute' => $names[$index] ?? null,
                        'element_type'   => $types[$index] ?? null,
                        'required'       => isset($requireds[$index]) && $requireds[$index] == '1',
                        'options'        => $options ? json_encode($options) : null,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ];
                }

                // Single query to insert all fields
                if (count($fieldsToInsert) > 0) {
                    FormField::insert($fieldsToInsert);
                }

                return $form;
            });
        } catch (\Throwable $th) {
            Log::error('Form creation failed: ' . $th->getMessage());
            return null;
        }
    }


    public function updateForm(Form $form, array $data): ?Form
    {
        try {
            return DB::transaction(function () use ($form, $data) {

                $form->update([
                    'title' => $data['title'],
                    'description' => $data['description'] ?? null,
                ]);


                $form->fields()->delete();


                $labels     = $data['label'] ?? [];
                $names      = $data['name'] ?? [];
                $types      = $data['field_type'] ?? [];
                $requireds  = $data['required'] ?? [];
                $optionsArr = $data['options_or_values'] ?? [];

                $fieldsToInsert = [];

                foreach ($labels as $index => $label) {
                    $options = null;

                    if (!empty($optionsArr[$index]) && strtolower($optionsArr[$index]) !== 'null') {
                        $decoded = json_decode($optionsArr[$index], true);
                        $options = is_array($decoded) ? $decoded : null;
                    }

                    $fieldsToInsert[] = [
                        'form_id'        => $form->id,
                        'label'          => $label,
                        'name_attribute' => $names[$index] ?? null,
                        'element_type'   => $types[$index] ?? null,
                        'required'       => isset($requireds[$index]) && $requireds[$index] == '1',
                        'options'        => $options ? json_encode($options) : null,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ];
                }

                // Batch insert new fields
                if (!empty($fieldsToInsert)) {
                    FormField::insert($fieldsToInsert);
                }

                return $form->fresh('fields');
            });
        } catch (\Throwable $th) {
            Log::error('Form update failed: ' . $th->getMessage());
            return null;
        }
    }



    public function deleteForm(Form $form): bool
    {
        try {
            return DB::transaction(function () use ($form) {
                $form->fields()->delete();
                return $form->delete();
            });
        } catch (\Throwable $th) {
            Log::error('Form deletion failed: ' . $th->getMessage());
            return false;
        }
    }


    public function deleteFormField(FormField $formField)
    {
        try {
        return DB::transaction(function () use ($formField) {
            return $formField->delete();
        });
    } catch (\Throwable $th) {
        Log::error('Form field deletion failed: ' . $th->getMessage());
        return false;
    }
    }
}
