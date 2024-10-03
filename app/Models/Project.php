<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\ProjectObserver;

#[ObservedBy(ProjectObserver::class)]
class Project extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'title',
    'description',
    'type',
    'platform',
    'published_at',
    'preview',
    'github',
  ];



  public function attachments()
  {
    return $this->hasMany(AttachmentProject::class);
  }

  public function skills()
  {
    return $this->belongsToMany(Skill::class, 'project_skills');
  }

  public function setPublishedAtAttribute($value)
  {
    $this->attributes['published_at'] = Carbon::createFromFormat("m/d/Y", $value)->format("Y-m-d");
  }
  public function getPublishedAtAttribute()
  {
    return Carbon::createFromFormat("Y-m-d", $this->attributes['published_at'])->format("m/d/Y");
  }
}
