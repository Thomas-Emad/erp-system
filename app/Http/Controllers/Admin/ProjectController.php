<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $projects = Project::all();
    return view('pannel.project.index', compact("projects"));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $skills = Skill::all();
    return view('pannel.project.project-opertions', compact('skills'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'mockup' => "required|image|mimes:jpeg,png,jpg|max:2048",
      'title' => "required|string|min:5|max:50",
      'description' => "required|string|min:10|max:1000",
      'type' => "required|in:null,personal,professional",
      'platform' => "nullable|in:null,upwork,freelancer,other",
      'published_at' => "nullable|date",
      'preview' => "nullable|url",
      'github' => "nullable|url",
      'attachments' => "required|array|min:1",
      'attachments.*' => "required|image|mimes:jpeg,png,jpg|max:2048",
      'skills' => "required|array|min:1|exists:skills,id",
    ]);

    $project = Project::create([
      'title' => $request->title,
      'description' => $request->description,
      'type' => $request->type,
      'platform' => $request->platform,
      'published_at' => $request->published_at,
      'preview' => $request->preview,
      'github' => $request->github,
    ]);

    // Upload Files
    $filename = $request->mockup->hashName();
    $request->mockup->storeAs('projects', $filename, 'public');
    $project->attachments()->create([
      'attachment' => $filename,
      'banner' => true
    ]);

    foreach ($request->attachments as $attachment) {
      $filename = $attachment->hashName();
      $attachment->storeAs('projects', $filename, 'public');
      $project->attachments()->create([
        'attachment' => $filename,
      ]);
    }

    // Upload Skills
    $project->skills()->attach($request->skills);

    return redirect()->route('dashboard.projects.index')->with('success', 'Project created successfully');
  }


  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $project = Project::with(['attachments', 'skills'])->findOrFail($id);
    return response()->json($project);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Project $project)
  {
    $skills = Skill::all();
    return view('pannel.project.project-opertions', compact('project', 'skills'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Project $project)
  {
    $project->load(['attachments', 'skills']);

    $request->validate([
      'mockup' => "nullable|image|mimes:jpeg,png,jpg|max:2048",
      'title' => "required|string|min:5|max:50",
      'description' => "required|string|min:10|max:1000",
      'type' => "required|in:null,personal,professional",
      'platform' => "nullable|in:null,upwork,freelancer,other",
      'published_at' => "nullable|date",
      'preview' => "nullable|url",
      'github' => "nullable|url",
      'attachments' => "nullable|array|min:1",
      'attachments.*' => "nullable|image|mimes:jpeg,png,jpg|max:2048",
      'skills' => "required|array|min:1|exists:skills,id",
    ]);

    $project->update([
      'title' => $request->title,
      'description' => $request->description,
      'type' => $request->type,
      'platform' => $request->platform,
      'published_at' => $request->published_at,
      'preview' => $request->preview,
      'github' => $request->github,
    ]);

    // Upload Files
    if ($request->mockup) {
      @Storage::delete('projects/' . $project->attachments()->where('banner', true)->first()->attachment);
      $filename = $request->mockup->hashName();
      $request->mockup->storeAs('projects', $filename, 'public');
      $project->attachments()->where('banner', true)->first()->update([
        'attachment' => $request->mockup->hashName(),
      ]);
    }

    if ($request->attachments) {
      foreach ($project->attachments()->where('banner', false)->get() as $attachment) {
        @Storage::delete('projects/' . $attachment->attachment);
      }
      $project->attachments()->delete();

      foreach ($request->attachments as $attachment) {
        $filename = $attachment->hashName();
        $attachment->storeAs('projects', $filename, 'public');
        $project->attachments()->create([
          'attachment' => $filename,
        ]);
      }
    }

    // Upload Skills
    $project->skills()->sync($request->skills);

    return redirect()->route('dashboard.projects.index')->with('success', 'Project created successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Project $project)
  {
    foreach ($project->attachments as $attachment) {
      @Storage::delete('projects/' . $attachment->attachment);
    }

    $project->delete();
    return redirect()->route('dashboard.projects.index')->with('success', 'Project deleted successfully');
  }
}
