<?php

namespace App\Managers;


use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserManager
{
    /**
     * @param array $columns
     * @return Builder|\Illuminate\Database\Eloquent\Model|null
     */
    public static function findUser(array $columns)
    {
        if (empty($columns)) {
            return null;
        }

        $builder = User::query();

        self::addFilters($builder, $columns);

        return $builder->first();
    }

    /**
     * @param array $data
     * @return Builder|\Illuminate\Database\Eloquent\Model|User
     */
    public static function createUser(array $data)
    {
        return User::query()->create($data);
    }

    /**
     * @param Builder $builder
     * @param array $filters
     * @return Builder
     */
    private static function addFilters(Builder $builder, array $filters)
    {
        $id = (int)($filters['id'] ?? 0);

        if ($id != 0) {
            $builder->where('id', $id);
        }

        $facebookId = (int)($filters['facebook_id'] ?? 0);

        if ($facebookId != 0) {
            $builder->where('facebook_id', $facebookId);
        }

        return $builder;
    }
}
