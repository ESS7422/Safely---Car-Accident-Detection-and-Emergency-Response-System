<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Car;
use App\Models\Medical_case;
use App\Models\Notification;
use App\Http\Controllers\JWTAuth;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'password',
        'confirm_password',
        'date_of_birth',
        'gender',
        'Address',


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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cars()
    {
        return $this->belongsToMany(Car::class,'user_cars');

    }
    public function Medical_cases()
    {
        return $this->BelongsToMany(Medical_case::class,'user_medical_cases');

    }
    public function Notifications()
    {
        return $this->belongsToMany(Notification::class,'User_Notifications');

    }
        public function emergency_contacts()
        {
            return $this->belongsToMany(User::class, 'user_users', 'user_id', 'emergency_contact_id')
                        ->withPivot('relationship');
        }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }



    public static function checkToken($token){
        if($token->token){
            return true;
        }
        return false;
    }
    public static function getCurrentUser($request){
        if(!User::checkToken($request)){
            return response()->json([
             'message' => 'Token is required'
            ],422);
        }

        $user = JWTAuth::parseToken()->authenticate();
        return $user;
     }
}
