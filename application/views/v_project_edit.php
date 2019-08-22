
<link rel="stylesheet" href="<?php echo base_url().'assets/css/jquery-ui.css'?>">
<script src="<?php echo base_url();?>assets/vendor/jquery/gijgo.min.js" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/js/jquery-ui.js'?>" type="text/javascript"></script>

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


	    <div class="container " >
	      <div class="card mt-3">
	        <div class="card-header"><h4>Update Project</h4></div>
	        <div class="card-body">
            <div id="info"></div>
<?php foreach($project as $u){ ?>
	         <?php echo form_open('crud_project/update', 'id="mydata" '); ?>

	         <div class="form-group ">
						<div class="form-row ">
							<div class="col">
	              <div class="form-row ">
	                <div class="col-md-4">
	                  <div >
	                   <label class="control-label">Project Code</label>
	                  </div>
	                </div>
	                <div class="col-md-5">
	                  <div >
	                    <input readonly value="<?php echo $u->project_code ?>" type="text" tabindex="1" id="code" name="code" class="form-control" autocomplete="off" required="required" data-error="Please enter your full name.">
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
	                   <label for="firstName">Project Value</label>
	                  </div>
	                </div>
	                <div class="col-md-4">
	                  <div >
	                    <input type="text" value="<?php echo $u->value ?>" tabindex="7" id="value" name="value" class="form-control" autocomplete="off" required="required">
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
									<label for="firstName">Project Name</label>
								 </div>
							 </div>
							 <div class="col-md-5">
								 <div >
									 <input type="text" value="<?php echo $u->project_name ?>" tabindex="2" id="name" name="name" autocomplete="off" class="form-control"  required="required">
								 </div>
							 </div>
						 </div>
					 </div>


				 <div class="col">
					 <div class="form-group ">
						 <div class="form-row ">
							 <div class="col-md-4">
								 <div >
									<label for="firstName">PIC</label>
								 </div>
							 </div>
							 <div class="col-md-4">
								 <div >
									 <input name="pic" value="<?php echo $u->pic ?>" tabindex="8" id="pic" class="form-control" autocomplete="off" placeholder="Type Name User" >
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
              <label for="firstName">Project Type</label>
             </div>
           </div>
           <div class="col-md-5">
             <div class="form-check">
   						 <input type="radio" tabindex="3" <?php if( $u->project_type == "ar" ) {echo "checked";} ?> class="form-check-input" id="type" name="type" value="ar" required="required">
   						 <label class="form-check-label" for="type">Architecture</label>
   						 </div>
   						 <div class="form-check">
   						 <input type="radio" tabindex="4" <?php if( $u->project_type == "mp" ) {echo "checked";} ?> class="form-check-input" id="type" name="type" value="mp" required="required">
   						 <label class="form-check-label" for="type">Master Planning</label>
   						 </div>
							 <div class="form-check">
   						 <input type="radio" tabindex="5" <?php if( $u->project_type == "mp/ar" ) {echo "checked";} ?> class="form-check-input" id="type" name="type" value="mp/ar" required="required">
   						 <label class="form-check-label" for="type">MP/AR</label>
   						 </div>
           </div>
         </div>
       </div>


      <div class="col">
       <div class="form-group ">
         <div class="form-row ">
           <div class="col-md-4">
             <div >
              <label for="firstName">Project Start</label>
             </div>
           </div>
           <div class="col-md-4">
             <div ><div class="input-group">
               <input value="<?php echo $u->project_start ?>" id="datepicker" tabindex="10" autocomplete="off" name="start"  class="form-control" required="required" />
               <button type="button" class="btn btn-outline-secondary" disabled>
               <span class="far fa-calendar-alt"></span>
             </button>
              </div>
              <script>
              $( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd'});

    </script>
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
		 					<label for="firstName">Location</label>
		 				 </div>
		 			 </div>
					 <div class="col-md-5">
             <input name="location" value="<?php echo $u->location ?>" tabindex="5" id="location" class="form-control" >

					 </div>
		 		 </div>
		 	 </div>


		  <div class="col">
		 	 <div class="form-group ">
		 		 <div class="form-row ">
		 			 <div class="col-md-4">
		 				 <div >
		 					<label for="firstName">Project End</label>
		 				 </div>
		 			 </div>
					 <div class="col-md-4">
             <div ><div class="input-group">
               <input id="datepicker2" value="<?php echo $u->project_end ?>" tabindex="10" autocomplete="off" name="end"  class="form-control" required="required" />
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
		 </div>

		 <div class="form-group ">
			 <div class="form-row ">
				 <div class="col">
					 <div class="form-row ">
						 <div class="col-md-4">
							 <div >
								<label for="firstName">Client</label>
							 </div>
						 </div>
						 <div class="col-md-5">
							 <div >
                 <div class="input-group" id="client_name">
                <input type="text" value="<?php echo $u->client_name ?>"  name="client_name" class="form-control" id="title" required="required"  placeholder="Type Name Client" >
                  <a data-target="#tambahmodal" data-toggle="modal" class="tambah" id="tambah_client"><button  onkeyup="sync()" type="button" class="btn btn-outline-primary" onClick="copy();">
                  <span class="fas fa-plus-circle"></span>
                </button></a>
              </div>
                <input type="hidden" name="client" value="<?php echo $u->client_id ?>" class="form-control" >

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


 <input class="submit center-block btn btn-primary" tabindex="11" value="Update" type="submit">

				</div>
	          </form>
<?php } ?>
	        </div>
	      </div>
	    </div>
			<div class="card mt-5">
				</div>


</body>
<script type="text/javascript" src="<?php echo base_url();?>assets/vendor/jquery/autoNumeric.js"></script>
<script type="text/javascript">
$(document).ready(function(){

        $('#value').autoNumeric('init', {aSep: '.', aDec: ',', vMin: '0', vMax: '999999999999' });
    });
function copy()
{
    var n1 = document.getElementById("title");
    var n2 = document.getElementById("client_name2");
    n2.value = n1.value;
}
</script>

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

<script type="text/javascript">
		$(document).ready(function(){

		    $('#title').autocomplete({
                source: "<?php echo site_url('crud_project/get_autocomplete');?>",

                select: function (event, ui) {
                    $('[name="client_name"]').val(ui.item.label);
                    $('[name="client"]').val(ui.item.description);
                }
            });

        $('#pic').autocomplete({
                    source: "<?php echo site_url('crud_project/get_autocomplete2');?>",

                    select: function (event, ui) {
                        $('[name="pic"]').val(ui.item.label);

                    }
                });

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
	               <input type="text" class="form-control" id="bank" name="bank" tabindex="8" required="required">
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
	                   <input type="text" tabindex="5" id="client_pic" name="client_pic" autocomplete="off" class="form-control"  required="required">
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
	                   <input type="text" tabindex="5" id="rek" name="rek" autocomplete="off" class="form-control"  required="required">
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

	                   <input type="text" tabindex="5" id="phone" name="phone" autocomplete="off" class="form-control"  required="required">

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
