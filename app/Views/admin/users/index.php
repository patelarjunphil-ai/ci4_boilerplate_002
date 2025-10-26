<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h1>Users</h1>

    <a href="/admin/users/new">Add New User</a>

    <?php if (session()->get('message')): ?>
        <p style="color:green;"><?= session()->get('message') ?></p>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= esc($user->username) ?></td>
                    <td><?= esc($user->email) ?></td>
                    <td><?= $user->active ? 'Yes' : 'No' ?></td>
                    <td>
                        <a href="/admin/users/edit/<?= $user->id ?>">Edit</a>
                        <a href="/admin/users/delete/<?= $user->id ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?= $this->endSection() ?>
