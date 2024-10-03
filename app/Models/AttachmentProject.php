<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentProject extends Model
{
  use HasFactory;

  protected $fillable = [
    'attachment',
    'name',
    'banner',
    'project_id'
  ];
}
