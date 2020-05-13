<?php
use Helpers\Html;
?>

<title><?= $title ?></title>

<?= Html::script('chart.min.js') ?>

<div class="container mt-4">
    <h1 class="text-center">Найпопулярніші ігри по кількості переглядів</h1>
    <hr class="my-4">
    <canvas id="myChart"></canvas>
</div>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?= $data['labels'] ?>,
            datasets: [{
                label: 'Кількість переглядів',
                data: <?= $data['values'] ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {

        }
    });
</script>