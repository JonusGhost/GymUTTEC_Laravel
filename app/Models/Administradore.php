<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Administradores extends Model
{
    use HasFactory;
    protected $table = 'administradores';
    protected $primaryKey = 'num_empleado'; 
    public $incrementing = false; 
    protected $keyType = 'string';
}

class Administradore extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $table = 'administradores';
    protected $primaryKey = 'num_empleado'; 
    public $incrementing = false; 
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'num_empleado',
        'nombre',
        'email',
        'password',
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
    protected function casts()
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}