<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $about = About::first();
        $services = Service::all();
        $skills = Skill::all();
        $educations = Education::orderBy('id', 'desc')->get();
        $experiences = Experience::orderBy('id', 'desc')->get();
        $projects = Project::all();
        $testimonials = Testimonial::all();

        return Inertia::render('Home', [
            'about' => $about,
            'services' => $services,
            'skills' => $skills,
            'educations' => $educations,
            'experiences' => $experiences,
            'projects' => $projects,
            'testimonials' => $testimonials,
        ]);
    }
}

