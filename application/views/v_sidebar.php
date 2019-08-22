<div id="wrapper">

  <!-- Sidebar -->
  <ul class="sidebar navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="<?php echo base_url();?>admin">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <!--
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-fw fa-folder"></i>
        <span>Pages</span>
      </a>
      <div class="dropdown-menu" aria-labelledby="pagesDropdown">
        <h6 class="dropdown-header">Login Screens:</h6>
        <a class="dropdown-item" href="login.html">Login</a>
        <a class="dropdown-item" href="register.html">Register</a>
        <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
        <div class="dropdown-divider"></div>
        <h6 class="dropdown-header">Other Pages:</h6>
        <a class="dropdown-item" href="404.html">404 Page</a>
        <a class="dropdown-item" href="blank.html">Blank Page</a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="charts.html">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Charts</span></a>
    </li>

  -->
    <div class="dropdown-divider"></div>
    <?php
    if($this->session->userdata("user_type") == "sa"){ ?>
      <li class="nav-item">

      <a class="nav-link" href="<?php echo base_url();?>admin/setting">
        <i class="fas fa-fw fa-cogs"></i>
        <span>Setting</span></a>
    </li>
    <?php } ?>
    <li class="nav-item active">
      <a class="nav-link">
        <i class="fas fa-fw fa-pen"></i>
        <span>Input Data :</span>
      </a>
    </li>

    <?php
    if($this->session->userdata("user_type") == "sa"){ ?>
        <li class="nav-item">

          <a class="nav-link" href="<?php echo base_url();?>crud_rate">
            <i class="fas fa-fw fa-table"></i>
            <span>Rate</span></a>
        </li>
    <?php } ?>
    <li class="nav-item">

      <a class="nav-link" href="<?php echo base_url();?>crud_project">
        <i class="fas fa-fw fa-table"></i>
        <span>Project</span></a>
    </li>
    <li class="nav-item">

      <a class="nav-link" href="<?php echo base_url();?>crud_expense">
        <i class="fas fa-fw fa-table"></i>
        <span>Expenses</span></a>
    </li>

    <li class="nav-item">

      <a class="nav-link" href="<?php echo base_url();?>crud_payment">
        <i class="fas fa-fw fa-table"></i>
        <span>Payment</span></a>
    </li>
    <li class="nav-item active">
      <a class="nav-link">
        <i class="fas fa-fw fa-database"></i>
        <span>Master Data :</span>
      </a>
    </li>

    <li class="nav-item">

      <a class="nav-link" href="<?php echo base_url();?>crud_project/list_project">
        <i class="fas fa-fw fa-table"></i>
        <span>Project</span></a>
    </li>

    <li class="nav-item">

      <a class="nav-link" href="<?php echo base_url();?>crud_user">
        <i class="fas fa-fw fa-table"></i>
        <span>Employee</span></a>
    </li>
    <li class="nav-item">
      <li class="nav-item">

        <a class="nav-link" href="<?php echo base_url();?>crud_client">
          <i class="fas fa-fw fa-table"></i>
          <span>Client</span></a>
      </li>

    <li class="nav-item active">
      <a class="nav-link">
        <i class="fas fa-fw fa-print"></i>
        <span>Report :</span>
      </a>
    </li>
    <li class="nav-item">

      <a class="nav-link" href="<?php echo base_url();?>report_project">
        <i class="fas fa-fw fa-table"></i>
        <span>Project</span></a>
    </li>




  </ul>
