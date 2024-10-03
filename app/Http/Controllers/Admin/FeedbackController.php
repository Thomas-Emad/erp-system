<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $feedbacks = Feedback::all();
    return view('pannel.feedback.index', compact("feedbacks"));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('pannel.feedback.feedback-opertions');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|min:5|max:50',
      'email' => 'required|email',
      'message' => 'required|min:5',
      'link' => 'required|url',
      'platform' => 'required|in:upwork,freelancer,other',
      'published_at' => 'required|date',
    ]);
    Feedback::create($request->all());
    return redirect()->route('dashboard.feedbacks.index')->with('success', 'Feedback created successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(Feedback $feedback)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Feedback $feedback)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Feedback $feedback)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Feedback $feedback)
  {
    $feedback->delete();
    return redirect()->route('dashboard.feedbacks.index')->with('success', 'Delete Feedback successfully');
  }
}
