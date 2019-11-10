<?php

/* @var $this yii\web\View */
use dosamigos\chartjs\ChartJs;
use app\models\Inbox;
$this->title = '';
?>
                        <div class="pad"></div>
                        <div class="col-md-3">
                            
                            <!-- START WIDGET SLIDER -->
                            <div class="widget widget-default widget-carousel">
                                <div class="owl-carousel" id="owl-example">
                                    <div>                                    
                                        <div class="widget-title">Total Visitors</div>                                                                        
                                        <div class="widget-subtitle">27/08/2014 15:23</div>
                                        <div class="widget-int">3,548</div>
                                    </div>
                                    <div>                                    
                                        <div class="widget-title">Returned</div>
                                        <div class="widget-subtitle">Visitors</div>
                                        <div class="widget-int">1,695</div>
                                    </div>
                                    <div>                                    
                                        <div class="widget-title">New</div>
                                        <div class="widget-subtitle">Visitors</div>
                                        <div class="widget-int">1,977</div>
                                    </div>
                                </div>                            
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>                             
                            </div>         
                            <!-- END WIDGET SLIDER -->
                            
                        </div>
                        <div class="col-md-3">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-default widget-item-icon" onclick="location.href='pages-messages.html';">
                                <div class="widget-item-left">
                                    <span class="fa fa-envelope"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count">48</div>
                                    <div class="widget-title">New messages</div>
                                    <div class="widget-subtitle">In your mailbox</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
                            
                        </div>
                        <div class="col-md-3">
                            
                            <!-- START WIDGET REGISTRED -->
                            <div class="widget widget-default widget-item-icon" onclick="location.href='pages-address-book.html';">
                                <div class="widget-item-left">
                                    <span class="fa fa-user"></span>
                                </div>
                                <div class="widget-data">
                                    <div class="widget-int num-count">375</div>
                                    <div class="widget-title">Registred users</div>
                                    <div class="widget-subtitle">On your website</div>
                                </div>
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>                            
                            </div>                            
                            <!-- END WIDGET REGISTRED -->
                            
                        </div>
                        <div class="col-md-3">
                            
                            <!-- START WIDGET CLOCK -->
                            <div class="widget widget-danger widget-padding-sm">
                                <div class="widget-big-int plugin-clock">00:00</div>                            
                                <div class="widget-subtitle plugin-date">Loading...</div>
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="left" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>                            
                                <div class="widget-buttons widget-c3">
                                    <div class="col">
                                        <a href="#"><span class="fa fa-clock-o"></span></a>
                                    </div>
                                    <div class="col">
                                        <a href="#"><span class="fa fa-bell"></span></a>
                                    </div>
                                    <div class="col">
                                        <a href="#"><span class="fa fa-calendar"></span></a>
                                    </div>
                                </div>                            
                            </div>                        
                            <!-- END WIDGET CLOCK -->
                            
                        </div>
            
     <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success panel-hidden-controls">
                <div class="panel-heading ui-draggable-handle">
                    <h3 class="panel-title">ВАША СТАТИСТИКА</h3>
                    <ul class="panel-controls">
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span> Refresh</a></li>
                            </ul>                                        
                        </li>
                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                    </ul>                                
                </div>
                    <div class="panel-body">
                    
                    <div class="col-md-12">
   <!--  <?= ChartJs::widget([
                            'type' => 'line',
                            'id' => 'lines',
                            'options' => [
                                'class' => 'chartjs-render-monitor',
                                'height' => 80,
                                'width' => 300
                            ],
                            'data' => [
                                'labels' => $days,
                                'datasets' => [
                                    [
                                        'label' => "Количество",
                                        'backgroundColor' => "rgba(179,181,198,0.2)",
                                        'borderColor' => "rgba(179,181,198,1)",
                                        'pointBackgroundColor' => "rgba(179,181,198,1)",
                                        'pointBorderColor' => "#fff",
                                        'pointHoverBackgroundColor' => "#fff",
                                        'pointHoverBorderColor' => "rgba(179,181,198,1)",
                                        'data' => $values
                                    ],
                                
                                ]
                            ]
                        ]);
          ?>  -->

    <?= ChartJs::widget([
        'type' => 'line',
        'options' => [
            'height' => 80,
            'width' => 400
                                ],
        'data' => [
            'labels' => ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
            'datasets' => [
            [
                'label' => "Договоры",
                'backgroundColor' => "rgba(179,181,198,0.2)",
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => [65, 59, 90, 81, 56, 55, 40, 12, 25, 32, 30, 42]
                    ],
                                       
                ]
            ]
        ]);
        ?>
        <?= ChartJs::widget([
        'type' => 'pie',
         
    'id' => 'structurePie',
    'options' => [
        'height' => 80,
        'width' => 400,
        'pie'=>"(1, colors(64, 0, 0))",
         'pie'=>"(2, colors(128 ,0 ,0))",
    ],
        'data' => [
            'labels' => ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
            'datasets' => [
            [
                'label' => "Договоры",
                'backgroundColor' => "rgba(179,181,198,0.2)",
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => [65, 59, 90, 81, 56, 55, 40, 12, 25, 32, 30, 42],
                'backgroundColor'=> [
                            '#5cb95c',
                            '#65C4BB',
                            '#1BBC3B',
                            '#f0ad3e',
                            '#DA70D6',
                            '#bc3cbc',
                            '#73E1E1',
                            '#32B2B2',
                            '#FFDBC1',
                            '#65C28E',
                            '#D79F59',
                            '#FF0000'
                        ]
                    ],
                                       
                ]
            ]
        ]);
        ?>
 
