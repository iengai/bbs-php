<?php
    //データベース接続
    require_once 'login.php';
    
    try {
        $link = new PDO("mysql:dbname={$db_database};host={$db_hostname}", $db_username, $db_password);
    } catch (PDOException $e) {
        exit('データベースに接続できませんでした。' . $e->getMessage());
    }
//元の記事を取得
    $id = $_GET['id'];
    $sql = "select author, title, comment from posts where id ={$id}";
    $originPost = $link->query($sql)->fetch();

    
    if ($_POST['action'] === 'delete') {
    echo 'delete';
    //削除sql文を用意
        $delSql = "delete from posts where id ={$id}";
        $res = $link->query($delSql);
        header('Location:/bbs/index.php');
        exit();
    } elseif ($_POST['action'] === 'cancel') {
        header('Location:/bbs/index.php');
        exit();
    }


?>



<h2>記事削除画面</h2>
<p>タイトル:<?= $originPost['title']; ?></p>
<p>投稿者:<?= $originPost['author']; ?></p>
<p>コメント:<?= $originPost['comment']; ?></p>
<br>
<form method="post">
<!--確認フォーム付きボタン--!>
  <button type="submit" name="action" value="delete" onclick="return confirm('本当に削除しますか？');" >削除する</button>
  <button type="submit" name="action" value="cancel">キャンセル</button>
</form>
<?php
    $link->close();
?>
