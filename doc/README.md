# 「PHPプログラミング勉強会」(応用編)--サンプルコード

### 1.  サンプルデータベース

`database.sql` (データベース名：`spl2025db`)

```sql
CREATE TABLE tbl_user(
    uid VARCHAR(16) PRIMARY KEY, 
    uname VARCHAR(32) NOT NULL,
    upass VARCHAR(32) NOT NULL,
    urole INT NOT NULL
);

INSERT INTO tbl_user
(uid,     uname,    upass, urole) VALUES
('admin', '管理者',  '5678', 9),
('staff', '教員',    '3456', 2),
('s0001', '斎藤 唯人','1234', 1),
('s0002', '谷口 志穂','1234', 1),
('s0003', '吉村 琉翔','1234', 1);
```

### 2. システム全体のレイアウト

```
├── spl2025mvc
│   ├── conf # 設定ファイルのフォルダ
│       ├──conf_app.inc.php
│       ├──develop_env.inc.php
│       └──product_env.inc.php
│   ├── doc
│       ├──README.md # サンプルコード解説
│   ├── css
│       ├──style.css
│   ├── src # ソースコードのフォルダ
│       ├── controllers
│           ├──Controller.php
│           ├──User.php
│       ├── models
│           ├──Model.php
│           ├──User.php
│       ├── views
│           ├──View.php
│           └──templates
│              ├──pg_footer.php
│              ├──pg_header.php
│              ├──sys_error.php
│              ├──usr_detail.php
│              ├──usr_input.php
│              ├──usr_list.php
│              └──usr_login.php
│       └──Router.php
│   ├──vendor # composerコマンド実行時に自動生成される
│   ├──.gitignore # バージョン管理不要なファイルやフォルダを指定
│   ├──.htaccess # サーバ(Apache)関連の設定ファイル
│   ├──composer.json # パッケージ管理ツールcomposerの設定ファイル
│   ├──index.php # indexファイル（システムの入り口）
│   └──README.md # READMEファイル
```



### 3. 設定ファイル

**アプリケーションに関する設定ファイル（開発環境）**

**ファイル名**：`conf/cong_app.inc.php`

```php
<?php
return [
    'appName'=>'MVCアプリケーション2025',
    'appId' => 'spl2025mvc',
    'appVerion' => '1.00',
    'timezone' => 'Asia/Tokyo',
    
    'routing_table' => [    
        //method, regex pattern, [controller(c), action(a)], [parameters]  
        //正規表現 \w+: 文字列, \d+: 整数　(): パラメータpの要素を（複数ある場合は、左から順に）定義する
        ['GET', '/', ['c'=>'User', 'a'=>'list']],
        ['GET', '/[a-z]+/error/(\w+)', ['c'=>'User', 'a'=>'error'], ['msg'] ],
        ['GET', '/u/create', ['c'=>'User','a'=>'create'] ],
        ['GET', '/u/list', ['c'=>'User','a'=>'list'] ],
        ['GET', '/u/detail/(\w+)', ['c'=>'User','a'=>'detail'], ['uid'] ],
        ['GET', '/u/update/(\w+)', ['c'=>'User','a'=>'update'], ['uid'] ],
        ['GET', '/u/delete/(\w+)', ['c'=>'User','a'=>'delete'], ['uid'] ],
        ['GET', '/u/login', ['c'=>'User', 'a'=>'login'] ],
        ['GET', '/u/logout', ['c'=>'User', 'a'=>'logout'] ],
        ['POST', '/u/save', ['c'=>'User','a'=>'save'] ],
        ['POST', '/u/auth', ['c'=>'User','a'=>'auth'] ],
    ],
    
    'codes' => [
        'urole' => [1=>'学生', 2=>'教員', 9=>'管理者'],
        'sex' => [0=>'未指定', 1=>'男', 2=>'女', ],
        'apl_status'=> [1=>'申請中',2=>'承認済み',3=>'却下済み',9=>'取り下げ'],
        'ins_status'=> [1=>'貸出可',2=>'貸出中', 3=>'修理中',9=>'除却・廃棄済み'],
        'dept'=>['RS'=>'情報科学科', 'RM'=>'機械工学科', 'RE'=>'電気工学科', ],
    ],
];
```

**サーバに関する設定ファイル（開発環境）**

**ファイル名**：`conf/develop_env.inc.php`

```php
<?php
   // 開発環境の設定
    return [
        'db'=>['host'=>'mysql', 'user'=>'root','pass'=>'root','dbname'=>'spl2025db'],
    ];
```

**サーバに関する設定ファイル本番番環境）**

**ファイル名**：`conf/product_env.inc.php`

```php
<?php 
    // 本番環境の設定
    return [ 
        'db'=>['host'=>'', 'user'=>'','pass'=>'','dbname'=>'spl2025db'],
    ];
```



