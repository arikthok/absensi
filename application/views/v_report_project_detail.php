<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Schedule</title>
    <script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap core CSS-->
    <link href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url();?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <style>
    @page {
  size: A4;
  margin: 0;
}
.card-header{
  padding: 0.25rem 1.25rem;
}
.card-body{
  padding: 0.25rem;
}
html, body {
   font-size: 0.9rem;
 }
@media print{@page {size: landscape};


}
</style>

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url();?>assets/css/sb-admin.css" rel="stylesheet">

  </head>
<body>
<?php foreach($project as $u){ ?>

	    <div class="container " >
	      <div class="card mt-3">
	        <div class="card-header"><h5>Project Report Sumary</h5></div>
	        <div class="card-body">

						<div class="row ">
							<div class="col">
	              <div class="row ">
	                <div class="col-md-5">
	                   <p>
                       Date<br>
                       Project No<br>
                       Project Name
                     </p>
	                </div>
	                <div class="col-md-5">
	                  <p>: <?php echo date('d-m-Y'); ?><br>
                    : <?php echo $u->project_code ?><br>
                    : <?php echo $u->project_name ?></p>
	                </div>
	              </div>
	            </div>

              <div class="col">
                <div class="row ">
                  <div class="col-md-5">
                     <p>
                       Client<br>
                       Location<br>
                       Project Type
                     </p>
                  </div>
                  <div class="col-md-5">
                    <p>: <?php echo $u->client_name ?><br>
                    : <?php echo $u->location ?><br>
                    : <?php echo $u->project_type?></p>
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="row ">
                  <div class="col-md-6">
                     <p>
                       Contract Value<br>
                       Time Frame<br>
                     </p>
                  </div>
                  <div class="col-md-5">
                    <p>: <?php echo number_format($u->value,0,".","."); ?><br>
                    : <?php
                    $project_start = new DateTime($u->project_start);
                    $project_end = new DateTime($u->project_end);
                    $sisawaktu = $project_start->diff($project_end)->format("%a");
                    echo $sisawaktu ?> days</p>
                  </div>
                </div>
              </div>
					</div>
          <?php } ?>


            <div class="card mt-3.no-gutter">
              <div class="card-header"><h6>Payment Term</h6></div>
              <div class="card-body">
                <div class="row ">
                  <div class="col-md-1">
                    <div class="row ">
                      <div class="col">
                         <p><br>
                           <?php $no=1;
                           foreach($payment as $u){
                            echo "Term".$no."<br>";
                            $no++; } ?>
                         </p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="row ">
                      <div class="col">
                         <p>
                           Date<br>
                           <?php foreach($payment as $u){
                            echo $u->date ?><br><?php } ?>
                         </p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="row ">
                      <div class="col">
                         <p>
                           Value<br>
                           <?php
                           $bantu_payment =0;
                           foreach($payment as $u){
                             $tambah = $u->payment_value + $bantu_payment;
                             $bantu_payment= $tambah;
                            echo number_format($u->payment_value,0,".",".");
                             ?><br><?php } ?>
                         </p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="row ">
                      <div class="col">
                         <p>
                           Total<br><b>
                           <?php
                           echo number_format($bantu_payment,0,".",".");
                         ?></b>
                          <br>
                         </p>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>

          <div class="card mt-3.no-gutter">
            <div class="card-header"><h6>Manhours expense</h6></div>
            <div class="card-body">
              <div class="row ">

                <div class="col-md-1">
                  <div class="row ">
                    <div class="col">
                      <p>Position<br>
                        <?php foreach($absent as $u){
                         echo $u->position; ?><br><?php } ?>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="row ">
                    <div class="col">
                       <p>
                         Name<br>
                         <?php foreach($absent as $u){
                          echo $u->full_name; ?><br><?php } ?>
                       </p>
                    </div>
                  </div>
                </div>

                <div class="col-md-1">
                  <div class="row ">
                    <div class="col">
                       <p>
                         Hours<br>
                         <?php
                         foreach($absent as $u){
                           echo number_format($u->total,0,".",".");
                           ?><br><?php }?>
                       </p>
                    </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="row ">
                    <div class="col">
                       <p>
                         Total Man/Hours<br>
                           <?php
                           $total=0;
                           $bantu=0;
                           foreach($absent as $u){
                             $mh = $u->total;
                             $rate= $u->rate;
                             $harga=$mh*$rate;
                             echo number_format($harga,0,".",".");
                             $total = $harga+$bantu;
                             $bantu =$harga;
                             ?><br><?php }
                             ?>
                        <br>
                       </p>
                    </div>
                  </div>
                </div>

                <div class="col">
                  <div class="row ">
                    <div class="col">
                       <p>
                        Total<br><b>
                          <?php

                             echo number_format($total,0,".",".");
                             ?></b>
                        <br>
                       </p>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>

        <div class="card mt-3.no-gutter">
          <div class="card-header"><h6>Project Expense</h6></div>
          <div class="card-body">
            <div class="row ">
              <div class="col">
                <div class="row ">
                  <div class="col-md-6">
                     <p>Type Expense<br>
                       <?php foreach($expense as $u){
                        echo $u->information_name ?><br><?php } ?>
                     </p>
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="row ">
                  <div class="col-md-5">
                     <p>
                       Value<br>
                       <?php
                       $bantu =0;
                       foreach($expense as $u){
                         $tambah = $u->total_expense + $bantu;
                         $bantu= $tambah;
                        echo number_format($u->total_expense,0,".",".");
                         ?><br><?php } ?>
                     </p>
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="row ">
                  <div class="col-md-3">
                     <p>
                       Total<br><b>
                       <?php
                       echo number_format($bantu,0,".",".");
                       $total_expense = $bantu + $total;
                       $grandtotal = $bantu_payment - $total_expense;
                     ?></b>
                      <br>
                     </p>
                  </div>
                </div>
              </div>
          </div>

        </div>
      </div>

</div>
<div class="">
  <div class="row ">
    <div class="col-md-8"><h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Grand Total<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($grandtotal,0,".",".");  ?></h5>
    </div>
    <div class="col-md-2">
      <p>Expense<br><b><?php
      echo number_format($total_expense,0,".","."); ?></b></p>
    </div>
    <div class="col-md-2">
      <p>Payment<br><b><?php echo number_format($bantu_payment,0,".","."); ?></b></p>
    </div>
  </div>
</div>

</div>
</div>






</body>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url();?>assets/js/sb-admin.min.js"></script>

  <footer>
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Copyright © ADL Information</span>
      </div>
    </div>
  </footer>

  </body>

  </html>


    <script >
      window.print();

    </script>
