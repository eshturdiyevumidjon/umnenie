<?php
use yii\helpers\Url;
use johnitvn\ajaxcrud\CrudAsset;  
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use app\models\Users;
use yii\helpers\Html;
use dosamigos\chartjs\ChartJs;
$this->title = 'Administrator oynasi';
CrudAsset::register($this);

?>  
<div class="row" style="margin-top:30px">
    <div class="col-md-12">
        <div class="panel panel-warning">
            <div class="panel-heading ui-draggable-handle">
                <h3 class="panel-title">Возраст</h3>
                <div class="pull-right">
                    <?= Html::a('Назад&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-forward"></i>', ['polls/view','id'=>$model->id],['title'=> 'Назад', 'class'=>'btn btn-warning'])?>                           
                </div>  
            </div>
            <div class="row" >
                <div class="col-md-6">
                    <div class="row" >
                        <div class="col-md-8">
                            <div class="block">
                                <h4></h4>
                                <div class="list-group list-group-simple">                                
                                    <a  class="list-group-item"><span class="fa fa-circle text-success"></span> 25-34 года<span class="pull-right">39,2 %</span></a>
                                    <a  class="list-group-item"><span class="fa fa-circle text-warning"></span> 25-34 года<span class="pull-right">39,2 %</span></a>
                                    <a  class="list-group-item"><span class="fa fa-circle text-danger"></span> 25-34 года<span class="pull-right">39,2 %</span></a>
                                    <a  class="list-group-item"><span class="fa fa-circle text-info"></span> 25-34 года<span class="pull-right">39,2 %</span></a>
                                    <a  class="list-group-item"><span class="fa fa-circle text-primary"></span> 25-34 года<span class="pull-right">39,2 %</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"><br>
                    <!-- <div class="block-content">                                    
                        <div id="diagramma">
                            <canvas id="myChart" width="500" height="300"></canvas>
                        </div>
                    </div><br> -->
                    <?= ChartJs::widget([
                        'type' => 'pie',
                        'options' => [
                            'height' => 250,
                            'width' => 400,
                        ],
                        'data' => [
                            // 'labels' => ["January", "February", "March", "April", "May", "June", "July"],
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
                                    // 'data' => [100],
                                     'backgroundColor'=> [
                                                '#ffffff'
                                            ]
                                ]
                            ]
                        ]
                    ]);
                    ?><br>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script>
var data = [
    {
        value: 20,
        color:"#95b75d",
        highlight: "#cfeba0",
        label: "Aktiv"
    },
    {
        value: 30,
        color: "#1caf9a",
        highlight: "#82d1c6",
        label: "Noaktiv"
    },
    {
        value: 30,
        color: "#E04B4A",
        highlight: "#db7e7e",
        label: "Noaktiv"
    },
    {
        value: 30,
        color: "#1caf9a",
        highlight: "#8fdbd0",
        label: "Noaktiv"
    },
    {
        value: 30,
        color: "#1b1e24",
        highlight: "#6f89be",
        label: "Noaktiv"
    },
];

var ctx = document.getElementById("myChart").getContext("2d");
new Chart(ctx).Pie(data);
//new Chart(ctx).Doughnut(data);
</script>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "options" => [
        "tabindex" => -1,
    ],
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>