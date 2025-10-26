<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h1>Edit User</h1>

    <?php if (session()->get('errors')): ?>
        <ul>
            <?php foreach (session()->get('errors') as $error): ?>
                <li style="color:red;"><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="/admin/users/update/<?= $user->id ?>" method="post">
        <?= csrf_field() ?>

        <label for="username">Username</label>
        <input type="text" name="username" value="<?= old('username', $user->username) ?>" required>

        <br>

        <label for="email">Email</label>
        <input type="email" name="email" value="<?= old('email', $user->email) ?>" required>

        <br>

        <label for="active">Active</label>
        <select name="active">
            <option value="1" <?= old('active', $user->active) ? 'selected' : '' ?>>Yes</option>
            <option value="0" <?= !old('active', $user->active) ? 'selected' : '' ?>>No</option>
        </select>

        <br>

        <button type="submit">Update User</button>
    </form>
<?= $this->endSection() ?>
