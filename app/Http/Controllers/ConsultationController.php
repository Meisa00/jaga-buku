<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ConsultationController extends Controller
{
    public function __invoke(): View
    {
        return view('consultation.index');
    }
}
