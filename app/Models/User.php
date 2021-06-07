<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'joining_date',
        'leaving_date',
        'still_working'
    ];

    public function getExperienceAttribute(){
        $joining_date = $this->joining_date;
        $leaving_date = $this->still_working ? Carbon::now() : $this->leaving_date;
        $years = Carbon::parse($joining_date)->diffInYears(Carbon::parse($leaving_date));
        $total_months = Carbon::parse($joining_date)->diffInMonths(Carbon::parse($leaving_date));
        $months = $total_months % 12 ;
        $experience = $years.' Years';
        return $months > 0 ? $experience.' '.$months.' Months' : $experience;
    }
}
