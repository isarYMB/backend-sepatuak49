<?php

session_start();
require 'dbconnect.php';

if (isset($_SESSION['login'])) {
  if ((time() - $_SESSION['timer']) > 60000) {
    unset($_SESSION['login']);
    session_destroy();
    header('Location: login.php');
  }
}

if (isset($_POST['logout'])) {
  unset($_SESSION['login']);
  session_destroy();
  header('Location: login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin AK49</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- CKEditor -->
  <script src="ckeditor/ckeditor.js"></script>
  <style>
    .submenuaktif {
      background: #DDD;
      color: #000;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Hamburger Button Menu -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- SIGN BUTTON -->
      <li class="nav-item">
        <form action="" method="post">
          <button class="nav-link" type="submit" name="logout" style="border: none; background-color: transparent;">
            <i class="nav-icon fas fa-sign-in-alt"></i>
          </button>
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- ASIDE CONTENT -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- LOGO SITEBOT -->
    <a href="index.php" class="brand-link">
      <img src="dist/img/profile.png" alt="AdminLTE Logo" class="brand-image img-circl e">
      <span class="brand-text font-weight-bold">Admin AK49</span>
    </a>

    <!-- SIDEBAR -->
    <div class="sidebar">

      <!-- NAVIGASI MENU -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <!-- HOME MENU -->
          <li class="nav-item">
            <a href="pesanan.php" class="nav-link active">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Pesanan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="produk.php" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Produk
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pelanggan.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Pelanggan
              </p>
            </a>
          </li>

        </ul>
        <!-- /.NAVIGASI MENU -->
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>






  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="container">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 id="id-sub-standar">Data Pesanan</h1>
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tabel data pesanan</h3>
                <div class="card-tools">
                  <form action="" method="post">
                    <div class="input-group input-group-sm" style="width: 150px;">

                      <select name="filter" class="form-control float-right">
                        <option value="0">Semua</option>
                        <option value="1">Pendataan</option>
                        <option value="2">Packaging</option>
                        <option value="3">Pengiriman</option>
                        <option value="4">Selesai</option>
                      </select>
                      <div class="input-group-append">
                        <button name="cari" type="submit" class="btn btn-default">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>User</th>
                      <th>Produk</th>
                      <th>Ukuran</th>
                      <th>Jumlah</th>
                      <th>Total</th>
                      <th>Status</th>
                      <th>Verifikasi</th>
                      <th>Edit</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($_POST['cari'])) {
                      $filter = $_POST['filter'];
                      if ($filter == 0) {
                        $data = mysqli_query($conn, "select * from PESANAN");
                      } elseif ($filter == 1) {
                        $data = mysqli_query($conn, "select * from PESANAN where STATUS = 1");
                      } elseif ($filter == 2) {
                        $data = mysqli_query($conn, "select * from PESANAN where STATUS = 2");
                      } elseif ($filter == 3) {
                        $data = mysqli_query($conn, "select * from PESANAN where STATUS = 3");
                      } elseif ($filter == 4) {
                        $data = mysqli_query($conn, "select * from PESANAN where STATUS = 4");
                      }
                    } else {
                      $data = mysqli_query($conn, "select * from PESANAN");
                    }
                    while ($d = mysqli_fetch_array($data)) {
                    ?>
                      <?php $idS = $d['ID_USER']; ?>
                      <?php $idP = $d['ID_PRODUK']; ?>
                      <tr>
                        <td><?php echo $d['ID']; ?></td>
                        <td><?php $data2 = mysqli_query($conn, "select * from USERS where id=$idS");
                            $c = mysqli_fetch_array($data2);
                            echo $c["NAMA_DEPAN"]; ?></td>
                        <td><?php $data3 = mysqli_query($conn, "select * from PRODUK where id=$idP");
                            $b = mysqli_fetch_array($data3);
                            echo $b["MEREK"]; ?></td>
                        <td><?php echo $d['UKURAN_SEPATU']; ?></td>
                        <td><?php echo $d['JUMLAH_PESANAN']; ?></td>
                        <td><?php echo $d['TOTAL_PESANAN']; ?></td>
                        <td><?php $status = $d['STATUS'];
                            if ($status == 1) {
                              echo "Pendataan";
                            } elseif ($status == 2) {
                              echo "Packaging";
                            } elseif ($status == 3) {
                              echo "Pengiriman";
                            } else {
                              echo "Selesai";
                            } ?></td>
                        <td><?php $verifikasi = $d['VERIFIKASI'];
                            if ($verifikasi == 1) {
                              echo "Belum di verifikasi";
                            } else {
                              echo "Telah di verifikasi";
                            } ?></td>
                        <td>
                          <!-- membuat tombol dengan ukuran small berwarna biru  -->
                          <!-- data-target setiap modal harus berbeda, karena akan menampilkan data yang berbeda pula
                                                    caranya membedakannya, gunakan id_barang sebagai pembeda data-target di setiap modal -->
                          <a href="" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal<?php echo $d['ID']; ?>">Edit</a>

                          <!-- untuk melihat bentuk-bentuk modal kalian bisa mengunjungi laman bootstrap dan cari modal di kotak pencariannya -->
                          <!-- id setiap modal juga harus berbeda, cara membedakannya dengan menggunakan id_barang -->
                          <div class="modal fade" id="modal<?php echo $d['ID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Edit Pesanan</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <!-- di dalam modal-body terdapat 4 form input yang berisi data.
                                                                data-data tersebut ditampilkan sama seperti menampilkan data pada tabel. -->
                                <div class="modal-body">
                                  <form action="" method="post">
                                    <div class="form-group">
                                      <label for="exampleFormControlInput1">ID </label>
                                      <input name="idPesanan" type="text" class="form-control" value="<?php echo $d['ID']; ?>">
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleFormControlInput1">Status</label>
                                      <select name="status" id="status" class="form-control">
                                        <?php
                                        if ($d['STATUS'] == 1) { ?>
                                          <option value="1" selected>Pendataan</option>
                                          <option value="2">Packaging</option>
                                          <option value="3">Pengiriman</option>
                                          <option value="4">Selesai</option>
                                        <?php } elseif ($d['STATUS'] == 2) { ?>
                                          <option value="2" selected>Packaging</option>
                                          <option value="1">Pendataan</option>
                                          <option value="3">Pengiriman</option>
                                          <option value="4">Selesai</option>
                                        <?php } elseif ($d['STATUS'] == 3) { ?>
                                          <option value="3" selected>Pengiriman</option>
                                          <option value="2">Packaging</option>
                                          <option value="1">Pendataan</option>
                                          <option value="4">Selesai</option>
                                        <?php } else { ?>
                                          <option value="4" selected>Selesai</option>
                                          <option value="3">Pengiriman</option>
                                          <option value="2">Packaging</option>
                                          <option value="1">Pendataan</option>
                                        <?php } ?>
                                      </select>
                                      <br>
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleFormControlTextarea1">Verifikasi</label>
                                      <select name="verifikasi" id="verifikasi" class="form-control">
                                        <?php
                                        if ($d['VERIFIKASI'] == 1) { ?>
                                          <option value="1" selected>Belum di verifikasi</option>
                                          <option value="2">Telah di verifikasi</option>

                                        <?php } elseif ($d['VERIFIKASI'] == 2) { ?>
                                          <option value="2" selected>Telah di verifikasi</option>
                                          <option value="1">Belum di verifikasi</option>
                                        <?php } ?>
                                      </select>
                                    </div>
                                    <div class="modal-footer form-group">
                                      <button name="simpan" type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>

                        </td>
                        <!-- <td><button><i class="nav-icon fas fa-edit"></i></button></td> -->
                      </tr>
                    <?php
                    }

                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div>
    </section>
    <!-- /.row -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.1.0-pre
    </div>
    <strong>Copyright &copy; AK49 2021<a href="index.php">AK49</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- KUMPULAN SCRIPT -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>
  <!-- script ajax -->

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
  </script>
</body>

</html>
<?php
if (isset($_POST['simpan'])) {
  //$ukuran = $_POST['ukuran'];
  $idPesanan = $_POST['idPesanan'];
  $status = $_POST['status'];
  $verifikasi = $_POST['verifikasi'];
  // masukkan data ke database
  $query = "UPDATE PESANAN set STATUS = '$status',VERIFIKASI ='$verifikasi' WHERE ID='$idPesanan'";
  $update = mysqli_query($conn, $query);
  if ($update) {
    echo "<script>
          alert('Data berhasil di simpan');
          window.location.href=window.location.href;
        </script>";
    // header('Location: index.php');
  } else {
    echo "<script>
          alert('Data Gagal di simpan');
        </script>";
  }
}
?>