<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaiverController extends Controller
{
    public function index() {
        return view('waivers.index');
    }

    public function individual() {
        return view('waivers.individual');
    }

    public function dependent() {
        return view('waivers.dependent');
    }
}
