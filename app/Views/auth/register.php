<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>

    <?php if (session('errors')) : ?>
        <ul>
        <?php foreach (session('errors') as $error) : ?>
            <li style="color:red;"><?= $error ?></li>
        <?php endforeach ?>
        </ul>
    <?php endif ?>

    <form action="<?= url_to('register') ?>" method="post">
        <?= csrf_field() ?>

        <label for="username">Username</label>
        <input type="text" name="username" value="<?= old('username') ?>" required>

        <br>

        <label for="email">Email</label>
        <input type="email" name="email" value="<?= old('email') ?>" required>

        <br>

        <label for="password">Password</label>
        <input type="password" name="password" required>

        <br>

        <label for="password_confirm">Confirm Password</label>
        <input type="password" name="password_confirm" required>

        <br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
