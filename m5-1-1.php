<!DOCTYPE html>
<html lang="ja">
    
<head>
    <meta charset="UTF-8">
    <title>mission_3-5</title>
</head>

<body>
<h1>[掲示板]</h1>

<?php
//[サンプル]
//・データベース名：データベース名
//・ユーザー名：ユーザー名
//・パスワード：パスワード
//・学生の場合：

// DB接続設定
//4-1
    $dsn='mysql:dbname=データベース名;host=localhost';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//テーブル作成
//4-2
    $sql2 = "CREATE TABLE IF NOT EXISTS m5tbtest"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name CHAR(32),"
    . "comment TEXT,"
    . "passkey TEXT"
    .");";
    $stmt2 = $pdo->query($sql2);


//テーブル一覧を表示
//4-3
    $sql3 = 'SHOW TABLES';
    $result3 = $pdo -> query($sql3);
    foreach($result3 as $row3)
    {
        echo $row3[0];
        echo '<br>';
    }
    echo "<hr>";
    
   

    if(!empty($_POST["name"]) && !empty($_POST["str"]) && !empty($_POST["password"]))
    {
        if(!empty($_POST["number"]))
        {
            //入力されているデータレコードの内容を編集
            //4-7

            $id = $_POST["number"]; //変更する投稿番号
            $name = $_POST["name"];//変更したい名前
            $comment = $_POST["str"]; //変更したいコメント
            $passkey = $_POST["password"];//変更したいコメントについているパスワード
            
            $sql7 = 'UPDATE m5tbtest SET name=:name,comment=:comment,passkey=:passkey WHERE id=:id AND passkey=:passkey';
            $stmt7 = $pdo->prepare($sql7);
            $stmt7->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt7->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt7->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt7->bindParam(':passkey', $passkey, PDO::PARAM_STR);
            $stmt7->execute();
        }
        else
        {
            //データ入力（レコード挿入）
            //4-5
            $name = $_POST["name"];
            $comment = $_POST["str"];
            $passkey = $_POST["password"];
    
            $sql5 = "INSERT INTO m5tbtest (name, comment, passkey) VALUES (:name, :comment, :passkey)";
            $stmt5 = $pdo->prepare($sql5);
            $stmt5->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt5->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt5->bindParam(':passkey', $passkey, PDO::PARAM_STR);
            $stmt5->execute();
        }
    }
        
    
  


    
    
    
    

//削除機能
//4-8
    if(!empty($_POST["delete"]) && !empty($_POST["del_pass"]))
    {
    $id8 = $_POST["delete"];
    $passkey8 = $_POST["del_pass"];
    
    $sql8 = 'delete from m5tbtest where id=:id8 AND passkey=:passkey8';
    $stmt8 = $pdo->prepare($sql8);
    $stmt8->bindParam(':id8',$id8, PDO::PARAM_INT);
    $stmt8->bindParam(':passkey8',$passkey8, PDO::PARAM_STR);
    $stmt8->execute();
    }
    
////////////////////////////////////////////////////////////////////////////////

       if(!empty($_POST["edit"]) && !empty($_POST["edit_pass"]))
    {
//入力したデータレコードを抽出
//4-6応用
    $sqle = 'SELECT * FROM m5tbtest';
    $stmte = $pdo->query($sqle);
    $resultse = $stmte->fetchAll();
    foreach($resultse as $rowe)
    {
//$rowの中にはテーブルのカラム名が入る
        $edit_num = $_POST["edit"];
        $edit_name = $rowe['name'];
        $edit_str = $rowe['comment'];
        $edit_pas = $rowe['passkey'];
    }
    }
    //編集番号を入れるとフォームにセットする機能
    
////////////////////////////////////////////////////////////////////////////////
?>


<form action="" method="POST">
        <label>　　　　[投稿]</label><br>
        <input type="text" name="name" placeholder="名前"
        value="<?php if(isset($edit_name)) {echo $edit_name;} ?>"><br>
        <!--名前を入れる欄-->
        <!--編集番号が入ると編集したい名前が入る-->
        
        
        <input type="text" name="str" placeholder="コメント"
        value="<?php if(isset($edit_str)) {echo $edit_str;}?>"><br>
        <!--コメントを入れる欄-->
        <!--編集番号が入ると編集したいコメントが入る-->
        

        <input type="password" name="password" placeholder="パスワード"
        value="<?php if(isset($edit_pas)) {echo $edit_pas;}?>">
        
        <!--パスワードを入れる欄-->
        
        
        
        <br>
        <input type="submit" name="submit">
        <!--送信ボタン-->
        <!--編集するものが入るとボタンが編集に変わる-->
        
        <input type="hidden" name="number" 
        value="<?php if(isset($edit_num)) {echo $edit_num;}?>"><br>
        <!--編集番号が入る-->
        
        <br>
        
        <label>　　　[投稿削除]</label><br>
        <input type="text" name="delete" placeholder="削除番号" ><br>
        <!--消したい番号-->
        

        <input type="password" name="del_pass" placeholder="パスワード">
        
        <br>
        <button type="submit" name="delete_submit">削除</button>
        <!--消したいもののパスワード-->
        
        <br><br>
        
        <label>　　　[投稿編集]</label><br>
        <input type="text" name="edit" placeholder="編集" ><br>
  
        <input type="password" name="edit_pass" placeholder="パスワード">
       <br>
        <button type="submit" name="edit_submit">編集</button>
        
        <!--編集したい番号を入れる-->
        
        <br><br>
        <label>[投稿内容]</label>
        
   
</form>
    
<?php
//入力したデータレコードを抽出し、表示する
//4-6
    $sql6 = 'SELECT * FROM m5tbtest';
    $stmt6 = $pdo->query($sql6);
    $results6 = $stmt6->fetchAll();
    foreach($results6 as $row6)
    {
//$rowの中にはテーブルのカラム名が入る
        echo $row6['id'].'/';
        echo $row6['name'].'/';
        echo $row6['comment'].'<br>';
        echo "<hr>";
    }
?>
</body>
</html>