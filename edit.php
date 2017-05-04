<?php
    //データベース接続
    require_once 'login.php';
    
    try {
        $link = new PDO("mysql:dbname={$db_database};host={$db_hostname}", $db_username, $db_password);
    } catch (PDOException $e) {
        exit('データベースに接続できませんでした。' . $e->getMessage());
    }
    //編集する記事のidをgetで取得
    $id = $_GET['id'];
    //元の記事内容を取得
    $sql = "select author, title, comment from posts where id ={$id}";
    $originPost = $link->query($sql)->fetch();
    
    if ($_POST['action'] === 'save') {
        //新しい値を与える
        $newAuthor = $_POST['author'];
        $newTitle = $_POST['title'];
        $newComment = $_POST['comment'];

        $upadateSql = "update posts set author = '{$newAuthor}', title = '{$newTitle}', comment = '{$newComment}' where id = {$id}";
        $res = $link->query($upadateSql);

        header('Location:/bbs/index.php');
        exit();
    } elseif ($_POST['action'] === 'cancel') {
        header('Location:/bbs/index.php');
        exit();
    }
?>

<h2>編集画面</h2>
<!--もともとの内容をデフォルトに表示--!>
<form method="post">
  名前:<br>
  <input type="text" name="author" value="<?= $originPost['author'] ?>"/><br>
  タイトル:<br>
  <input type="text" name="title" value="<?= $originPost['title'] ?>" /><br>
  コメント:<br>
  <textarea name="comment" rows="10" cols="40"><?= $originPost['comment'] ?></textarea><br>

  <button type="submit" name="action" value="save">保存</button>
  <button type="submit" name="action" value="cancel">キャンセル</button>
</form>
<?php
$link->close();
?>
