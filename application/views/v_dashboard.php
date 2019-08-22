<style>
.div1 {
    float: left;
    width: 10px;
    height: 10px;
    margin: 10px;

}

.div2 {
float: left;
}

</style>

<body>


  <div id="content-wrapper">

  
        <div class="container-fluid">

          <!-- Breadcrumbs
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Charts</li>
          </ol>
-->
          <!-- Area Chart Example-->


          <div class="row justify-content-md-center">
            <div class="col-lg-10">
              <div class="card mb-3">
              <!--  <div class="card-header">
                  <i class="fas fa-chart-bar"></i>    Bar Chart Biaya Proyek</div> -->
                  <div class="card-header">
                <div class="div1" style="background: #007bff;"></div>
                  <div class="div2">Time Spend(%)</div>
                  <div class="div1" style="background: #dc3545;"></div>
                    <div class="div2">Payment(%)</div>
                  <div class="div1" style="background: #28a745;"></div>
                  <div class="div2">Total Expense(%)</div>
                  <div class="div1" style="background: #ffc107;"></div>
                  <div class="div2">Expense(%)</div>
                  <div class="div1" style="background: #6c757d;"></div>
                  <div class="div2">ManHour(%)</div>


                </div>
                <div class="card-body">
                  <canvas id="chBar" width="100%" height="50"></canvas>
                </div>

              </div>
            </div>

          </div>



        </div>
        <!-- /.container-fluid -->

      </div>
</body>
<!-- Page level plugin JavaScript-->
<script src="<?php echo base_url();?>assets/vendor/chart.js/Chart.min.js"></script>
<script type="text/javascript">
/* chart.js chart examples */

// chart colors['#007bff', '#dc3545', '#ffc107', '#28a745']
var colors = ['#007bff','#28a745','#ffc107','#c3e6cb','#dc3545','#6c757d'];

var chBar = document.getElementById("chBar");
$.ajax({
type: "POST",
dataType: "JSON",
url: "<?php echo site_url('admin/ajax_list')?>",
success: function(data){
  $("#rate").val(data.project)

                    var name = [];
                    var marks = [];
                    var hours = [];
                    for (var i in data) {
                    name.push(data[i]);

                    }
console.log(data.project);


var chartData = {
  labels: name[0],
  datasets: [{
    data: name[1],
    backgroundColor: colors[0]
  },
  {
    data: name[5],
    backgroundColor: colors[4]
  },
  {
    data: name[2],
    backgroundColor: colors[1]
  },
  {
    data:name[3],
    backgroundColor: colors[2]
  },
  {
    data: name[4],
    backgroundColor: colors[5]
  }],

};


        if (chBar) {
          new Chart(chBar, {
          type: 'bar',
          data: chartData,
          options: {
            scales: {
              xAxes: [{
                barPercentage: 0.9,
                categoryPercentage: 0.8
              }],
              yAxes: [{
                ticks: {

                  max: 100,
                  maxTicksLimit: 5,
                  beginAtZero: true
                }
              }]
            },
            legend: {
              display: false
            },
            title: {
                          display: true,
                          text: 'Project Expanse',
                          position: 'top'
                      },
                      tooltips: {
                          callbacks: {
                              label: function(tooltipItem) {
                                  return Number(tooltipItem.yLabel) + " % Spent !";
                              }
                          }
                      },
          }
          });
        }}
        })
</script>
