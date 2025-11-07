<?php
require "vendor/autoload.php";//namespaceに応じてファイルを自動ロード(include)する

$app_conf = require("conf/conf_app.inc.php"); // アプリケーション関連の設定ファイル
$srv_conf = require("conf/develop_env.inc.php"); // サーバ設定：開発用(development)
// $srv_conf = require("conf/product_env.inc.php"); // サーバ設定：本番用(product)

$db_conf = $srv_conf['db'];
$rt_conf = $app_conf['routing_table'];

session_start();

$url_base = dirname($_SERVER['PHP_SELF']);//index.php所在のフォルダ
$request = $_SERVER['REQUEST_URI'];  // リスクエスのURI
$method = $_SERVER['REQUEST_METHOD'];// GET | POST

# 1. Router (namespace spl2025)
# #######################################
$bad_request = ['c'=>'User', 'a'=>'error',  'p'=>['msg'=>'300'] ];
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