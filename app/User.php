<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 *  - Implementado del metodo de autenticacion JWT
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    // - Atributos
    protected $fillable = ['name', 'email', 'password', 'role', 'listasCreadas', 'listasParticipiantes'];

    // - Atributos escondidos del array
    protected $hidden = ['password', 'remember_token'];

    // - Casteo nativo
    protected $casts = ['email_verified_at' => 'datetime'];

    /**
     * getJWTIdentifier
     *  Summary: Coge el identificador que guardara el token del user
     *
     * @return void
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * getJWTCustomClaims
     * Summary: Devuelve la key deñ array, agegada de JWT
     * 
     * @return void
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * listas
     * Summary: Relacion con del user con la lista (user_id) creada
     *
     * @return void
     */
    public function listas()
    {
        return $this->hasMany(Listas::class);
    }
}
