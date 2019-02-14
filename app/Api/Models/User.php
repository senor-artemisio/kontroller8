<?php

namespace App\Api\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * Модель для сущности «пользователь».
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->incrementing = false;
        $this->fillable = [
            'id', 'name', 'email', 'password',
        ];

        $this->hidden = [
            'password', 'remember_token',
        ];

        parent::__construct($attributes);
    }
}
