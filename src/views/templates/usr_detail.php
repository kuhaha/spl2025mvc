<h3 class="text-info">アカウント詳細</h3>
<table class="table table-hover">
<?php
$fields = ['uid'=>'ユーザID', 'uname'=>'ユーザ名', 'urole'=>'種別'];
foreach ($user as $key=>$value) {
    printf("<tr><td><b>%s:</b></td><td>%s</td></tr>" . PHP_EOL, $fields[$key], $value);
}
?>
</table>