### 4. ルートフォルダのファイル

**ファイル名：** `composer.json`

```json
{
  "name": "php_study/spl2025mvc",
  "description":"Learning PHP Programming in Practice, An Advanced Course",
  "version": "1.0.0",
  "type": "project",
  "time":"2025-11-1",
  "require": {
    "php": ">=8.1"
  },
  "autoload": {
    "psr-4": {
        "spl2025\\": "src/"
    }
  }
}
```



### Composerで依存関係・autoloadの設定を反映させる

`Docker Desktop`の場合は、`php-apache`コンテナの右側に縦の「・・・」アイコンをクリックし、「`Open in terminal`」を選び、コンソールを開く。そのあと、以下のコマンド（`#`以降の命令を実行）を実行する

```sh
# ls
dashboard  favicon.ico  index.php  spl2025min  spl2025mvc
# cd spl2025mvc
# ls
README.md  composer.json  conf  css  doc  index.php  js  src
# composer install
No composer.lock file present. Updating dependencies to latest instead of installing from lock file. See https://getcomposer.org/install for more information.
Loading composer repositories with package information
Updating dependencies
Nothing to modify in lock file
Writing lock file
Installing dependencies from lock file (including require-dev)
Nothing to install, update or remove
Generating autoload files
# ls
README.md  composer.json  composer.lock  conf  index.php  src  vendor
```

 `composer install`の実行によって、`composer.lock`, `vendor`が新しく生成されたことを確認できる



**ファイル名：** `.htaccess`

```htaccess
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.+)$ index.php [QSA,L] 
```


### 5. スタイルシート(CSS)

**ファイル名：**`css/style.css`

```css
.wrapper {
    margin-right: auto; 
    margin-left:  auto; 
    max-width: 960px;  
    padding-right: 10px; 
    padding-left:  10px; 
}
a {
    color:rgb(255, 243, 255);
    text-decoration: none;
}
#navbar {
    display: flex;
    background-color: rgb(126, 121, 121);
    color: white;
    align-items: center;
    min-height: 30pt;
    padding-left: 10pt;
    padding-right: 10pt;
    border-radius: 5px; 
}
#flex_left {
    flex: auto;
    text-align: left;
}
#flex_right{
    text-align: right;
}
```



### 6. ルータクラス（`Router`）

**ファイル名：**`src/Router.php`

```php
<?php
namespace spl2025; 

/**
 * ルーター(Router)　
 */
class Router
{
    private $base = null; 
    private $rules = [];
    
    public function __construct($base, $rules)
    {
        $this->base = $base;
        $this->rules = ['GET'=>[],'POST'=>[]];
        foreach ($rules as $rule) {
            $method = strtoupper($rule[0]);
            $rule = ['pattern'=>$rule[1], 'def'=>$rule[2], 'params'=>$rule[3]??[]];
            array_push($this->rules[$method], $rule);
        }
    }
  
    public function match($method, $request)
    {
        $method = strtoupper($method);
        foreach ($this->rules[$method]??[] as $rule) {
            $params = [];
            $pattern = rtrim($this->base, '/') . $rule['pattern'];
            if (preg_match("#^{$pattern}$#", $request, $matches)) {
                foreach ($rule['params'] as $i=>$name){
                    $params[$name] = $matches[$i+1] ?? null;
                }
                return ['c'=>$rule['def']['c'],'a'=>$rule['def']['a'],'p'=>$params];
            }
        }
        return null;
    }
}
```



### 7. コントローラー関連クラス

**ファイル名：**`src/controllers/Controller.php`

```php
<?php
namespace spl2025\controllers; 

/**
 * コントローラー（Controller）のベースとなるクラス
 */
abstract class Controller 
{
    const ERROR=[
      '300' =>'無効なリクエスト',
      '301' => 'データが存在しません',
      '400' =>'ファイルやパスが存在しません',
      '901'=>'パスワードが一致しません',
      '902'=>'必須パラメータが与えられていません',
    ];

    protected $model;
    protected $view;

    public function __construct($model, $view)
    {
      $this->model = $model;
      $this->view = $view;
    }
    public function model()
    {
      return $this->model;
    }
    public function view()
    {
      return $this->view;
    }

    public function errorAction($msg)
    {
      $err_msg = self::ERROR[$msg] ?? '何かエラーが発生しました';
      return $this->view()->render('sys_error', ['msg'=>$err_msg]);
    }
} 
```

**ファイル名：**`src/controllers/User.php`

```php
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
   
    public function saveAction()
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

    public function authAction($on_success=null)
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
```

### 8. モデル関連のクラス

**ファイル名：**`src/models/Model.php`

