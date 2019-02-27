<?php

namespace App\Api\Policies;

use App\Api\Models\User;
use App\Api\Models\Item;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

/**
 * Политика доступа к сущности «продукт».
 */
class ItemPolicy
{
    use HandlesAuthorization;

    /**
     * Проверка доступа к просмотру продукта.
     *
     * @param  \App\Api\Models\User $user
     * @param  \App\Api\Models\Item $item
     * @return mixed
     */
    public function view(User $user, Item $item)
    {
        return $user->getAuthIdentifier() === $item->user_id;
    }

    /**
     * Проверка доступа к изменению продукта.
     *
     * @param  User $user
     * @param  Item $item
     * @return mixed
     */
    public function update(User $user, Item $item)
    {
        return $user->getAuthIdentifier() === $item->user_id;
    }

    /**
     * Проверка доступа к удалению продукта.
     *
     * @param  User $user
     * @param  Item $item
     * @return mixed
     */
    public function delete(User $user, Item $item)
    {
        return $user->getAuthIdentifier() === $item->user_id;
    }
}
