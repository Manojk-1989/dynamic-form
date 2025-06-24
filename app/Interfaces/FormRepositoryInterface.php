<?php

namespace App\Interfaces;

interface FormRepositoryInterface
{
    public function getAllForms();
    public function find($id);
    public function create(array $data);
    public function delete($id);
}
