<?php
    //データベース接続に必要なものを読み込む
    require_once 'login.php';
    //データベースへの接続を行う
    try {
        $link = new PDO("mysql:dbname={$db_database};host={$db_hostname}", $db_username, $db_password);
    } catch (PDOException $e) {
        exit('データベースに接続できませんでした。' . $e->getMessage());
    }
?>
<title>掲示板 (AB課題)</title>
<h2>掲示板 (AB課題)</h2>
<!--新規作成へのリンク--!>
<p><a href="/bbs/new.php">新規作成</a></p>
<h3>記事一覧</h3>
<?php
    //sql文を準備、実行及び結果取得
    $sql = 'select id, author, title, comment, created_at from posts order by created_at desc';
    $res = $link->query($sql);
    $data = $res->fetchAll();
?>

<?php
//投稿あるかどうかについての判定
if (!empty($data)) { ?>
<!--投稿を表示するための表の定義--!>
  <table style="border:solid 1px">
    <tr>
      <th>投稿日時</th>
      <th>タイトル</th>
      <th>投稿者</th>
      <th>コメント</th>
    </tr>
<!--取得したデータベースのデータを一レコードずつ出す--!>
    <?php foreach ($data as $key) { ?>
      <tr>
<!--一レコードの必要なフィルドーデータを取得--!>
        <td><?= $key['created_at'] ?></td>
        <td><?= $key['title'] ?></td>
        <td><?= $key['author'] ?></td>
        <td><?= $key['comment'] ?></td>
        <td><a href="edit.php?id=<?= $key['id'] ?>">編集する</a></td>
        <td><a href="delete.php?id=<?= $key['id'] ?>">削除する</a></td>
      </tr>
    <?php } ?>
  </table>
<?php
} else {
//テーブルの方にデータがない場合出す文字
  echo '記事がありません<br>';
}
?>
<!--データベースへのリンクを切断--!>
<?php $link->close(); ?>
