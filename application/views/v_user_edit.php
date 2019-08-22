
<link rel="stylesheet" href="<?php echo base_url().'assets/css/jquery-ui.css'?>">
<script src="<?php echo base_url();?>assets/vendor/jquery/gijgo.min.js" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/js/jquery-ui.js'?>" type="text/javascript"></script>

<body>


	    <div class="container " >
	      <div class="card mt-3">
	        <div class="card-header"><h4>Update User</h4></div>
	        <div class="card-body">
            <div id="info"></div>
    <?php foreach($user as $u){ ?>
            <?php echo form_open('crud_user/update_user', 'id="mydata" '); ?>

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
                       <input type="text" readonly value="<?php echo $u->user_name; ?>"  tabindex="1" id="user_name" name="user_name" class="form-control" autocomplete="off" required="required" data-error="Please enter your kode proyek">
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
                       <input type="text" tabindex="6" value="<?php echo $u->user_address; ?>" id="address" name="address" class="form-control" autocomplete="off" required="required">
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
                    <input type="text" tabindex="2" value="<?php echo $u->nip; ?>" id="nip" name="nip" autocomplete="off" class="form-control"  required="required">
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
                    <input type="text" name="city" value="<?php echo $u->user_city; ?>" tabindex="7" id="city" class="form-control" autocomplete="off"  >
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
                <input type="text" tabindex="4" id="full_name" value="<?php echo $u->full_name; ?>" name="full_name" autocomplete="off" class="form-control"  required="required">
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
              <input type="text" class="form-control" id="telephone" value="<?php echo $u->telephone; ?>" name="telephone" tabindex="8" required="required">
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
                  <input type="text" tabindex="5" value="<?php echo $u->user_email; ?>" id="email" name="email" autocomplete="off" class="form-control"  required="required">
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
                             <?php
                             $rate = $u->id_rate;
                             foreach($datas->result() as $row):?>
                                 <option value="<?php echo $row->id_rate;?>"
                                   <?php if($rate==$row->id_rate)
                                   {echo "selected";}?>
                                   ><?php echo $row->position;?></option>
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
               <label for="firstName"></label>
              </div>
            </div>
            <div class="col-md-5">
              <div >

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
 			                  <option <?php if($u->user_type=='sa')
												{echo "selected";}?> value="sa">
 			                  Super Admin
 			                  </option>
 			                  <option <?php if($u->user_type=='admin')
												{echo "selected";}?> value="admin">
 			                  Admin
 			                  </option>
 			                  <option <?php if($u->user_type=='staff')
												{echo "selected";}?> value="staff">
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
       <input class="submit center-block btn btn-primary" tabindex="9" value="Update User" type="submit">

         </div>
             </form>

				      <?php echo form_open('crud_user/reset_password', 'id="mydata2" '); ?>
							<input type="hidden" readonly value="<?php echo $u->user_name; ?>"  tabindex="1" id="user_name" name="user_name" class="form-control" autocomplete="off" required="required" data-error="Please enter your kode proyek">
					 <input class="submit center-block btn btn-danger" tabindex="9" value="Reset Password" type="submit">
						 </form>
  <?php } ?> <?php foreach($default ->result() as $row){
		echo "Default Password : ".$row->information_name; }?>
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
