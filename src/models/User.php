<?php
namespace spl2025\models;     
    
/**
 * Userカウントクラス
 */
class User extends Model
{
    protected $table = "tbl_user";
    
    function auth($uid, $upass)
    {
        return $this->getDetail("uid='{$uid}' AND upass='{$upass}'");
    }
}