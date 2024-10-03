<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\FeedbackObserver;


#[ObservedBy(FeedbackObserver::class)]
class Feedback extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'email',
    'message',
    'link',
    'platform',
    'published_at'
  ];

  public function setPublishedAtAttribute($value)
  {
    $this->attributes['published_at'] = Carbon::createFromFormat("m/d/Y", $value)->format("Y-m-d");
  }
  public function getPublishedAtAttribute()
  {
    return Carbon::createFromFormat("Y-m-d", $this->attributes['published_at'])->format("m/d/Y");
  }
}
