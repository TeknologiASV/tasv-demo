<?php
//require_once 'php/db_connect.php';

session_start();
$role = 'NORMAL';

if(!isset($_SESSION['userID'])){
  echo '<script type="text/javascript">';
  echo 'window.location.href = "login.html";</script>';
}
else{
  $role = $_SESSION['role'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>T-ASV Demo | Dashboard</title>

  <link rel="icon" href="images/logo.png" type="image">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="loading" id="spinnerLoading">
<div class='uil-ring-css' style='transform:scale(0.79);'>
    <div></div>
</div>
</div>
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: white;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link logo-switch" style="line-height: 2.5;">
      <img src="images/logo.png" alt="T-ASV Logo" class="brand-image-xl logo-xs" style="left: 10%;width: 70%;max-height: 100%;">
      <img src="images/logoBig.png" alt="T-ASV Logo" class="brand-image-xl logo-xl" style="left: 15%;width: 50%;top: 0px;max-height: 100%;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" id="sideMenu" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-is-opening menu-open">
            <a href="#" class="nav-link" style="color: black;">
              <i class="nav-icon fas fa-store"></i>
              <p>Retail<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview" style="display: block;">
              <li class="nav-item">
                <a href="#home" data-file="home.html" class="nav-link link active" style="color: black;">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Conversion</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#1utama" data-file="1utama.html" class="nav-link link" style="color: black;">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Entrance Counting</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#damansara" data-file="damansara.html" class="nav-link link" style="color: black;">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Zone Activity</p>
                </a>
              </li>
              <?php
                if($role == 'ADMIN'){
                  echo '<li class="nav-item">
                  <a href="#transaction" data-file="transaction.html" class="nav-link link" style="color: black;">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Transaction</p>
                  </a>
                </li>';
                }
              ?>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" style="color: black;">
              <i class="nav-icon fas fa-road"></i>
              <p>Street<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#jonker" data-file="jonker.html" class="nav-link link" style="color: black;">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Junction</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#merah" data-file="merah.html" class="nav-link link" style="color: black;">
                  <i class="nav-icon far fa-circle"></i>
                  <p>Tourist Zone</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#pasar" data-file="pasar.html" class="nav-link link" style="color: black;">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vehicle Counting</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" style="color: black;">
              <i class="nav-icon fas fa-crop"></i>
              <p>Agriculture<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#feldashboard" data-file="dashboard.html" class="nav-link link" style="color: black;">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#tracking" data-file="tracking.html" class="nav-link link" style="color: black;">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tracking</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" style="color: black;">
              <i class="nav-icon fas fa-map"></i>
              <p>Highway<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#ijm" data-file="ijm.html" class="nav-link link" style="color: black;">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#fallDetection" data-file="fall.html" class="nav-link link" style="color: black;">
              <i class="nav-icon fas fa-shoe-prints"></i>
              <p>Fall Detection</p>
            </a>
          </li>
          <!--li class="nav-item">
            <a href="#vehiclecounting" data-file="vehiclecounting.html" class="nav-link link" style="color: black;">
              <i class="nav-icon fas fa-car"></i>
              <p>Vehicle Counting</p>
            </a>
          </li-->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link" style="color: black;">
              <i class="nav-icon fas fa-cogs"></i>
              <p>Settings<i class="fas fa-angle-left right"></i></p>
            </a>
        
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="#myprofile" data-file="myprofile.php" class="nav-link link" style="color: black;">
                  <i class="nav-icon fas fa-id-badge"></i>
                  <p>Profile</p>
                </a>
              </li>
          
              <li class="nav-item">
                <a href="#changepassword" data-file="changePassword.html" class="nav-link link" style="color: black;">
                  <i class="nav-icon fas fa-key"></i>
                  <p>Change Password</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="php/logout.php" class="nav-link" style="color: black;">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="mainContents"></div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2022 <a href="https://www.t-asv.com">TASV</a>.</strong>All rights reserved.
    <div class="float-right d-none d-sm-inline-block"><b>Version</b> 1.0.0</div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>
<!-- OPTIONAL SCRIPTS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<!-- date-range-picker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard3.js"></script>
<script src="plugins/heatmap/build/heatmap.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjjbv6izl-JmncmbItl_S2_6OetztzjF8"></script>
<script>
var ouStartDate = "";
var ouEndDate = "";
var ouStartTime = "";
var ouEndTime = "";

$(function () {
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }

  $('#sideMenu').on('click', '.link', function(){
      $('#spinnerLoading').hide();
      var files = $(this).attr('data-file');
      $('#sideMenu').find('.active').removeClass('active');
      $(this).addClass('active');
      
      $.get(files, function(data) {
        $('#mainContents').html(data);
        $('#spinnerLoading').hide();
      });
  });

  $('#goToProfile').on('click', function(){
      $('#spinnerLoading').show();
      var files = $(this).attr('data-file');
      $('#sideMenu').find('.active').removeClass('active');
      $(this).addClass('active');
      
      $.get(files, function(data) {
          $('#mainContents').html(data);
          $('#spinnerLoading').hide();
      });
  });
  
  $("a[href='#home']").click();
});

// Melaka one
function addDataM(chart, label, data) {
  chart.data.labels.push(label);
  chart.data.datasets.forEach((dataset) => {
    dataset.data.push(data);
  });
  chart.update();
}

function addStackChartDataM(chart, label, data, data2, data3, data4, data5, data6) {
  chart.data.labels.push(label);
  chart.data.datasets[0].data.push(data);
  chart.data.datasets[1].data.push(data2);
  chart.data.datasets[2].data.push(data3);
  chart.data.datasets[3].data.push(data4);
  chart.data.datasets[4].data.push(data5);
  chart.data.datasets[5].data.push(data6);
  chart.update();
}

function addStackChartData2M(chart, label, data, data2, data3, data4) {
  chart.data.labels.push(label);
  chart.data.datasets[0].data.push(data);
  chart.data.datasets[1].data.push(data2);
  chart.data.datasets[2].data.push(data3);
  chart.data.datasets[3].data.push(data4);
  chart.update();
}

function addBarChartDataM(chart, label, data) {
  chart.data.labels.push(label);
  chart.data.datasets[0].data.push(data);
  chart.update();
}

function addLineChartDataM(chart, label, data, data2) {
  chart.data.labels.push(label);
  chart.data.datasets[0].data.push(data);
  chart.data.datasets[1].data.push(data2);
  chart.update();
}

function removeDataM(chart) {
  while(chart.data.labels.length > 0){
    chart.data.labels.pop();
  }

  chart.data.datasets.forEach((dataset) => {
    dataset.data = [];
  });
  chart.update();
}

// Uniqlo
function addDataU(chart, label, data) {
  chart.data.labels.push(label);
  chart.data.datasets.forEach((dataset) => {
    dataset.data.push(data);
  });
  chart.update();
}

function addStackChartDataU(chart, label, data, data2, data3, data4, data5, data6, data7, data8, data9) {
  chart.data.labels.push(label);
  chart.data.datasets[0].data.push(data);
  chart.data.datasets[1].data.push(data2);
  chart.data.datasets[2].data.push(data3);
  chart.data.datasets[3].data.push(data4);
  chart.data.datasets[4].data.push(data5);
  chart.data.datasets[5].data.push(data6);
  chart.data.datasets[6].data.push(data7);
  chart.data.datasets[7].data.push(data8);
  chart.data.datasets[8].data.push(data9);
  chart.update();
}

function addBarChartDataU(chart, label, data) {
  chart.data.labels.push(label);
  chart.data.datasets[0].data.push(data);
  chart.update();
}

function addLineChartDataU(chart, label, data, data2) {
  chart.data.labels.push(label);
  chart.data.datasets[0].data.push(data);
  chart.data.datasets[1].data.push(data2);
  chart.update();
}

function removeDataU(chart) {
  while(chart.data.labels.length > 0){
    chart.data.labels.pop();
  }

  chart.data.datasets.forEach((dataset) => {
    dataset.data = [];
  });
  chart.update();
}

// Felda
function addDataF(chart, label, data) {
  chart.data.labels.push(label);
  chart.data.datasets.forEach((dataset) => {
    dataset.data.push(data);
  });
  chart.update();
}

function addStackChartDataF(chart, label, data, data2, data3, data4, data5, data6, data7, data8, data9) {
  chart.data.labels.push(label);
  chart.data.datasets[0].data.push(data);
  chart.data.datasets[1].data.push(data2);
  chart.data.datasets[2].data.push(data3);
  chart.data.datasets[3].data.push(data4);
  chart.data.datasets[4].data.push(data5);
  chart.data.datasets[5].data.push(data6);
  chart.data.datasets[6].data.push(data7);
  chart.data.datasets[7].data.push(data8);
  chart.data.datasets[8].data.push(data9);
  chart.update();
}

function addBarChartDataF(chart, label, data, data2) {
  chart.data.labels.push(label);
  chart.data.datasets[0].data.push(data);
  chart.data.datasets[1].data.push(data2);
  chart.update();
}

function addLineChartDataF(chart, label, data, data2, data3) {
  chart.data.labels.push(label);
  chart.data.datasets[0].data.push(data);
  chart.data.datasets[1].data.push(data2);
  chart.data.datasets[2].data.push(data3);
  chart.update();
}

function removeDataF(chart) {
  while(chart.data.labels.length > 0){
    chart.data.labels.pop();
  }

  chart.data.datasets.forEach((dataset) => {
    dataset.data = [];
  });
  chart.update();
}

// IJM
function addDataI(chart, label, data) {
  chart.data.labels.push(label);
  chart.data.datasets.forEach((dataset) => {
    dataset.data.push(data);
  });
  chart.update();
}

function addStackChartDataI(chart, label, data, data2, data3, data4) {
  chart.data.labels.push(label);
  chart.data.datasets[0].data.push(data);
  chart.data.datasets[1].data.push(data2);
  chart.data.datasets[2].data.push(data3);
  chart.data.datasets[3].data.push(data4);
  chart.update();
}

function removeDataI(chart) {
  while(chart.data.labels.length > 0){
    chart.data.labels.pop();
  }

  chart.data.datasets.forEach((dataset) => {
    dataset.data = [];
  });
  chart.update();
}

// General
function formatDate(date) {
  var d = new Date(date),
  month = '' + (d.getMonth() + 1),
  day = '' + d.getDate(),
  year = d.getFullYear();

  if (month.length < 2) 
    month = '0' + month;

  if (day.length < 2) 
    day = '0' + day;

  return [year, month, day].join('-');
}

function report(type){
  if(type == 'passedingroundmonthly' || type =='passedinlvl1monthly' || type =='groundlvl1monthly' || type =='dastotalvisitorsmonthly' || type =='dastotalzonevisitorsmonthly'){
    window.open("php/export.php?fromDate="+ouStartDate+"&toDate="+ouEndDate+"&type="+type);
  }
  else if(type == 'passedingrounddaily' || type =='passedinlvl1daily' || type =='groundlvl1daily' || type =='dastotalvisitorsdaily' || type =='dastotalzonevisitorsdaily'){
    window.open("php/export.php?fromDate="+ouStartTime+"&toDate="+ouEndTime+"&type="+type);
  }
}
</script>
</body>
</html>
