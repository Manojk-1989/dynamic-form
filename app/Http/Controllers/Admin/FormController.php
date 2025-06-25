<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FormBuilderRequest;
use App\Interfaces\FormRepositoryInterface;
use App\Http\Resources\FormResource;
use App\Models\{Form, FormField};
use App\Events\FormCreated;
use App\Jobs\SendFormCreatedEmailJob;

class FormController extends Controller
{
    protected $formRepo;

    public function __construct(FormRepositoryInterface $formRepo)
    {
        $this->formRepo = $formRepo;
    }


    /**
     * Display a listing of the resource.
     */
    public function showCreateForm()
    {
        return view('admin.pages.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createForm(FormBuilderRequest $request)
    {
        $validated = $request->validated();
        $forms = $this->formRepo->create($validated);
        if (!$forms) {
            return returnJsonResponse(
                'failed',
                'Form creation failed.',
                null,
                500
            );
        }
        // event(new FormCreated($forms));
        SendFormCreatedEmailJob::dispatch($forms);

        return returnJsonResponse(
            'success',
            'Form created successfully.',
            new FormResource($forms),
            201
        );
    }

    /**
     * Show the form for editing the specified form.
     */
    public function editForm(Form $form)
    {
        $form->load('fields');
        return view('admin.pages.form', compact('form'));
    }

    /**
     * Update the specified form.
     */
    public function updateForm(FormBuilderRequest $request, Form $form)
    {
        $validated = $request->validated();

        $updatedForm = $this->formRepo->updateForm($form, $validated);
        if (!$updatedForm) {
            return returnJsonResponse(
                'failed',
                'Form updation failed.',
                null,
                500
            );
        }

        return returnJsonResponse(
            'success',
            'Form updated successfully.',
            new FormResource($updatedForm),
            200
        );
    }

    /**
     * Remove the specified form.
     */
    public function deleteForm(Form $form)
    {
        $formDeleted = $this->formRepo->deleteForm($form);
        // dd($formDeleted);
        if ($formDeleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Form deleted successfully.',
                'redirect' => route('admin.forms.index'),
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'message' => 'Form deletion failed.',
            'data' => null
        ], 500);
    }


    /**
     * Remove the specified form element.
     */
    public function deleteFormElement($fieldId)
    {
        $formField = FormField::findOrFail($fieldId);
        $formFieldDeleted = $this->formRepo->deleteFormField($formField);
        if ($formFieldDeleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Form field deleted successfully.',
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'message' => 'Form field deletion failed.',
            'data' => null
        ], 500);
    }
}
