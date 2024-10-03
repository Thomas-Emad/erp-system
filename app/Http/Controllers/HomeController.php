<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Project;
use App\Models\Feedback;

class HomeController extends Controller
{
  public function __invoke()
  {
    if (Cache::has('content')) {
      $cache = Cache::get('content');
      $projects = $cache['projects'];
      $feedbacks = $cache['feedbacks'];
    } else {
      $projects = Project::with(["attachments", "skills"])
        ->orderBy('published_at', 'desc')->get();
      $feedbacks = Feedback::select('name', 'message', 'published_at', 'platform', 'link')
        ->orderBy('published_at', 'desc')->get();

      Cache::set('content', [
        'projects' => $projects,
        'feedbacks' => $feedbacks
      ], 60 * 60 * 24 * 30);
    }
    return view('home', compact("projects", 'feedbacks'));
  }
}
