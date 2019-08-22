<link href="<?php echo base_url('assets/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<body>

<div class="container">
  <div id="info2"></div>
  <div class="row">

  <!-- datatables expense -->
  <div class="col-md-5" style="padding-left: 0px;">
<div class="container">
<div class="card mt-3">
  <div class="card-header">  <div class="row justify-content-between"><div><h5>Type Expense</h5></div><div>
    <button data-toggle="modal" data-target="#tambahmodal"  id="add-expense" class="btn btn-primary">Add</button></div></div></div>
<div class="card-body">

      <table id="table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5px">No</th>
                <th width="5px">id</th>
                <th>Position</th>

                <th width="10px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    </div></div>
</div>
</div>
<!-- end datatables expense -->

<!-- datatables Absent -->
<div class="col-md-5" style="padding-left: 0px;">
<div class="container">
<div class="card mt-3">
<div class="card-header">  <div class="row justify-content-between"><div><h5>Type Absent</h5></div><div>
  <button data-toggle="modal" data-target="#tambahmodal"  id="add-absent" class="btn btn-primary">Add</button></div></div></div>
<div class="card-body">

    <table id="tableabsent" class="table table-bordered table-striped">
      <thead>
          <tr>
              <th width="5px">No</th>
              <th width="5px">id</th>
              <th>Position</th>

              <th width="10px">Action</th>
          </tr>
      </thead>
      <tbody>
      </tbody>
  </table>
  </div></div>
</div>
</div>
<!-- end datatables absent -->

<!-- Default Password -->
<div class="col-md-5" style="padding-left: 0px;">
<div class="container">

<div class="card mt-3">
<div class="card-header">  <div class="row justify-content-between"><div><h5>Default Password</h5></div><div>
  </div></div></div>
<div class="card-body">
<?php echo form_open('admin/default_pass', 'id="password" '); ?>

  <div class="form-group ">
    <div id="infopass"></div>
   <div class="form-row ">

       <div class="col align-self-center">
         <?php ?>


           <input type="text" placeholder="<?php foreach($datas as $row){
              echo $row->information_name;
            }?>" tabindex="2" id="default" name="default" autocomplete="off" class="form-control" >

       </div>
  </div>
</div>
<div class="text-center">
  <button type="submit"  class="btn btn-primary">Simpan</button>
</div>

</form>

  </div></div>
</div>
</div>
<!-- end Default Password -->
</div>
</div>


<?php echo form_open('admin/hapus', 'id="hapusform" '); ?>
<div class="modal fade" id="hapusmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
 <div class="modal-content">
   <div class="modal-header">
     <h5 class="modal-title" id="exampleModalLabel">Hapus Data?</h5>
     <button class="close" type="button" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">×</span>
     </button>
   </div>
   <input type="hidden" id="id_pekerja" name="id_pekerja" class="form-control" placeholder="" required>
   <div class="modal-body">Anda yakin mau menghapus record ini?</div>
   <div class="modal-footer">
     <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
     <button type="submit" id="add-row" class="btn btn-danger">Hapus</button>
   </div>
 </div>
</div>
</div>
</form>
<!-- tambah data expense -->
<div  class="modal" id="tambahmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title">Add Expense</h5>
      <button id="close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     </div>
     <div id="info"></div>
      <div class="modal-body">
         <?php echo form_open('admin/tambah', 'id="mydata" '); ?>
             <div class="container">
             <div class="form-group ">
                <div class="col align-self-center">
                     <label class="control-label">Input Data</label>
                </div>
                    <div class="col align-self-center" >
                      <input type="text" tabindex="1" id="input_data" name="input_data" class="form-control" autocomplete="off" required="required" data-error="Please enter your kode proyek">
                      <input type="hidden" tabindex="2" id="type" name="type" class="form-control" autocomplete="off" required="required" data-error="Please enter your kode proyek">

                    </div>
            </div>
        <div class="text-center">
        <input class="submit center-block btn btn-primary" tabindex="9" value="Add Data" type="submit">
          </div>
              </form>
            </div>
      </div>
        </div>
  </div>
</div>
<!-- end data expense -->


