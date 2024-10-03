<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;



class User extends Authenticatable implements JWTSubject
{
  use HasFactory, Notifiable, HasRoles;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'national_id',
    'phone',
    'sallary',
    'wallet',
    'bus_id'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  /**
   * Get the identifier that will be stored in the subject claim of the JWT.
   *
   * @return mixed
   */
  public function getJWTIdentifier()
  {
    return $this->getKey();
  }

  /**
   * Return a key value array, containing any custom claims to be added to the JWT.
   *
   * @return array
   */
  public function getJWTCustomClaims()
  {
    return [];
  }
  private  function calcPriceForHour($start, $end, $todayPrice)
  {
    $start =  Carbon::createFromFormat("H:i:s", $start);
    $end =  Carbon::createFromFormat("H:i:s", $end);

    // Calc Diff for seconds
    $diffInSeconds = abs($end->diffInSeconds($start));
    $hours = $diffInSeconds / 3600;

    // Calc the hours rate based on daily working hours
    $hourlyRate =  $todayPrice /  $hours;
    return $hourlyRate;
  }
  public function priceOneHourForWork()
  {
    return   $this->calcPriceForHour($this->roles->first()->start_work,  $this->roles->first()->end_work, $this->today_price);
  }

  public function sallaries()
  {
    return $this->hasMany(Salary::class, 'employee_id', 'id');
  }
}
