<link href="<?php echo base_url('assets/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet">
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="<?php echo base_url().'assets/js/jquery-ui.js'?>" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url().'assets/css/jquery-ui.css'?>">
<body>
  <!--input -->
  <div class="container">
    <div class="col-md-4">
    <div class="card mt-3">

        <div class="card-header"><h4>Add Payment</h4></div>
        <div class="card-body">
          <div id="info"></div>


         <?php echo form_open('crud_payment/data', 'id="mydata" '); ?>

         <div class="form-group ">
          <div class="form-row ">
            <div class="col">
              <div class="form-row ">
                <div class="col-md-4">
                  <div >
                   <label class="control-label">Projet Name</label>
                  </div>
                </div>
                <div class="col-md-7">
                  <div >
                    <input type="text" tabindex="1" id="project_name" name="project_name" class="form-control" autocomplete="off" required="required" data-error="Please enter your full name.">
                      <input type="hidden"  id="project_name_code" name="project_name_code" class="form-control" autocomplete="off" required="required" data-error="Please enter your full name.">
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>

      <div class="form-group ">
       <div class="form-row ">
         <div class="col">
           <div class="form-row ">
             <div class="col-md-4">
               <div >
                <label for="firstName">Payment</label>
               </div>
             </div>
             <div class="col-md-7">
               <div >
                 <select required name="Payment" id="Payment" class="form-control">
                            <option value="" >Choice</option>
                            <option value="1">First Payment</option>
                            <option value="2">Second Payment</option>
                            <option value="3">Third Payment</option>
                            <option value="4">Fourth Payment</option>
                            <option value="4">Fifth Payment</option>
                            <option value="4">Sixth Payment</option>
                            <option value="4">Seventh Payment</option>
                            <option value="4">Eighth Payment</option>



                </select></div>
             </div>
           </div>
         </div>
     </div>
    </div>

      <div class="form-group ">
       <div class="form-row ">
         <div class="col">
           <div class="form-row ">
             <div class="col-md-4">
               <div >
                <label for="firstName">value</label>
               </div>
             </div>
             <div class="col-md-7">
               <div >
                 <input type="text" tabindex="2" id="value" name="value" autocomplete="off" class="form-control"  required="required">
               </div>
             </div>
           </div>
         </div>
     </div>
    </div>

    <div class="form-group ">
     <div class="form-row ">
       <div class="col">
         <div class="form-row ">
           <div class="col-md-4">
             <div >
              <label for="firstName">Date</label>
             </div>
           </div>
           <div class="col-md-7">
             <div ><div class="input-group">
               <input id="datepicker2"  autocomplete="off" name="date"  class="form-control" required="required" />
               <button type="button" class="btn btn-outline-secondary" disabled>
               <span class="far fa-calendar-alt"></span>
             </button>
              </div>
  <script>
  $( "#datepicker2" ).datepicker({dateFormat: 'yy-mm-dd'});


  </script>
             </div>
           </div>
         </div>
       </div>
   </div>
  </div>

    <div class="text-center">
    <input class="submit center-block btn btn-primary" tabindex="9" value="Add Payment" type="submit">
      </div>
          </form>
          </div>
        </div>
        </div>



  <!-- datatables -->

<div class="col-md-10">
<div class="card mt-3">
  <div class="card-header"><h4>List Payment</h4></div>
    <div class="card-body">
      <table id="table" class="table table-bordered table-striped">
        <thead>
            <tr>
              <th width="5px"></th>
                <th width="5px">No</th>

                <th>Project Name</th>
                <th>Project Value</th>
                <th>Paid</th>

            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    </div>
</div>
</div>
</div>





</body>

