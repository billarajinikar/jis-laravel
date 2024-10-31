<?php

namespace App\Http\Controllers;

use App\Models\FAQ;

class FAQController extends Controller
{
    public function index()
    {
        $faqs = FAQ::latest()->take(8)->get(); // Fetch the latest 8 FAQs
        return view('home', compact('faqs'));
    }

    public function allFaqs()
    {
        $faqs = FAQ::all(); // Fetch all FAQs for the FAQ page
        return view('faqs', compact('faqs'));
    }
}