<?= ChartJs::widget([
    'type' => 'line',
    'options' => [
        'height' => 80,
        'width' => 400
    ],
    'data' => [
        'labels' => ["January", "February", "March", "April", "May", "June", "July"],
        'datasets' => [
            [
                'label' => "My First dataset",
                'backgroundColor' => "rgba(179,181,198,0.2)",
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => [65, 59, 90, 81, 56, 55, 40],

            ],
            [
                'label' => "My Second dataset",
                'backgroundColor' => "rgba(255,99,132,0.2)",
                'borderColor' => "rgba(255,99,132,1)",
                'pointBackgroundColor' => "rgba(255,99,132,1)",
                'pointBorderColor' => "#CD8F49",
                'pointHoverBackgroundColor' => "#9905D8",
                'pointHoverBorderColor' => "rgba(255,99,132,1)",
                'data' => [28, 48, 40, 19, 96, 27, 100],
                
            ]
        ]
    ]
]);
?>
<?= ChartJs::widget([
    'type' => 'line',
    'options' => [
        'height' => 80,
        'width' => 400
    ],
    'data' => [
        'labels' => ["January", "February", "March", "April", "May", "June", "July"],
         'datasets' => [
             [
                 'label'=> '# of Votes',
                 'data' => [65, 59, 90, 81, 56, 55, 40],
                 'backgroundColor'=> [
                            '#FFEB5A',
                            '#CD8F49',
                            '#9905D8',
                            '#bc3cbc',
                            '#57E9E1',
                            '#A0AFFF',
                            '#5cb95c'
                        ]
             ],
             [
                 'label'=> '# of Votes',
                 'data' => [28, 48, 40, 19, 96, 27, 100],

             ]
         ]
    ]
]);?>



 <?= ChartJs::widget([
        'type' => 'line',
        'options' => [
            'height' => 80,
            'width' => 400
        ],
        'data' => [
            'labels' => ["00", "01:00", "02:00", "03:00", "04:00", "05:00", "06:00","07:00", "08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00","16:00", "17:00", "18:00", "19:00", "20:00", "21:00","22:00", "23:00"],
            'datasets' => [
                [
                    'pointBorderColor' => "#CD8F49",
                    'pointHoverBackgroundColor' => "#9905D8",
                    'fillColor' => "rgba(220,220,220,0.5)",
                    'strokeColor' => "rgba(220,220,220,1)",
                    'pointColor' => "rgba(220,220,220,1)",
                    'pointStrokeColor' => "#6464FF",
                    'data' => [1,2,3],
                    'backgroundColor'=> [
                            '#FF0000',
                            '#9932CC',
                            '#B2FA5C',
                        ]
                ],
                [
                    'fillColor' => "rgba(151,187,205,0.5)",
                    'strokeColor' => "rgba(151,187,205,1)",
                    'pointColor' => "rgba(151,187,205,1)",
                    'pointStrokeColor' => "#6464FF",
                    'data' => [1,2,3],
                ]
            ]
        ]
    ])?>