<script type="text/javascript" src="<?php echo base_url();?>assets/vendor/jquery/autoNumeric.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        $('#value').autoNumeric('init', {aSep: '.', aDec: ',', vMin: '0', vMax: '999999999999' });
    });

		$(document).ready(function(){


      $('#project_name').autocomplete({
                    source: "<?php echo site_url('crud_expense/get_autocomplete');?>",

                    select: function (event, ui) {

                        $('[name="project_name"]').val(ui.item.label);
                        $('[name="project_name_code"]').val(ui.item.description);

                    }
                })
                .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
              .append( "<div>" + item.string_code + "</div>" )
                .appendTo( ul );
          };
      });

	</script>

  <script type="text/javascript">
  $("#project_name").change(function() {
    $("#project_name_code").trigger("change");
  });

  $('#project_name_code').change(function(){
        var fart = $('[name="project_name_code"]').val();

      $.ajax({
        type: "POST",
        url: "<?php echo site_url('crud_payment/cek_max')?>",
        dataType: 'json',
        data: {project_code_fk: fart},
        success: function(response) {
             if(response.success == true) {
               document.getElementById("Payment").selectedIndex = parseInt(response.max)+1;

            }

         }
      })
    })



   $('#mydata').submit(function(e){
     e.preventDefault();
      var fa = $(this);

       $.ajax({
         url: fa.attr('action'),
         type: 'post' ,
         data: fa.serialize(),
         dataType: 'json',
         success: function(response) {
           if(response.success == true) {

             $('#info').append('<div class="alert alert-success">' +
               'Data Tersimpan' + '</div>');
             $('.form-group').removeClass('has-error')
                             .removeClass('has-success');
             $('.text-danger').remove();
             fa[0].reset();
             $('#table').DataTable().ajax.reload();
             $('.alert-success').delay(300).show(10, function() {
                 $(this).delay(2000).hide(10, function() {
                     $(this).remove();

                 });
             })

           } else {
             $.each(response.messages,function(key, value){
               var element = $('#' + key);
               element.closest('div.form-group')
               .removeClass('has-error')
               .addClass(value.length > 0 ? 'has-error' : 'has-success')
               .find('.text-danger')
               .remove();
               element.after(value);
             });
           }
         }
      });

   });


  </script>
  <script type="text/javascript">
  function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
  }

  function format ( d ) {
    var table = '';
    var rows = 8;
    var namearr = d[5].split(",");
    var namearr2 = d[6].split(",");
    var namearr3 = d[7].split(",");




  var no = 1;
  			for(var a = 0; a < namearr.length; a++){
          table +='<tr id='+namearr[a]+'>';
          table +='<td>' + no + '</td>';
  				table +='<td>' + formatNumber(namearr2[a]) + '</td>';
          table +='<td>' + namearr3[a] + '</td>';
          table +='<td>' + d[8] + '</td>';
          table +='</tr>';
          no++;
  			}



      // `d` is the original data object for the row
      return '<table cellpadding="7" cellspacing="0" border="0" style="padding-left:50px;">'+
          '<tr>'+

              '<th>No</th>'+
              '<th>Payment Value</th>'+
              '<th>Date Payment</th>'+
              '<th>Action</th>'+
              '</tr>'+
          table+
      '</table>';
  }
  var table;

  $(document).ready(function() {
    $('#table tbody').on('click', 'td.details-control', function () {
      var tr = $(this).closest('tr');
         var tdi = tr.find("i.fas");
         var row = table.row(tr);

         if (row.child.isShown()) {
             // This row is already open - close it
             row.child.hide();
             tr.removeClass('shown');
             tdi.first().removeClass('fas fa-minus-circle');
             tdi.first().addClass('fas fa-plus-circle');
         }
         else {
             // Open this row
             row.child(format(row.data())).show();
             tr.addClass('shown');
             tdi.first().removeClass('fas fa-plus-circle');
             tdi.first().addClass('fas fa-minus-circle');
         }
        } );
  //datatables
  table = $('#table').DataTable({
    "pagingType": "full",
    "lengthChange": false,
    "pageLength": 10,
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.
      // Load data for the table's content from an Ajax source
      "ajax": {
          "url": "<?php echo site_url('crud_payment/ajax_list')?>",
          "type": "POST"
      },
      //Set column definition initialisation properties.
      "columnDefs": [
        {"targets": [ 0 ],   "className":      'details-control',"orderable": false },  //first column / numbering column

      {
          "targets": [ 1 ], //first column / numbering column
          "orderable": false, //set not orderable
      },


      ],
  });
  //reload
  $('#close').on('click',function(){
  $('#table').DataTable().ajax.reload();
  });


  // get Hapus Records
  $('#table').on('click','.trash',function(){
  var id_peker=$(this).parents("tr").attr("id");
  $('#hapusmodal').modal('show');
  $('[name="id_pekerja"]').val(id_peker);
});
         // End Hapus Records


  });

  </script>


  <!-- Modal Hapus Produk-->
  <!-- Logout Modal-->
  <form id="add-row-form" action="<?php echo base_url().'crud_payment/hapus'?>" method="post">
  <div class="modal fade" id="hapusmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hapus Data?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <input type="text" name="id_pekerja" class="form-control" placeholder="" required>
      <div class="modal-body">Anda yakin mau menghapus record ini?</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <button type="submit" id="add-row" class="btn btn-danger">Hapus</button>
      </div>
    </div>
  </div>
  </div>
  </form>
