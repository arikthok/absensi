<link href="<?php echo base_url('assets/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
@media (min-width: 576px) {
  .modal-dialog { max-width: none; }
}

.modal-dialog {
  width: 70%;
  padding: 0;
}

.modal-content {
  height: 99%;
}


</style>
<body>
<div class="col-md-10" style="padding-left: 0px;">
<div class="container">
  <div class="card mt-3">


  <div class="card-header"><h4>List User</h4></div>
      <div class="card-body">


      <table id="table" class="table table-bordered table-striped">
    <a data-target="#tambahmodal" data-toggle="modal" class="tambah">
     <button class="btn btn-primary "><i class="fas fa-table fa-sm"></i> Add User</button></a>
        <thead>
            <tr>
              <th></th>
                <th>No</th>
                <th>User Name</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>City</th>
                <th>Position</th>
                <th width="10px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
<!--
        <tfoot>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>City</th>
                <th>Country</th>
                <th>Action</th>


            </tr>
        </tfoot>
-->
    </table></div>
</div>
</div>
</div>

<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>

<script type="text/javascript">

function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="7" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>NIP:</td>'+
            '<td>'+d[8]+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Address:</td>'+
            '<td>'+d[9]+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Telp Number:</td>'+
            '<td>'+d[10]+'</td>'+
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
var table = $('#table').DataTable({
  "pagingType": "full",
  "lengthChange": false,
  "pageLength": 10,
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    "order": [], //Initial no order.
    // Load data for the table's content from an Ajax source
    "ajax": {
        "url": "<?php echo site_url('crud_user/ajax_list')?>",
        "type": "POST"
    },
    //Set column definition initialisation properties.

    "columnDefs": [
    {"targets": [ 0 ],   "className":      'details-control',"orderable": false },  //first column / numbering column
    {"targets": [ 0,7 ],  "orderable": false },
     { "targets": [8,9,10], visible: false},
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
       $('[name="id_pekerja"]').val(id_peker[2]);
 });


       // End Hapus Records

});

</script>

</body>
<!-- Modal Hapus Produk-->

<form id="add-row-form" action="<?php echo base_url().'crud_user/hapus'?>" method="post">
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
<!-- end hapus Modal-->

<div  class="modal" id="tambahmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full" role="document">


   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title">Add User</h5>
      <button id="close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>

     </div>
     <div id="info"></div>
      <div class="modal-body">
        <div class="container " >
          <div class="card mt-3">
            <div class="card-body">


             <?php echo form_open('crud_user/data', 'id="mydata" '); ?>

             <div class="form-group ">
              <div class="form-row ">
                <div class="col">
                  <div class="form-row ">
                    <div class="col-md-4">
                      <div >
                       <label class="control-label">User Name</label>
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div >
                        <input type="text" tabindex="1" id="user_name" name="user_name" class="form-control" autocomplete="off" required="required" data-error="Please enter your kode proyek">
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
                       <label for="firstName">Address</label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div >
                        <input type="text" tabindex="6" id="address" name="address" class="form-control" autocomplete="off" required="required">
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
                    <label for="firstName">NIP</label>
                   </div>
                 </div>
                 <div class="col-md-5">
                   <div >
                     <input type="text" tabindex="2" id="nip" name="nip" autocomplete="off" class="form-control"  required="required">
                   </div>
                 </div>
               </div>
             </div>


           <div class="col">
             <div class="form-group ">
               <div class="form-row ">
                 <div class="col-md-4">
                   <div >
                    <label for="firstName">City</label>
                   </div>
                 </div>
                 <div class="col-md-4">
                   <div >
                     <input type="text" name="city" tabindex="7" id="city" class="form-control" autocomplete="off"  >
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
                <label for="firstName">Full Name</label>
               </div>
             </div>
             <div class="col-md-5">
               <div >
                 <input type="text" tabindex="4" id="full_name" name="full_name" autocomplete="off" class="form-control"  required="required">
               </div>
             </div>
           </div>
         </div>


        <div class="col">
         <div class="form-group ">
           <div class="form-row ">
             <div class="col-md-4">
               <div >
                <label for="firstName">Telephone</label>
               </div>
             </div>
             <div class="col-md-4">
               <input type="text" class="form-control" id="telephone" name="telephone" tabindex="8" required="required">
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
                  <label for="firstName">Email</label>
                 </div>
               </div>
               <div class="col-md-5">
                 <div >
                   <input type="text" tabindex="5" id="email" name="email" autocomplete="off" class="form-control"  required="required">
                 </div>
               </div>
             </div>
           </div>


         <div class="col">
           <div class="form-group ">
             <div class="form-row ">
               <div class="col-md-4">
                 <div >
                  <label for="firstName">Position</label>
                 </div>
               </div>
               <div class="col-md-4">
                 <select required name="position" id="position" class="form-control">
                              <option value="">Choice</option>
                              <?php foreach($datas->result() as $row):?>
                                  <option value="<?php echo $row->id_rate;?>"><?php echo $row->position;?></option>
                              <?php endforeach;?>
                  </select>
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
                  <label for="firstName">Default Password : <?php foreach($default ->result() as $row){
                    echo $row->information_name;?></label>
                </div>
             </div>
             <div class="col-md-5">
               <div >


                    <input type="hidden"  id="passw" name="passw" value="<?php echo $row->information_name;?>">
                  <?php } ?>
                </div>
             </div>
           </div>
         </div>
<?php
if($this->session->userdata("user_type") == "sa"){
  ?>
        <div class="col">
         <div class="form-group ">
           <div class="form-row ">
             <div class="col-md-4">
               <div >
                  <label for="firstName">User Type</label>
               </div>
             </div>
             <div class="col-md-4">
               <select required class="select form-control" id="user_type" name="user_type">
                 <option value="">Choice</option>
                 <option value="sa">
                 Super Admin
                 </option>
                 <option value="admin">
                 Admin
                 </option>
                 <option value="staff">
                 Staff
                 </option>
               </select>
             </div>
           </div>
         </div>
        </div>
<?php } ?>



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

           $('.alert-success').delay(500).show(10, function() {
               $(this).delay(3000).hide(10, function() {
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
