<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <?php if (session('error')) : ?>
        <p style="color:red;"><?= session('error') ?></p>
    <?php endif ?>

    <form action="<?= url_to('login') ?>" method="post">
        <?= csrf_field() ?>

        <label for="email">Email</label>
        <input type="email" name="email" value="<?= old('email') ?>" required>

        <br>

        <label for="password">Password</label>
        <input type="password" name="password" required>

        <br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
