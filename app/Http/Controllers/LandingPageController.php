<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Package;
use App\Models\Addon;
use App\Models\LandingPageContent;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
}
