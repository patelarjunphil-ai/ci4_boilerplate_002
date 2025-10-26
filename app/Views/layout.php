<!DOCTYPE html>
<html>
<head>
    <title>My App</title>
</head>
<body>

    <header>
        <?= view_cell('App\Cells\NavbarCell') ?>
    </header>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

</body>
</html>
