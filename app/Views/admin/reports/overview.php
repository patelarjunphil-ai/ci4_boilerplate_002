<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h1>User Overview</h1>

    <div style="width: 80%; margin: auto;">
        <canvas id="userChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('userChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Users'],
                datasets: [{
                    label: '# of Users',
                    data: [<?= $userCount ?>],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
<?= $this->endSection() ?>
