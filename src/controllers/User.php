<?php
namespace spl2025\controllers; 

/**
 * Userアカウントに関するコントローラー
 */
class User extends Controller 
{
    public function loginAction()
    {
        return $this->view()->render('usr_login');
    }

    public function logoutAction()
    {
        unset($_SESSION);
        session_destroy();
        return $this->view()->render('usr_login');
    }

    public function createAction()
    {
        $data = ['uid'=>'', 'uname'=>'', 'urole'=>1, 'act'=>'insert'];
        return $this->view()->render('usr_input', $data);
    }

    public function updateAction($uid)
    {
        $data = $this->model()->getDetail("uid='{$uid}'");
        unset($data['upass']);
        return $this->view()->render('usr_input', $data);
    }

    public function deleteAction($uid)
    {
        $this->model()->delete("uid='{$uid}'");
        return $this->view()->redirect("/u/list");
    }
   
    public function saveAction($on_success=null)
    {
        $data = $_POST;
        $act = $data['act'] ?? 'insert';
        unset($data['act']);
        if ($data['upass'] == $data['upass2']){
            unset($data['upass2']);
            if ($act==='insert'){
                $this->model()->insert($data);
            }else{
                $uid = $data['uid']; 
                unset($data['uid']);
                $this->model()->update($data, "uid='{$uid}'");
            }
            return $this->view()->redirect("/u/list");
        }else{
            return $this->view()->render("sys_error", ['msg'=>self::ERROR['901']]);
        }

    }

    public function listAction()
    {
        $users = $this->model()->getList(orderby:"urole,uid");
        return $this->view()->render("usr_list", ['users'=>$users]);
    }

    public function detailAction($uid)
    {
        $user = $this->model()->getDetail("uid='{$uid}'");
        if ($user){
            unset($user['upass']);
            return $this->view()->render("usr_detail", ['user'=>$user]);
        }else{
            return $this->view()->render("sys_error", ['msg'=>self::ERROR['301']]);
        }
    }

    public function authAction()
    {
        $uid = htmlspecialchars($_POST['uid']);
        $upass = htmlspecialchars($_POST['upass']);
        $user = $this->model()->auth($uid, $upass);
        
        if ($user){
            foreach(['uid', 'uname', 'urole'] as $key){
                $_SESSION[$key] = $user[$key];
            } 
            return $this->view()->redirect($on_success??'/u/list');
        }else{
            return $this->view()->render('usr_login'); 
        }
    }
}
