
    <link href="<?php echo base_url('assets/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<body>
    <div class="container">
        <div class="card-body"></div>

      <div class="card-header"><h4>Report Project</h4></div>
        <br />


        <table id="table" class="table table-bordered table-striped">
          <thead>
              <tr>
                <th></th>
                  <th>Project Code</th>
                  <th>Location</th>
                  <th>Value</th>
                  <th>Start</th>
                  <th>End</th>
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
      </table>
    </div>


<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>



<script type="text/javascript">


function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="7" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>PIC:</td>'+
            '<td>'+d[7]+'</td>'+
            '<td></td>'+
            '<td>email:</td>'+
            '<td>'+d[11]+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Client Name:</td>'+
            '<td>'+d[8]+'</td>'+
            '<td></td>'+
            '<td>NPWP:</td>'+
            '<td>'+d[12]+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Client Address:</td>'+
            '<td>'+d[9]+'</td>'+
            '<td></td>'+
            '<td>Bank Name:</td>'+
            '<td>'+d[13]+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Telephone:</td>'+
            '<td>'+d[10]+'</td>'+
            '<td></td>'+
            '<td>Bank Account:</td>'+
            '<td>'+d[14]+'</td>'+
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
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('report_project/ajax_list')?>",
            "type": "POST"
        },
        //Set column definition initialisation properties.
        "columnDefs": [
          {"targets": [ 0 ],   "className":      'details-control',"orderable": false },  //first column / numbering column


        {
            "targets": [ 6 ], //first column / numbering column
            "orderable": false, //set not orderable
        },

        ],
    });
    // get Hapus Records
          $('#table').on('click','.trash',function(){
          var id_peker=table.row( $(this).parents('tr') ).data();
          var convert = id_peker[1].split("-");
          $('#hapusmodal').modal('show');
          $('[name="id_pekerja"]').val(convert[0]+convert[1]);
        });
    // End Hapus Records

});

</script>

</body>
