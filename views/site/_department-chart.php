<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">
            Número de colaboradores por departamento
        </h3>
    </div>
    <div class="box-body">
        <?=\dosamigos\highcharts\HighCharts::widget([
                'clientOptions' => [
                    'chart' => [
                        'type' => 'bar'
                    ],
                    'title' => [
                         'text' => ''
                     ],
                    'xAxis' => [
                        'categories' => [
                            'Departamentos'
                        ]
                    ],
                    'yAxis' => [
                        'title' => [
                            'Funcionários'
                        ]
                    ],
                    'series' => $departmentChart
                ]
            ]);
        ?>
    </div>
</div>