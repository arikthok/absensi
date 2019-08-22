<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/fullcalendar/fullcalendar.min.css" />
               <script src="<?php echo base_url() ?>assets/vendor/fullcalendar/lib/moment.min.js"></script>
               <script src="<?php echo base_url() ?>assets/vendor/fullcalendar/fullcalendar.min.js"></script>
               <script src="<?php echo base_url() ?>assets/vendor/fullcalendar/gcal.js"></script>
               <script src="<?php echo base_url().'assets/js/jquery-ui.js'?>" type="text/javascript"></script>
               <link rel="stylesheet" href="<?php echo base_url().'assets/css/jquery-ui.css'?>">

               <script src="<?php echo base_url() ?>assets/vendor/datepair/dist/datepair.js"></script>

               <script src="<?php echo base_url() ?>assets/vendor/jquery/jquery.timepicker.js"></script>
                <link rel="stylesheet" href="<?php echo base_url().'assets/css/time-picker.css'?>">


<body>
  <div class="container">
  <div class="card mt-3">
      <div class="card-header"><h4>Working Project</h4></div>
      <div id="info"></div>
      <div class="card-body">

        <div id="calendar">
        </div>
      </div>
    </div>
  </div>
</body>

<script type="text/javascript">

    $(document).ready(function() {

      $('#reason').change(function(){
         if($(this).val() == "other")
         {
          $('#other').show();
         }
         else
         {
         $('#other').hide();

         }

      })

      $("#texthide").hide();
      $("#endhide").hide();

      $('#checkbox').change(function(){
        if (this.checked) {
          $('#text').fadeOut('fast'); //projectname note
          $('#texthide').fadeIn('fast'); //reason
          $('#endhide').fadeIn('fast'); //enddate
          $('#basicExample').fadeOut('fast');
        } else {

          $('#text').fadeIn('fast');
          $('#texthide').fadeOut('fast');
          $('#endhide').fadeOut('fast');
          $('#basicExample').fadeIn('fast');
        }
      });





      var date_last_clicked = null;
        $('#calendar').fullCalendar({

          header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            businessHours: {
  // days of week. an array of zero-based day of week integers (0=Sunday)
                dow: [ 1, 2, 3, 4,5 ], // Monday - Thursday

                start: '08:00', // a start time (10am in this example)
                end: '17:00', // an end time (6pm in this example)
            },

                editable: false,
                eventLimit: true, // allow "more" link when too many events
                selectable: true,
                selectHelper: true,

                minTime: '06:00:00',
                maxTime: '21:00:00',
                timeFormat: 'H(:mm)', // uppercase H for 24-hour clock
                select: function(start, end) {
                    $('#addModal input[name=start_date]').val(moment(start).format('YYYY-MM-DD'));
                    $('#addModal input[name=end_date]').val(moment(start).format('YYYY-MM-DD'));
                    $('#addModal').modal('show');
                    save();
                    $('#calendar').fullCalendar('unselect');
                },


            eventSources: [
              {
                events: function(start, end, timezone, callback,sisa) {

                 $.ajax({
                 url: '<?php echo base_url() ?>crud_absent/get_events',
                 dataType: 'json',
                 data: {
                 // our hypothetical feed requires UNIX timestamps
                 start: start.unix(),
                 end: end.unix(),



                 },
                 success: function(msg) {
                     var events = msg.events;
                     callback(events);
                 }
                 });
             },textColor: 'white'
           },
         ],
       dayClick: function(date, jsEvent, view) {
          date_last_clicked = $(this);

          $('#addModal').modal();

      },
      eventClick: function(event, jsEvent, view) {
            $('#name2').val(event.name);
            $('#project_code2').val(event.project_code);
            $('#description2').val(event.description);
            $('#start_date2').val(moment(event.datestart).format('YYYY-MM-DD'));
            $('#start_time2').val(moment(event.datestart).format('HH:mm'));
            if(event.dateend) {
              $('#end_date2').val(moment(event.dateend).format('YYYY-MM-DD'));
                $('#end_time2').val(moment(event.dateend).format('HH:mm'))
            } else {
              $('#end_date2').val(moment(event.datestart).format('YYYY-MM-DD'));
                $('#end_time2').val(moment(event.datestart).format('HH:mm'));
            }
            $('#event_id2').val(event.id);
            $('#editModal').modal();
      },

        });
    });