```php
<?php
namespace spl2025\models; 

/**
 * モデル（Model）のベースとなるクラス
 */

abstract class Model
{
    protected $table;
    protected $db;
    protected static $conf = [
        'host'=>'mysql', 'user'=>'root','pass'=>'root','dbname'=>'test'
    ];
    
    function __construct($conf = null){
        self::$conf = $conf?? self::$conf;
        $conn =  new \mysqli(
            self::$conf['host'], self::$conf['user'], self::$conf['pass'], self::$conf['dbname']
        );
        if ($conn->connect_errno) {
            die($conn->connect_error);
        }
        $conn->set_charset('utf8');
        $this->db = $conn;
    }
    
    public static function setDbConf($conf){
        self::$conf = $conf;
    } 
    
    public function query($sql, $orderby=null, $limit=0, $offset=0){
        $sql .= $orderby ? " ORDER BY {$orderby}" : '';
        $sql .= $limit > 0 ? " LIMIT {$limit} OFFSET {$offset}" : '';
        $rs = $this->db->query($sql);
        if (!$rs) die ('DBエラー: ' . $sql . '<br>' . $this->db->error);
        return $rs->fetch_all(MYSQLI_ASSOC);
    }

    public function execute($sql){
        $rs = $this->db->query($sql);
        if (!$rs) die ('DBエラー: ' . $sql . '<br>' . $this->db->error);
    } 
        
   public function getList($where=1, $orderby=null, $limit=0, $offset=0){
        $sql = "SELECT * FROM {$this->table} WHERE {$where}";
        return $this->query($sql,$orderby, $limit, $offset);
    }

    public function getDetail($where){
        $sql = "SELECT * FROM {$this->table} WHERE {$where}";
        $data = $this->query($sql);
        return $data[0]??[];
    }
    
    /**
     * insert(): insert an array of data as a row of the table
     * @params: $data, array [$column_name => $column_value]
     *    e.g.,  ['name'=>'foo', 'age'=>18, 'tel'=>'090-1234-5678'] 
     * @return, number of rows affected 
     */
    public function insert($data){
        $keys = implode(',', array_keys($data));
        $values = array_map(fn($v)=>is_string($v) ? "'{$v}'" : $v, array_values($data));
        $values = implode(",", $values);
        $sql = "INSERT INTO {$this->table} ($keys) VALUES ($values)";
        $this->execute($sql);
        return $this->db->affected_rows;
    }
    
    /**
     * update(): update the table using the given data
     * @params: $data, array [$column_name => $column_value]
     *    e.g.,  ['name'=>'foo', 'age'=>18, 'tel'=>'090-1234-5678']
     *  $where, string, condition to be used in WHERE clause 
     * @return, number of rows affected  
     */
    public function update($data, $where){
        $keys = array_keys($data);
        $values = array_map(fn($v)=>is_string($v) ? "'{$v}'" : $v, array_values($data));
        $values = array_map(fn($k, $v)=>"{$k}={$v}", array_combine($keys, $values));
        $sql = "UPDATE {$this->table} SET {$values} WHERE {$where}";
        $this->execute($sql);
        return $this->db->affected_rows;
    }
    
    /**
     * delete(): delete row(s) from the table using the given condition
     * @params: $where, string, condition to be used in WHERE clause
     * @return, number of rows affected 
     */
    public function delete($where){
        $sql = "DELETE FROM {$this->table} WHERE {$where}";
        $this->execute($sql);
        return $this->db->affected_rows;
    }
}
```

**ファイル名：**`src/models/User.php`

```php
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
```

### 9. ビュー関連のクラス

**ファイル名：**`src/Views/View.php`

```php
<?php
namespace spl2025\views; 

// ビュー(View)　
class View
{
    protected $shared = [];
    static $url_base = null;
    static $VIEW_DIR = "src/views/templates";

    public function __construct($url_base)
    {
        self::$url_base = rtrim($url_base, '/');
        $this->shared['_url_base_'] = self::$url_base;
    }
    
    static function setViewDir($dir)
    {
        self::$VIEW_DIR = rtrim($dir, '/');
    }

    public function share($name, $value)
    {
        $this->shared[$name] = $value;
    }
    
    /**
     * render(): テンプレート$tplを基に$paramsに含まれる変数が使って、画面を描画する。
     */
    public function render($tpl, $params=[])
    {
        ob_start(); //出力用バッファをオンにして出力をせず保存する
        extract($this->shared); # 複数画面共通の変数を用意する
        extract($params); # 一つの画面専用の変数を用意する
        include self::$VIEW_DIR . "/pg_header.php";
        include self::$VIEW_DIR . "/{$tpl}.php";
        include self::$VIEW_DIR . "/pg_footer.php"; 
        ob_end_flush(); //出力用バッファをフラッシュ(送信)する
    }

    /**
     * redirect($url): $urlへ画面遷移する
     * $urlはRouterパターンの書き方に従うURL。例: '/u/auth', `/u/detail/s0001`
     */ 
    public function redirect($url)
    {
        $real_url = self::$url_base . $url;
        header("Location:{$real_url}");
    }
}
```



