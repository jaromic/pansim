<?php

require_once "vendor/autoload.php";

use Jarosoft\Person;
use Jarosoft\SimplePopulationGenerator;
use Jarosoft\SimpleStepAlgorithm;
use Jarosoft\Simulation;
use Jarosoft\TickCounter;

$populationGenerator = new SimplePopulationGenerator();
$stepAlgorithm = new SimpleStepAlgorithm();
$simulation = new Simulation($populationGenerator, $stepAlgorithm, 100, 1);

$stepCount = 100;
$simulation->run($stepCount);
$statistics = $simulation->getStatistics();
$states = [
    Person::STATE_SUSCEPTIBLE => 'Susceptible',
    Person::STATE_INFECTED => 'Infected',
    Person::STATE_IMMUNE => 'Immune',
    Person::STATE_DECEASED => 'Deceased',
];
$colors = [
    Person::STATE_SUSCEPTIBLE => 'blue',
    Person::STATE_INFECTED => 'yellow',
    Person::STATE_IMMUNE => 'green',
    Person::STATE_DECEASED => 'red',
];

?>
<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.bundle.min.js"></script>
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
</head>
<body>
<canvas id="diagram"></canvas>
<script>
    $(document).ready(function () {
        var data = {
            labels: [
                <?php for ($i = 0; $i < $stepCount; ++$i) {
                echo $i . ", ";
            } ?>
            ],
            datasets: [
                <?php foreach($states as $state => $stateName) { ?>
                {
                    yAxisId: 'value',
                    label: '<?php echo $stateName ?>',
                    lineTension: 0,
                    radius: 1,
                    backgroundColor: '  <?php echo $colors[$state]; ?>',
                    data: [
                        <?php
                        for ($i = 1; $i < $stepCount; ++$i) {
                            echo $statistics[$state][$i] . ",";
                        }
                        ?>
                    ]
                },
                <?php  }?>
            ],
        };
        var ctx = $('#diagram')[0].getContext('2d');
        var myChart = new Chart(ctx, {
                type: 'line',
                labels: ['Susceptible', 'Infected', 'Immune', 'Deceased'],
                data: data,
                options: {
                    scales: {
                        // xAxes: [
                        //     {
                        //         id: 'days',
                        //         type: 'linear',
                        //         scaleLabel: 'days',
                        //     }
                        // ],
                        yAxes: [{
                            id: 'value',
                            stacked: true,
                        }]
                        ,
                    }
                }
            })
        ;
    });
</script>
</body>
</html>
