
  <script src="<?php echo base_url();?>assets/vendor/jquery/gijgo.min.js" type="text/javascript"></script>
<link href="<?php echo base_url('assets/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/bootstrap/css/gijgo.css" rel="stylesheet" type="text/css" />
    <style>
    @media (min-width: 576px) {
      .modal-dialog { max-width: none; }
    }

    .modal-dialog {
      width: 60%;
      padding: 0;
    }

    .modal-content {
      height: 99%;
    }

    </style>

<body>

<!-- datatables -->
<div class="col-md-10" style="padding-left: 0px;">
  <div class="container">
    <div class="card mt-3">
    <div class="card-header"><h4>List Client</h4></div>
    <div class="card-body">
        <table id="table" class="table table-bordered table-striped">
          <a data-target="#tambahmodal" data-toggle="modal" class="tambah">
           <button class="btn btn-primary "><i class="fas fa-table fa-sm"></i> Add Client</button></a>
           <thead>
              <tr>
                  <th></th>
                  <th>No</th>
                  <th>Client Name</th>
                  <th>City</th>
                  <th>PIC</th>
                  <th>Phone</th>
                  <th>ID</th>
                  <th width="10px">Action</th>


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

<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>

<script type="text/javascript">


function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="7" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Alamat:</td>'+
            '<td>'+d[8]+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Email:</td>'+
            '<td>'+d[9]+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>NPWP:</td>'+
            '<td>'+d[10]+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Bank Name:</td>'+
            '<td>'+d[11]+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Bank Account:</td>'+
            '<td>'+d[12]+'</td>'+
        '</tr>'+
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
  "pageLength": 20,
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    "order": [], //Initial no order.
    // Load data for the table's content from an Ajax source
    "ajax": {
        "url": "<?php echo site_url('crud_client/ajax_list')?>",
        "type": "POST"
    },
    //Set column definition initialisation properties.
    "columnDefs": [
      {"targets": [ 0 ],   "className":      'details-control',"orderable": false },  //first column / numbering column

    {
        "targets": [ 5,6 ], //first column / numbering column
        "orderable": false, //set not orderable
    },
       { "targets": [6,8,9,10,11], visible: false,  "orderable": false,},

    ],
});
//reload
$('#close').on('click',function(){
$('#table').DataTable().ajax.reload();
});

// get Hapus Records
       $('#table').on('click','.trash',function(){
       var id_peker=table.row( $(this).parents('tr') ).data();
       $('#hapusmodal').modal('show');
       $('[name="id_pekerja"]').val(id_peker[6]);
 });
       // End Hapus Records

});

</script>

