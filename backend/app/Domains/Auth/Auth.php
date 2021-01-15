<?php

namespace App\Domains\Auth;


use App\User;

class Auth
{
    private static $auth;

    /**
     * @var User
     */
    private static $user;

    protected function __construct($user)
    {
        self::$user = $user;
    }

    protected function __clone() { }

    public static function authorizeById(int $id)
    {
        if (!self::$auth) {
            $user = User::find($id);

            self::$auth = new static($user);
        }
        return self::$user;
    }

    public static function authorizeByEmail(string $email)
    {
        if (!self::$auth) {
            $user = User::where('email', $email)->first();
            self::$auth = new static($user);
        }
        return self::$user;
    }

    public static function getAuthUser()
    {
        return self::$user;
    }

    public static function getAuthUserId()
    {
        return self::$user ? self::$user->id : null;
    }

    public static function deleteAuthUser()
    {
        self::$auth = null;
        self::$user = null;
    }
}
