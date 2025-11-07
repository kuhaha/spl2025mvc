<!DOCTYPE html> 
<html><head>
<meta http-equiv="Content-TYPE" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="<?=$_url_base_?>/css/style.css">
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