<div  class="modal" id="tambahmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full" role="document">


   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title">Add Client</h5>
      <button id="close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>

     </div>
     <div id="info2"></div>
      <div class="modal-body">
        <div class="container " >
          <div class="card mt-3">
            <div class="card-body">


             <?php echo form_open('crud_project/data_client', 'id="mydata2" '); ?>

             <div class="form-group ">
              <div class="form-row ">
                <div class="col">
                  <div class="form-row ">
                    <div class="col-md-4">
                      <div >
                       <label class="control-label">client Name</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div >
                        <input type="text" tabindex="1" id="client_name2" name="client_name2" class="form-control" autocomplete="off" required="required" data-error="Please enter your kode proyek">
                         <div class="help-block with-errors"></div>
                      </div>
                    </div>
                  </div>
                </div>


              <div class="col">
                <div class="form-group ">
                  <div class="form-row ">
                    <div class="col-md-4">
                      <div >
                       <label for="firstName">Email</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div >
                        <input type="text" tabindex="6" id="email" name="email" class="form-control" autocomplete="off" required="required">
                      </div>
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
                    <label for="firstName">Address</label>
                   </div>
                 </div>
                 <div class="col-md-6">
                   <div >
                     <input type="text" tabindex="2" id="address" name="address" autocomplete="off" class="form-control"  required="required">
                   </div>
                 </div>
               </div>
             </div>


           <div class="col">
             <div class="form-group ">
               <div class="form-row ">
                 <div class="col-md-4">
                   <div >
                    <label for="firstName">Npwp</label>
                   </div>
                 </div>
                 <div class="col-md-6">
                   <div >
                     <input type="text" name="npwp" tabindex="7" id="npwp" class="form-control" autocomplete="off"  >
                   </div>
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
                <label for="firstName">City</label>
               </div>
             </div>
             <div class="col-md-6">
               <div >
                 <input type="text" tabindex="4" id="city" name="city" autocomplete="off" class="form-control"  required="required">
               </div>
             </div>
           </div>
         </div>


        <div class="col">
         <div class="form-group ">
           <div class="form-row ">
             <div class="col-md-4">
               <div >
                <label for="firstName">Bank Name</label>
               </div>
             </div>
             <div class="col-md-6">
               <input type="text" class="form-control" id="bank" name="bank" tabindex="8" >
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
                  <label for="firstName">PIC</label>
                 </div>
               </div>
               <div class="col-md-6">
                 <div >
                   <input type="text" tabindex="5" id="client_pic" name="client_pic" autocomplete="off" class="form-control"  >
                 </div>
               </div>
             </div>
           </div>


         <div class="col">
           <div class="form-group ">
             <div class="form-row ">
               <div class="col-md-4">
                 <div >
                  <label for="firstName">Bank Account</label>
                 </div>
               </div>
               <div class="col-md-6">
                 <div >
                   <input type="text" tabindex="5" id="rek" name="rek" autocomplete="off" class="form-control" >
                 </div>
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
                <label for="firstName">Phone</label>
               </div>
             </div>
             <div class="col-md-6">
               <div >

                   <input type="text" tabindex="5" id="phone" name="phone" autocomplete="off" class="form-control">

                  </div>
             </div>
           </div>
         </div>


        <div class="col">
         <div class="form-group ">
           <div class="form-row ">
             <div class="col-md-4">
               <div >

               </div>
             </div>
             <div class="col-md-4">

             </div>
           </div>
         </div>
        </div>
        </div>
        </div>
        <div class="text-center">
        <input class="submit center-block btn btn-primary" tabindex="9" value="Add User" type="submit">

          </div>
              </form>
                        </div>
          </div>
        </div>

      </div>
      <!--
      <div class="modal-footer">
          <button id="close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>-->
    </div>

  </div>
</div>
<script type="text/javascript">
 $('#mydata2').submit(function(e){
   e.preventDefault();
    var fa = $(this);

     $.ajax({
       url: fa.attr('action'),
       type: 'post' ,
       data: fa.serialize(),
       dataType: 'json',
       success: function(response) {
         if(response.success == true) {

           $('#info2').append('<div class="alert alert-success">' +
             'Data Tersimpan' + '</div>');
           $('.form-group').removeClass('has-error')
                           .removeClass('has-success');
           $('.text-danger').remove();
           fa[0].reset();

           $('.alert-success').delay(300).show(10, function() {
             $('#table').DataTable().ajax.reload();
             $(this).delay(2000).hide(10, function() {
                   $(this).remove();
                   $('#tambahmodal').modal('hide');
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

<!-- Modal Hapus Produk-->
<!-- Logout Modal-->
<form id="add-row-form" action="<?php echo base_url().'crud_client/hapus'?>" method="post">
<div class="modal fade" id="hapusmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Hapus Data?</h5>
      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
    <input type="hidden" name="id_pekerja" class="form-control" placeholder="" required>
    <div class="modal-body">Anda yakin mau menghapus record ini?</div>
    <div class="modal-footer">
      <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      <button type="submit" id="add-row" class="btn btn-danger">Hapus</button>
    </div>
  </div>
</div>
</div>
</form>
