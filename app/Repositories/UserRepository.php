<?php

namespace App\Repositories;

use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Collection;

class UserRepository
{

    public static function update(User $user, array $attributes = [], array $options = [])
    {
        $attributes['permissions'] = json_encode(
            collect($attributes['permissions'])
                ->reject(function ($value) {
                    return $value == false;
                })
                ->keys()
        );

        if ($attributes['password'] != "") {
            $attributes['password'] = bcrypt($attributes['password']);

            return $user->update($attributes, $options);
        }
        unset($attributes['password']);

        return $user->update($attributes, $options);
    }

    public static function import()
    {
        $users = static::getNewUsers(static::getSageUsers());
        // dd($users);
        $users = static::mapNewUsers($users);

        User::insert($users->toArray());

        return $users->count();
    }

    private static function getSageUsers()
    {
        $users = collect(DB::table('_rtblAgents')
            ->where('bSysAccount', '=', 0)
            ->where('cAgentName', '<>', 'Guest')
            ->get(['idAgents', 'cAgentName', 'cFirstName', 'cLastName', 'cEmail']))->unique('cEmail');
              // dd($users);
        return $users->map(function ($value) {
            return [
                'id' => $value->idAgents,
                'name' => $value->cAgentName,
                'fname' => $value->cFirstName,
                'lname' => $value->cLastName,
                'email' =>$value->cEmail
            ];
        });

    }

    private static function getNewUsers(Collection $sageUsers)
    {
        $users = User::all(['name'])->map(function ($value) {
            return strtolower($value->name);
        })->toArray();

        return $sageUsers->reject(function ($value) use ($users) {
            return in_array(strtolower($value['name']), $users);
        });
        // dd($sageUsers);
    }

    private static function mapNewUsers(Collection $users)
    {
        $now = Carbon::now();

        return $users->map(function ($value) use ($now) {
            return [
                'name' => $value['name'],
                'fname' => $value['fname'],
                'lname' => $value['lname'],
                'email' => $value['email'],
                'password' => bcrypt('123456'),
                'role_id' => 1,
                'permissions' => json_encode([]),
                'created_at' => $now,
                'updated_at' => $now
            ];
        });
    }
}
