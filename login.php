<?php

require_once __DIR__ . '/functions/user.php';

session_start();

$errorMessages = [];

$email = '';

if (isset($_POST['submit-button'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $isRememberMe = isset($_POST['remember-me']);

    if (empty($email)) {
        $errorMessages['email'] = 'メールアドレスを入力してください';
    }
    if (empty($password) || strlen($password) < 8) {
        $errorMessages['password'] = 'パスワードは8文字以上で入力してください';
    }

    if (empty($errorMessages)) {
        $user = login($email, $password);

        if (!is_null($user)) {
            $_SESSION['id'] = $user['id'];
    
            if ($isRememberMe) {
                setcookie('id', $user['id'], time() + 60 * 60, '/');
            }
            
            header('Location: ./my-page.php');
            exit();
        }
    
        $errorMessages['result'] = '一致するユーザーが見つかりませんでした';
    }
}
?>

<html>
    <body>
        <h1>ログイン</h1>
        <?php if (isset($errorMessages['result'])): ?>
            <p><?php echo $errorMessages['result'] ?></p>
        <?php endif ?>
        <form action="./login.php" method="post">
            <div>
                メールアドレス<br>
                <input type="email" name="email" value="<?php echo $email ?>">
                <?php if (isset($errorMessages['email'])): ?>
                    <p><?php echo $errorMessages['email'] ?></p>
                <?php endif ?>
            </div>
            <div>
                パスワード<br>
                <input type="password" name="password">
                <?php if (isset($errorMessages['password'])): ?>
                    <p><?php echo $errorMessages['password'] ?></p>
                <?php endif ?>
            </div>
            <div>
                <label>
                    <input type="checkbox" name="remember-me">
                    ログイン状態を保存する
                </label>
            </div>
            <div>
                <input type="submit" value="ログイン" name="submit-button">
            </div>
        </form>
    </body>
</html>