
<link rel="stylesheet" href="<?php echo base_url().'assets/css/jquery-ui.css'?>">
<script src="<?php echo base_url();?>assets/vendor/jquery/gijgo.min.js" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/js/jquery-ui.js'?>" type="text/javascript"></script>

<body>


	    <div class="container " >
	      <div class="card mt-3">
	        <div class="card-header"><h4>Update client</h4></div>
	        <div class="card-body">
            <div id="info"></div>
<?php foreach($client as $u){ ?>
      <?php echo form_open('crud_client/update_client', 'id="mydata" '); ?>

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
                 <input type="hidden" readonly value="<?php echo $u->client_id; ?>" tabindex="1" id="client_id" name="client_id" class="form-control" autocomplete="off" required="required" data-error="Please enter your kode proyek">

                 <input type="text" value="<?php echo $u->client_name; ?>" tabindex="1" id="client_name2" name="client_name2" class="form-control" autocomplete="off" required="required" data-error="Please enter your kode proyek">
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
                 <input type="text" value="<?php echo $u->email_client; ?>" tabindex="6" id="email" name="email" class="form-control" autocomplete="off" required="required">
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
              <input type="text" value="<?php echo $u->client_address; ?>" tabindex="2" id="address" name="address" autocomplete="off" class="form-control"  required="required">
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
              <input type="text" name="npwp" value="<?php echo $u->npwp; ?>" tabindex="7" id="npwp" class="form-control" autocomplete="off"  >
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
          <input type="text" value="<?php echo $u->client_city; ?>" tabindex="4" id="city" name="city" autocomplete="off" class="form-control"  required="required">
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
        <input type="text" value="<?php echo $u->bank; ?>"class="form-control" id="bank" name="bank" tabindex="8" required="required">
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
            <input type="text" value="<?php echo $u->client_pic; ?>" tabindex="5" id="client_pic" name="client_pic" autocomplete="off" class="form-control"  required="required">
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
            <input type="text" value="<?php echo $u->rek; ?>" tabindex="5" id="rek" name="rek" autocomplete="off" class="form-control"  required="required">
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

            <input type="text" tabindex="5" value="<?php echo $u->client_phone; ?>" id="phone" name="phone" autocomplete="off" class="form-control"  required="required">

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
    <input class="submit center-block btn btn-primary" tabindex="9" value="Update Client" type="submit">

    </div>
       </form>
<?php } ?>
	        </div>
	      </div>
	    </div>
			<div class="card mt-5">
				</div>


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
