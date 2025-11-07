<h3 class="text-info">アカウント一覧</h3>
<table class="table table-hover">
<?php
$fields = ['uid'=>'ユーザID', 'uname'=>'ユーザ名', 'urole'=>'種別'];
$tag_fields = array_map(fn($item) =>"<th>{$item}</th>", array_values($fields));
echo "<tr>", implode('', $tag_fields), "</tr>", PHP_EOL; 
foreach ($users as $user) {
    $tag_fields = array_map(fn($field) =>'<td>'.$user[$field].'</td>', array_keys($fields));
    echo "<tr>", implode('', $tag_fields), "</tr>", PHP_EOL;
}
?>
</table>