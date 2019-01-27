<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class FormfieldController extends Controller
{

    public function index($formId)
    {
        dump($formId);
        exit();
    }
}