**ファイル名：**`src/Views/templates/pg_header.php`

```php
<!DOCTYPE html> 
<html><head>
<meta http-equiv="Content-TYPE" content="text/html; charset=UTF-8">
<link rel="stylesheet" TYPE="text/css" href="<?=$_url_base_?>/css/style.css">
<title><?=$_app_name_?> Ver.<?=$_app_version_?></title>
</head>
<body>
<div class="wrapper">
<div id="navbar">
<div id="flex_left"><?=$_app_name_?> Ver.<?=$_app_version_?></div>
<div id="flext_right">        
<?php
if (isset($_SESSION['urole'])){
    printf('<a href="%s/u/list">HOME</a>｜'.PHP_EOL, $_url_base_);
    printf('<a href="%s/u/logout">LOGOUT</a>'.PHP_EOL, $_url_base_);
}else{
    printf('<a href="%s/u/login">LOGIN</a>'.PHP_EOL, $_url_base_);
}
?>
</div>    
</div>
```



**ファイル名：**`src/Views/templates/pg_footer.php`

```php+HTML
</div>
</body>
</html>
```



**ファイル名：**`src/Views/templates/usr_login.php`

```php+HTML
<form action="<?=$_url_base_?>/u/auth" method="post">
<div class="form-group">
  <label for="text1">ユーザーID:</label>
  <input type="text" name="uid" id="text1" class="form-control">
</div>
<div class="form-group>
  <label for="passwd">パスワード:</label>
  <input type="password" name="upass" id="passwd" class="form-control">
</div>
<div>
<input type="submit" value="送信" class="btn btn-primary">
<input type="reset" value="取消" class="btn btn-warning">
</div>
</form>
```



**ファイル名：**`src/Views/templates/usr_list.php`

```php
<h3 class="text-info">アカウント一覧</h3>
<table class="table table-hover">
<?php
$fields = ['uid'=>'ユーザID', 'uname'=>'ユーザ名', 'urole'=>'種別'];
$th_fields = array_map(fn($item) =>"<th>{$item}</th>", array_values($fields));
echo "<tr>",implode('', $th_fields), "</tr>", PHP_EOL; 
foreach ($users as $user) {
    $td_fields = array_map(fn($field) =>'<td>'.$user[$field].'</td>', array_keys($fields));
    echo "<tr>", implode('', $td_fields), "</tr>", PHP_EOL;
}
?>
</table>
```

### 10. インファイル（`index.php`）

**ファイル名：** `index.php`

```php
<?php
require "vendor/autoload.php";//namespaceに応じてファイルを自動ロード(include)する

$app_conf = require("conf/conf_app.inc.php"); // アプリケーション関連の設定ファイル
$srv_conf = require("conf/develop_env.inc.php"); // サーバ設定：開発用(development)
// $srv_conf = require("conf/product_env.inc.php"); // サーバ設定：本番用(product)

session_start();
date_default_timezone_set($app_conf['timezone']??'Asia/Tokyo');
$rt_conf = $app_conf['routing_table'];
$db_conf = $srv_conf['db'];
$url_base = dirname($_SERVER['PHP_SELF']);//index.php所在のフォルダ
$request = $_SERVER['REQUEST_URI'];  // リスクエスのURI
$method = $_SERVER['REQUEST_METHOD'];// GET | POST

# 1. Router (namespace spl2025)
# #######################################
$bad_request = ['c'=>'User', 'a'=>'error',  'p'=>['msg'=>'bad_request'] ];
$router = new spl2025\Router($url_base, $rt_conf);
$match = $router->match($method, $request) ?? $bad_request;
$mvcClass = $match['c'];
$action = $match['a'] . 'Action';
$params = $match['p'];

# 2. Model (namespace spl2025\models)
# #######################################
$modelClass = "spl2025\\models\\{$mvcClass}";
$model = new $modelClass($db_conf);

# 3. View (namespace spl2025\views)
# #######################################
$viewClass = "spl2025\\views\\View"; 
$template_dir = 'src/views/templates';
$viewClass::setViewDir($template_dir);
$view = new $viewClass($url_base);
$view->share('_app_name_', $app_conf['appName']??'SPL2025'); 
$view->share('_app_version_', $app_conf['appVersion']??'1.00'); 

# 4. Coutroller (namespace spl2025\controllers)
# #######################################
$ctrlClass = "spl2025\\controllers\\{$mvcClass}";
$controller = new $ctrlClass($model, $view);

# 5. Call the action of controller with parameters
# #######################################
call_user_func_array([$controller, $action], $params);
```