</script>
<script type="text/javascript">
		$(document).ready(function(){


      $('#project_name').autocomplete({
                    source: "<?php echo site_url('crud_expense/get_autocomplete');?>",

                    select: function (event, ui) {


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


<!--add modal-->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="width="50px"">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Event</h5>
       <button id="close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
        <div id="info2"></div>

      <div class="modal-body">
      <?php echo form_open(site_url("crud_absent/add_event"),'id="mydata" ', array("class" => "form-horizontal")) ?>
      <div class="form-group">
                <div class="col-md-8 ui-front">

                <input type="checkbox" id="checkbox" name="checkbox" value="1" > Absent
                </div>
        </div>

        <div id="texthide" class="form-group project" >
                <label for="p-in" class="col-md-4 label-heading">Reason Absent</label>
                <div class="col-md-8 ui-front">
                <select name="reason" id="reason" class="form-control">
                             <option value="">Choice</option>
                             <?php foreach($datas as $row):?>
                                 <option value="<?php echo $row->information_id;?>"><?php echo $row->information_name;?></option>
                             <?php endforeach;?>
                </select><br>
                <input type="text" id="other" class="form-control" name="other" style="display:none;">


              </div>

        </div>



        <div id="text" class="form-group project">
                <label for="p-in" class="col-md-4 label-heading">Project Name</label>

                <div class="col-md-8 ui-front">

                    <input type="text" id="project_name" class="form-control" name="project_name" value="" autocomplete="off"  >
                    <input type="hidden" id="project_name_code" name="project_name_code" value="" autocomplete="off" >
                </div>

                <label  class="col-md-4 label-heading">Note</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="description" autocomplete="off"  data-error="Please enter your full name.">
                </div>
        </div>
        <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Start Date</label>
                <div class="col-md-8">
                  <div >
                  <div id="end_date"> </div>
                  <div class="input-group">
                  <input id="datepicker2" tabindex="10" autocomplete="off" name="start_date"  class="date form-control " required="required" />
                  <button type="button" class="btn btn-outline-secondary" disabled>
                  <span class="far fa-calendar-alt"></span>
                  </button>

                 <div id="basicExample" class="input-group" style="padding-top:5px;">
                       <input id="start_time" type="text" class="time start form-control" name="start_time"  />&nbsp to &nbsp
                      <input  type="text" class="time end form-control" name="end_time"  />
                </div>
                </div>
                <script>
                $('#basicExample .time').timepicker({
                    'timeFormat': 'G:i',
                    'minTime': '8',
                    'maxTime': '9:00pm',
                    'step': '60',

                });



                var basicExampleEl = document.getElementById('basicExample');
                var datepair = new Datepair(basicExampleEl);
            </script>
     <script>
       $( "#datepicker2" ).datepicker({dateFormat: 'yy-mm-dd',
     beforeShow: function() {
         setTimeout(function(){
             $('.ui-datepicker').css('z-index', 99999999999999);
         }, 0);
     }});
     </script>
                </div></div>
        </div>
        <div class="form-group" id="endhide">
                <label for="p-in" class="col-md-4 label-heading">End Date</label>
                <div class="col-md-8">
                  <div class="input-group">
                    <input type="text" id="datepicker3"  class="date form-control" name="end_date" autocomplete="off" required="required" data-error="Please enter your full name.">
                    <button type="button" class="btn btn-outline-secondary" disabled>
                    <span class="far fa-calendar-alt"></span>
                  </button></div></div>
                <script>
                  $( "#datepicker3" ).datepicker({dateFormat: 'yy-mm-dd',
                beforeShow: function() {
                    setTimeout(function(){
                        $('.ui-datepicker').css('z-index', 99999999999999);
                    }, 0);
                }});
                </script>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Add Event">
        <?php echo form_close() ?>
      </div>
    </div>
  </div>
</div>


<!-- edit modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Event</h5>
       <button id="close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      <div class="modal-body">
      <?php echo form_open(site_url("crud_absent/edit_event"),'id="mydata2" ', array("class" => "form-horizontal")) ?>
      <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Project Name</label>
                <div class="col-md-8 ui-front">

                  <input type="hidden" id="project_code2" class="form-control" name="project_name_code2" value="" autocomplete="off" required="required" data-error="Please enter your full name.">
            <input  type="text" class="form-control" name="name" value="" id="name2">
                </div>
        </div>
        <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Note</label>
                <div class="col-md-8 ui-front">
                    <input type="text" class="form-control" name="description" id="description2">
                </div>
        </div>
        <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">Start Date</label>
                <div class="col-md-8">
                    <div class="input-group">
                    <input tabindex="10" autocomplete="off" id="start_date2" name="start_date"  class="date form-control " required="required" />
                    <button type="button" class="btn btn-outline-secondary" disabled>
                    <span class="far fa-calendar-alt"></span>
                    </button>

                   <div id="basicExample2" class="input-group" style="padding-top:5px;">
                         <input id="start_time2" type="text" class="time start form-control" name="start_time" required="required" />&nbsp to &nbsp
                        <input id="end_time2" type="text" class="time end form-control" name="end_time" required="required" />
                  </div>
                  </div>
                </div>
                <script>
                  $( "#start_date2" ).datepicker({dateFormat: 'yy-mm-dd',
                beforeShow: function() {
                    setTimeout(function(){
                        $('.ui-datepicker').css('z-index', 99999999999999);
                    }, 0);
                }});


                $('#basicExample2 .time').timepicker({
                    'timeFormat': 'G:i',
                    'minTime': '8',
                    'maxTime': '9:00pm',
                    'step': '60',

                });



                var basicExampleE2 = document.getElementById('basicExample2');
                var datepair = new Datepair(basicExampleE2);

                </script>

        </div>
        <div class="form-group">
                <label for="p-in" class="col-md-4 label-heading">End Date</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="end_date" id="end_date2">
                </div>
        </div>
        <div class="form-group">

                    <div class="col-md-8">
                        <input type="hidden" name="delete" value="1">
                    </div>
            </div>
            <input type="hidden" name="eventid" id="event_id2" value="0" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-danger" value="Delete Event">
        <?php echo form_close() ?>
      </div>
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
           if(response.absent == true){
             window.location.reload();
           }
           $('#info').append('<div class="alert alert-success">' +
             'Data Tersimpan' + '</div>');
           $('.form-group').removeClass('has-error')
                           .removeClass('has-success');
           $('.text-danger').remove();
           fa[0].reset();

           $('#calendar').fullCalendar('refetchEvents');
           $('#addModal').modal('hide');
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
           $('#info').append('<div class="alert alert-success">' +
             'Data Terhapus' + '</div>');
           $('.form-group').removeClass('has-error')
                           .removeClass('has-success');
           $('.text-danger').remove();
           fa[0].reset();

           $('#calendar').fullCalendar('refetchEvents');
           $('#editModal').modal('hide');
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
