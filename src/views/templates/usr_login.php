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