<?= ChartJs::widget([
    'type' => 'pie',
    'options' => [
        'height' => 80,
        'width' => 400,
    ],
    'data' => [
        'labels' => ["January", "February", "March", "April", "May", "June", "July"],
        'datasets' => [
            [
                'fillColor' => "rgba(220,220,220,0.5)",
                'strokeColor' => "rgba(220,220,220,2)",
                'pointColor' => "rgba(220,220,220,1)",
                'pointStrokeColor' => "#fff",
                'data' => [65, 59, 90, 81, 56, 55, 40],
                'backgroundColor'=> [
                            '#93DAFF',
                            '#A696CD',
                            '#3DFF92',
                            '#FFB6C1',
                            '#CD1039',
                            '#FFDC3C',
                            '#A0522D'
                        ]
            ],
            [
                'fillColor' => "rgba(151,187,205,0.5)",
                'strokeColor' => "rgba(151,187,205,1)",
                'pointColor' => "rgba(151,187,205,1)",
                'pointStrokeColor' => "#fff",
                'data' => [28, 48, 40, 19, 96, 27, 100],
                 'backgroundColor'=> [
                            '#5cb95c',
                            '#65C4BB',
                            '#1BBC3B',
                            '#f0ad3e',
                            '#DA70D6',
                            '#bc3cbc',
                            '#FF0000'
                        ]
            ]
        ]
    ]
]);
?>

<?= ChartJs::widget([
    'type' => 'line',
    'data' => [
        'labels' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
        'datasets' => [
            [
                'label' => 'level',
                'data' => [0, 1, 2, 3, 4, 6, 5, 12 , 17, 50, 100],
            ]
        ],
    ],
    'options' => [
        'height' => 80,
        'width' => 400,
    ],
    'clientOptions' => [
        'title' => [
            'display' => true,
            'text' => 'Chart from the absolute beginner: definitive edition (remastered)'            
        ],
        'scales' => [
                'yAxes' => [
                    [
                        'scaleLabel' => [
                            'display' => 'true',
                            'labelString' => 'level'
                        ]
                    ]
                ],
                'xAxes' => [
                    [
                        'scaleLabel' => [
                            'display' => 'true',
                            'labelString' => 'time spent'
                        ]
                    ]
                ]
        ],
    ]
]);?>
<?= ChartJs::widget([
    'type' => 'pie',
    'data' => [
        'labels' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
        'datasets' => [
            [
                'label' => 'level',
                'data' => [0, 1, 2, 3, 4, 6, 5, 12 , 17, 50, 100],
                 'backgroundColor'=> [
                            '#FFEB5A',
                            '#CD8F49',
                            '#9905D8',
                            '#bc3cbc',
                            '#57E9E1',
                            '#A0AFFF',
                            '#5cb95c',
                            '#47FF9C',
                            '#E6FFE6',
                            '#6464FF',
                            '#BCFF66',
                        ]
            ]
        ],
    ],
    'options' => [
        'height' => 80,
        'width' => 400,
    ],
    'clientOptions' => [
        'title' => [
            'display' => true,
            'text' => 'Chart from the absolute beginner: definitive edition (remastered)'            
        ],
        'scales' => [
                'yAxes' => [
                    [
                        'scaleLabel' => [
                            'display' => 'true',
                            'labelString' => 'level'
                        ]
                    ]
                ],
                'xAxes' => [
                    [
                        'scaleLabel' => [
                            'display' => 'true',
                            'labelString' => 'time spent'
                        ]
                    ]
                ]
        ],
    ]
]);?>
                    </div>
                </div>      
                <div class="panel-footer">
                </div>
            </div>
        </div>
    </div>