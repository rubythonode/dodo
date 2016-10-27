<?php
namespace App\Models;

use Peanut\Phalcon\Pdo\Mysql as Db;

class user
{
    public static function checkUser()
    {
        return Db::name('slave')->get1('select count(*) from user') === Db::name('slave')->get1('select count(*) from point') ? Db::name('slave')->get1('select count(*) from point') : 'diff';
    }

    /**
     * @param $name
     */
    public static function getUser($name)
    {
        return Db::name('slave')->get('select * from user where user_name = :user_name', [
            ':user_name' => $name
        ]);
    }

    public static function getUserList()
    {
        return Db::name('slave')->gets('
explain
select
    *
from
    test_user
limit
    :offset, :limit
    ', [
            ':offset' => 0,
            ':limit'  => 10
        ]);

        return Db::name('slave')->gets('elect * from user limit 10');
    }

    /**
     * @param $name
     */
    public static function setUser($name)
    {
        return Db::name('master')->setId('insert into user (user_name) values (:user_name)', [
            ':user_name' => $name
        ]);
    }

    /**
     * @param int $userSeq
     * @param int $point
     */
    public static function setUserPoint(int $userSeq, int $point)
    {
        return Db::name('master')->setId('insert into point (user_seq, point) values (:user_seq, :point)', [
            ':user_seq' => $userSeq,
            ':point'    => $point
        ]);
    }

    public static function truncatUser()
    {
        Db::name('master')->set('truncate table user');
        Db::name('master')->set('truncate table point');
    }
}
