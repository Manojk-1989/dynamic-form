<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Http\Requests\UserSubmitFormRequest;
use App\Models\UserSubmittedForm;


class FormViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showUserForm(Form $forms)
    {
        $forms = Form::withCount('fields')->latest()->get();
        return view('user.form-list', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function showSelectedUserForm(Form $form)
    {
        $form->load('fields');
        return view('user.form', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function submitUserForm(UserSubmitFormRequest $request, Form $form)
    {
        $validated = $request->validated();
        $userSubmission = UserSubmittedForm::create([
            'form_id' => $form->id,
            'user_submitted_form_data' => $validated,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Form submitted successfully!',
            'submission_id' => $userSubmission->id,
        ]);
    }

    
}
