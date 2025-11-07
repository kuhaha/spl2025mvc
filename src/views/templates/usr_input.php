<h3 class="text-info">アカウント登録・編集</h3>
<?php 
$act = $act ?? 'update';
?>

<form action="<?=$_url_base_?>/u/save" method="post">
<input type="hidden" name="act" value="<?=$act?>">
<div class="form-group">
<label>ユーザID　</label>

<?php
$type = $act=='insert' ? 'text' : 'hidden'; 
printf('<input type="%s" name="uid" value="%s" class="form-control">', $type, $uid);
echo $act=='insert' ? '' : $uid;
?>
<div class="form-group">
<label for="uname">氏　　　名</label> 
<input type="text" id="uname" name="uname" value="<?=$uname?>" class="form-control">
</div>
<div class="form-group">
<label for="upass">パスワード</label>
<input type="password" id="upass" name="upass" class="form-control">
</div>
<div class="form-group">
<label for="upass2">（再入力）</label>
<input type="password" id="upass2" name="upass2" class="form-control">
</div>
<div class="form-group">
<label>ユーザ種別</label>
<?php
  $codes = array(1=>'学生', 2=>'教員', 9=>'管理者');
  foreach ($codes as $key => $value){
    $checked = ($key == $urole) ? 'checked' : '';
    //echo '<div class="form-check form-check-inline">', PHP_EOL;
    printf('<input class="form-check-input" type="radio" name="urole" value="%s" %s/>',$type, $checked);
    echo '<label class="form-check-label">'. $value . '</label>', PHP_EOL;
    //echo '</div>', PHP_EOL;
  }
?>  
</div>
<div class="my-2">
<input type="submit" value="登録" class="btn btn-primary">
<input type="reset" value="取消" class="btn btn-danger">
</div>
</form>