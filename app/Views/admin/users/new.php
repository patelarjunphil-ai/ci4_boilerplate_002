<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h1>Add New User</h1>

    <?php if (session()->get('errors')): ?>
        <ul>
            <?php foreach (session()->get('errors') as $error): ?>
                <li style="color:red;"><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="/admin/users/create" method="post">
        <?= csrf_field() ?>

        <label for="username">Username</label>
        <input type="text" name="username" value="<?= old('username') ?>" required>

        <br>

        <label for="email">Email</label>
        <input type="email" name="email" value="<?= old('email') ?>" required>

        <br>

        <label for="active">Active</label>
        <select name="active">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>

        <br>

        <button type="submit">Create User</button>
    </form>
<?= $this->endSection() ?>
