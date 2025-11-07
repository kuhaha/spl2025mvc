<!doctype html>
<html lang="ja" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$_app_name_?> Ver.<?=$_app_version_?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom border-bottom-dark">
  <div class="container-fluid ">
    <a class="navbar-brand" href="<?=$_url_base_?>/u/list"><?=$_app_name_?> Ver.<?=$_app_version_?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <?=$_SESSION['uname'] ?? 'ゲスト'?>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="<?=$_url_base_?>/u/list">HOME</a>       
        <?php
        if (isset($_SESSION['urole'])){
          printf('<a class="nav-link" href="%s/u/list">LIST</a>'.PHP_EOL, $_url_base_);
          printf('<a class="nav-link" href="%s/u/logout">LOGOUT</a>'.PHP_EOL, $_url_base_);
        }else{
          printf('<a class="nav-link" href="%s/u/login">LOGIN</a>'.PHP_EOL, $_url_base_);
        }
        ?>
      </div>
    </div>
  </div>
</nav>

<div class="container">