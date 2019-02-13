<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Модель для сущности «пользователь».
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->fillable = [
            'id', 'name', 'email', 'password',
        ];

        $this->hidden = [
            'password', 'remember_token',
        ];

        parent::__construct($attributes);
    }
}
