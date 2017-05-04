<?php
    //データベース接続
    require_once 'login.php';
    
    try {
        $link = new PDO("mysql:dbname={$db_database};host={$db_hostname}", $db_username, $db_password);
    } catch (PDOException $e) {
        exit('データベースに接続できませんでした。' . $e->getMessage());
    }
//フォームで提出されたデータについての判定
    if ($_POST['action'] === 'save') {
        $author = $_POST['author'];
        $title = $_POST['title'];
        $comment = $_POST['comment'];
        //入力項目についての判定
        if (!empty($author) && !empty($title) && !empty($comment)) {
            //sql文の用意、結果取得
            $insertSql = "INSERT INTO posts (author, title, comment) VALUES ('{$author}', '{$title}', '{$comment}')";
            $result = $link->query($insertSql);
            //redirect
            header('Location:/bbs/index.php');
            exit();
        } else {
            //入力項目に空がある場合表示するメッセージ
            echo '未入力項目があります!';
        }
        //キャンセルの場合のリディレクトリ
    } elseif ($_POST['action'] === 'cancel') {
        header('Location:/bbs/index.php');
        exit();
    }
?>
<!--新規投稿作成フォーム--!>
<h2>記事新規作成画面</h2>
<form method="post">
  名前:<br>
  <input type="text" name="author" /><br>
  タイトル:<br>
  <input type="text" name="title" /><br>
  コメント:<br>
  <textarea name="comment" rows="10" cols="40"></textarea><br>
<!--のちの提出分岐になるキーワードを設定--!>
  <button type="submit" name="action" value="save">保存</button>
  <button type="submit" name="action" value="cancel">キャンセル</button>
</form>
<?php
//リンクを切る
$link->close();
?>