</body>




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
          $('#table').DataTable().ajax.reload();
          $('#tableabsent').DataTable().ajax.reload();
           $('.alert-success').delay(500).show(10, function() {

               $(this).delay(800).hide(10, function() {

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

 $('#password').submit(function(e){
   e.preventDefault();
    var fa = $(this);

     $.ajax({
       url: fa.attr('action'),
       type: 'post' ,
       data: fa.serialize(),
       dataType: 'json',
       success: function(response) {
         if(response.success == true) {
           $('#infopass').append('<div class="alert alert-success">' +
             'Data Tersimpan' + '</div>');

           $('.alert-success').delay(500).show(10, function() {

               $(this).delay(800).hide(10, function() {
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

 $('#hapusform').submit(function(e){
   e.preventDefault();
    var fa = $(this);

     $.ajax({
       url: fa.attr('action'),
       type: 'post' ,
       data: fa.serialize(),
       dataType: 'json',
       success: function(response) {
         if(response.success == true) {
           $('#info2').append('<div class="alert alert-danger">' +
             'Data Sudah Dihapus' + '</div>');
           $('.form-group').removeClass('has-error')
                           .removeClass('has-success');
           $('.text-danger').remove();
           fa[0].reset();
           $('#hapusmodal').modal('hide');
          $('#table').DataTable().ajax.reload();
          $('#tableabsent').DataTable().ajax.reload();
           $('.alert-danger').delay(500).show(10, function() {
               $(this).delay(3000).hide(10, function() {
                   $(this).remove();

               });
           })

         } else {
           $('#info2').append('<div class="alert alert-danger">' +
             'Expense Sudah Digunakan Tidak Bisa di Hapus' + '</div>');
              $('#hapusmodal').modal('hide');
              $('.alert-danger').delay(500).show(10, function() {
                  $(this).delay(3000).hide(10, function() {
                      $(this).remove();

                  });
              })
         }
       }
    });

 });



</script>


<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>

<script type="text/javascript">


var table;

$(document).ready(function() {
//datatables expense
table = $('#table').DataTable({
  "paging": false,
  "lengthChange": false,
  "searching": false,
  "ordering": false,
        "info":     false,
  "pageLength": 10,
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    "order": [], //Initial no order.
    // Load data for the table's content from an Ajax source
    "ajax": {
        "url": "<?php echo site_url('admin/data_list/expense')?>",
        "type": "POST"
    },
    //Set column definition initialisation properties.
    "columnDefs": [
    {
        "targets": [ 0,3 ], //first column / numbering column
        "orderable": false, //set not orderable

    },{ "targets": [1], visible: false},

    ],
});


table2 = $('#tableabsent').DataTable({
  "paging": false,
  "lengthChange": false,
  "searching": false,
  "ordering": false,
        "info":     false,
  "pageLength": 10,
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    "order": [], //Initial no order.
    // Load data for the table's content from an Ajax source
    "ajax": {
        "url": "<?php echo site_url('admin/data_list/absent')?>",
        "type": "POST"
    },
    //Set column definition initialisation properties.
    "columnDefs": [
    {
        "targets": [ 0,3 ], //first column / numbering column
        "orderable": false, //set not orderable

    },{ "targets": [1], visible: false},

    ],
});

// get Hapus Records
       $('#table').on('click','.expense',function(){
       var id_peker=table.row( $(this).parents('tr') ).data();
       $('#hapusmodal').modal('show');
       $('[name="id_pekerja"]').val(id_peker[1]);
 });

 $('#tableabsent').on('click','.absent',function(){
 var id_peker2=table2.row( $(this).parents('tr') ).data();
 $('#hapusmodal').modal('show');
 $('[name="id_pekerja"]').val(id_peker2[1]);
});
       // End Hapus Records
// get add Records expense
       $('#add-expense').on('click',function(){
       var type="expense";

       $('[name="type"]').val(type);
 });
       // End add Records

       // get add Records expense
              $('#add-absent').on('click',function(){
              var type="absent";

              $('[name="type"]').val(type);
        });
              // End add Records

});

</script>
