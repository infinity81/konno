<?php
$name = $_POST["name"];//名前、コメント、日にち、パスワード、編集、削除の関連の定義
$msg = $_POST["msg"];
$today = date('Y/m/d H:i:s');
$delete = $_POST["delete"];
$pwd = $_POST["pwd"];
$d_pwd = $_POST["d_pwd"];
$edit = $_POST["edit"];
$e_pwd = $_POST["e_pwd"];
?>

<?php
$dsn = 'mysql:dbname=data;host=localhost';
$user = 'root';
$password = 'root';
$pdo = new PDO($dsn, $user, $password);

$sql = "CREATE TABLE mission_4"//DBに制作される名前
."("
."id INT,"
."name VARCHAR(32),"
."msg TEXT,"
."date TEXT,"
."pwd VARCHAR(32)"
.");";
$stmt = $pdo -> query($sql);


if(!empty($edit))//編集　
{
    if(!empty($e_pwd) && $e_pwd == $e_pwd)
    {
        $sql = 'select * from mission_4 order by id';  //入力したデータをSELECTによって表示する。
        $result = $pdo -> query($sql);
        foreach($result as $row)
        {
             if($row['id'] == $edit)
             {
                 $edit_name = $row['name'];
                 $edit_msg = $row['msg'];
             }
        }
    }
}
?>

<!--ここからHTML-->
<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">

    <style></style>

    <script></script>

    <title>mission4</title>
</head>

<body>
  <!--入力フォーム-->
    <form method= "POST" action="mission_4.php">
        <label>名前：</label>
        <input type="text" name= "name" placeholder="名前" value="<?php echo $edit_name;?>">
        <br>
        <label>コメント：</label>
        <input type="text" name= "msg" placeholder="コメント"value="<?php echo $edit_msg;?>"><br>
        <label>パスワード：</label>
        <input type="text" name= "pwd" placeholder="パスワード"><br>
        <input type="submit" value="送信"><br>
        <input type="hidden" name="edit_execute" value="<?php echo $edit_num;?>"><br>
        編集・削除は<a href="misson4.php">こちら</a></br>

        <input type="text" name= "delete" placeholder="削除対象番号"><br>
        <input tupe = "text" name = "d_pwd" placeholder = "パスワード" value = "">
        <input type="submit" value="削除"><br>
        <input type="text" name= "edit" placeholder="編集対象番号"><br>
        <input tupe = "text" name = "e_pwd" placeholder = "パスワード" value = "">
        <input type="submit" value="編集"><br>

</body>
</html>

<?php



if((!empty($name)) && (!empty($msg)))//入力フォームに入力されていた場合
{
  if(!empty($pwd) && $pwd == $pwd)
  {
      if(empty($_POST['edit_execute']))
      {
          $sql = 'select * from mission_4 order by id';
          $result = $pdo -> query($sql);
          $num = 0;
          $id = 0;
          foreach($result as $row)//配列で表示
          {
              $num = $row['id'];
          }
          $id = $num +1;
          $sql = $pdo -> prepare("INSERT INTO mission_4 (id, name, msg, date, pwd) VALUES (:id, :name, :msg, :date, :pwd)");
          $sql -> bindValue(':id', $id, PDO::PARAM_INT);
          $sql -> bindParam(':name', $name, PDO::PARAM_STR);
          $sql -> bindParam(':msg', $msg, PDO::PARAM_STR);
          $sql -> bindParam(':date', $today, PDO::PARAM_STR);
          $sql -> bindParam(':pwd', $pwd, PDO::PARAM_STR);
          $name = $_POST["name"];
          $msg = $_POST["msg"];
          $today = date('Y/m/d H:i:s');
          $pwd = $_POST["pwd"];

          $sql -> execute();
      }
  }
}

if(!empty($delete))//削除のパスワードが一致した場合
{
    if(!empty($d_pwd) && $d_pwd == $d_pwd)
    {
		    $id = $delete;
        $sql = "DELETE from mission_4 where id = $id";
		    $result = $pdo -> query($sql);
    }
}


if(!empty($edit))//編集のパスワードが一致した場合
{
    if(!empty($e_pwd) && $e_pwd == $e_pwd)
    {
        $sql = 'select * from mission_4 order by id';
        $result = $pdo -> query($sql);
        foreach($result as $row)
        {
            if($row['id'] == $id && $row['pwd'] == $e_pwd)
            {
                $sql = "UPDATE mission_4 set name='$name', msg='$msg', date='$today' where id=$id ";
                $result = $pdo -> query($sql);
            }
        }
   }
}

$sql = 'select * from mission_4 order by id';  //表示
$result = $pdo -> query($sql);
$i = 1;
foreach($result as $row)
{
    print $row['id'].' '. $row['name'].' '. $row['msg'].' ' .  $row['date'].'<br>';

}
?>
