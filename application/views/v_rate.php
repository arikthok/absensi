<link href="<?php echo base_url('assets/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<body>
  <!--input -->
  <div class="col-md-4" style="padding-left: 0px;">
    <div class="container " >
      <div class="card mt-3">
        <div class="card-header"><h4>Add Position</h4></div>
        <div class="card-body">
          <div id="info"></div>


         <?php echo form_open('crud_rate/data', 'id="mydata" '); ?>

         <div class="form-group ">
          <div class="form-row ">
            <div class="col">
              <div class="form-row ">
                <div class="col-md-4">
                  <div >
                   <label class="control-label">Position</label>
                  </div>
                </div>
                <div class="col-md-7">
                  <div >
                    <input type="text" tabindex="1" id="position" name="position" class="form-control" autocomplete="off" required="required" data-error="Please enter your kode proyek">
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
                <label for="firstName">Rate / Hours</label>
               </div>
             </div>
             <div class="col-md-7">
               <div >
                 <input type="text" tabindex="2" id="rate" name="rate" autocomplete="off" class="form-control"  required="required">
               </div>
             </div>
           </div>
         </div>
     </div>
    </div>
    <div class="text-center">
    <input class="submit center-block btn btn-primary" tabindex="9" value="Add Rate" type="submit">
      </div>
          </form>
          </div>
        </div>
    </div>
</div>

  <!-- datatables -->
  <div class="col-md-5" style="padding-left: 0px;">
<div class="container">
<div class="card mt-3">
  <div class="card-header"><h4>Position / Rate Hours</h4></div>
    <div class="card-body">
      <div id="info2"></div>
      <table id="table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5px">No</th>
                <th width="5px">id</th>
                <th>Position</th>
                <th>Rate/Hours</th>
                <th width="10px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    </div></div>
</div>
</div>

<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/vendor/jquery/autoNumeric.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        $('#rate').autoNumeric('init', {aSep: '.', aDec: ',', vMin: '0', vMax: '99999999999' });
    });

var table;

$(document).ready(function() {
//datatables
table = $('#table').DataTable({
  "pagingType": "full",
  "lengthChange": false,
  "searching": false,
  "pageLength": 10,
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    "order": [], //Initial no order.
    // Load data for the table's content from an Ajax source
    "ajax": {
        "url": "<?php echo site_url('crud_rate/ajax_list')?>",
        "type": "POST"
    },
    //Set column definition initialisation properties.
    "columnDefs": [
    {
        "targets": [ 0,4 ], //first column / numbering column
        "orderable": false, //set not orderable

    },{ "targets": [1], visible: false},

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
       $('[name="id_pekerja"]').val(id_peker[1]);
 });
       // End Hapus Records

});

</script>

<?php echo form_open('crud_rate/hapus', 'id="hapusform" '); ?>
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

<script type="text/javascript">
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
           $('.alert-danger').delay(500).show(10, function() {
               $(this).delay(3000).hide(10, function() {
                   $(this).remove();

               });
           })

         } else {
           $('#info2').append('<div class="alert alert-danger">' +
             'Position Sudah Digunakan Tidak Bisa di Hapus' + '</div>');
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
