<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Login</title>

    <!-- Bootstrap core CSS-->
    <link href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url();?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url();?>assets/css/sb-admin.css" rel="stylesheet">

  </head>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Password Change</div>
        <div class="card-body">
          <div id="info"></div>
          	<?php echo $this->session->flashdata('msg');?>
        <form id="mydata" method="post" action="<?php echo base_url('login/update_password'); ?>" role="login">
            
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" name="password" id="password" class="form-control"  required="required">
                <label for="inputPassword">New Password</label>
              </div>
            </div>

            <div class="form-group">
              <div class="form-label-group">
                <input type="password" name="comfirm_password"id="comfirm_password" class="form-control"  required="required">
                <label for="inputPassword">Comfirm New Password</label>
              </div>
            </div>


						<button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Change Password</button>
          </form>

        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

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
                window.location.href ="<?php echo base_url();?>";
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

</html>
