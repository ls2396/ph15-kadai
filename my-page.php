<?php

require_once __DIR__ .'/functions/user.php';

session_start();

if (!isset($_SESSION['id']) && !isset($_COOKIE['id'])) {
    header('Location: ./login.php');
    exit();
}

$id = $_SESSION['id'] ?? $_COOKIE['id'];

$name = $_POST['name'] ?? '名無しさん';

$user = getUser($id);

if (is_null($user)) {
    header('Location: ./login.php');
    exit();
}

?>
<html>
    <body>
        <h1>マイページ</h1>
        <table>
            <tr>
                <td>ID</td>
                <td>
                    <?php echo $user['id'] ?>
                </td>
            </tr>
            <tr>
                <td>名前</td>
                <td>
                    <?php echo $user['name'] ?>
                </td>
            </tr>
            <tr>
                <td>生年月日</td>
                <td>
                    <?php echo $user['birth'] ?>
                </td>
            </tr>
            <tr>
                <td>メールアドレス</td>
                <td>
                    <?php echo $user['email'] ?>
                </td>
            </tr>
            <tr>
                <td>電話番号</td>
                <td>
                    <?php echo $user['tel'] ?>
                </td>
            </tr>
            <tr>
                <td>住所</td>
                <td>
                    <?php echo $user['address'] ?>
                </td>
            </tr>
        </table>
        <div>
            <a href="./logout.php">
                ログアウト
            </a>
        </div>
    </body>
</html>


