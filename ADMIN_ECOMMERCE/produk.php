<?php
session_start();
require 'dbconnect.php';

if (isset($_SESSION['login'])) {
  if ((time() - $_SESSION['timer']) > 6000) {
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
            <a href="pesanan.php" class="nav-link ">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Pesanan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="produk.php" class="nav-link active">
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
            <h1 id="id-sub-standar">Data Produk</h1>
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
                <h3 class="card-title">Tabel data Produk</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 140px;">
                    <!-- Button to trigger modal -->
                    <button style="width: 140px;" class="btn btn-success " data-toggle="modal" data-target="#modalForm">
                      Tambah Produk
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="modalForm" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Tambah Produk</h4>
                          </div>

                          <!-- Modal Body -->
                          <div class="modal-body">
                            <p class="statusMsg"></p>
                            <form role="form" action="" method="post" enctype="multipart/form-data">
                              <div class="form-group">
                                <label for="merek">Merek</label>
                                <input type="text" name="merek" class="form-control" id="merek" placeholder="Masukkan merek" />
                              </div>
                              <div class="form-group">
                                <label for="brand">Brand</label>
                                <input type="text" name="brand" class="form-control" id="brand" placeholder="Masukkan brand" />
                              </div>
                              <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <input type="text" name="deskripsi" class="form-control" id="deskripsi" placeholder="Masukkan deskripsi" />
                              </div>
                              <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" name="harga" class="form-control" id="harga" placeholder="Masukkan harga" />
                              </div>
                              <div class="form-group">
                                <label for="diskon">Diskon</label>
                                <input type="number" name="diskon" class="form-control" id="diskon" placeholder="Masukkan diskon" />

                              </div>
                              <div class="form-group">
                                <label for="gambarutama">Gambar Utama</label><br>
                                <input name="gambarutama" type="file" id="gambarutama" required="required" />
                                <p style="color: red">Ekstensi yang diperbolehkan .png</p>
                              </div>
                              <div class="form-group">
                                <label for="gambar360">Gambar 360</label><br>
                                <input name="listGambar[]" type="file" id="gambar360" multiple />
                                <p style="color: red">Sialhkan upload gambar 360 sekaligus, Ekstensi yang diperbolehkan .png</p>
                              </div>
                              <div class="form-group">
                                <label for="uuID">Kode 3D</label>
                                <input type="text" name="uuID" class="form-control" id="uuID" placeholder="Masukkan uuID" />
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <button type="submit" name="tambah" class="btn btn-primary submitBtn">Simpan</button>
                              </div>
                            </form>
                          </div>

                          <!-- Modal Footer -->

                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>EDIT</th>
                      <th>Merek</th>
                      <th>Brand</th>
                      <th>Harga</th>
                      <th>Diskon</th>
                      <th>Url Gambar</th>
                      <th>Kode 3D</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $data = mysqli_query($conn, "select * from PRODUK");
                    while ($d = mysqli_fetch_array($data)) {
                    ?>
                      <tr>
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
                                      <input name="idProduk" type="text" class="form-control" value="<?php echo $d['ID']; ?>">
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleFormControlInput1">Brand</label>
                                      <input name="brand" type="text" class="form-control" value="<?php echo $d['BRAND']; ?>">
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleFormControlTextarea1">Merek</label>
                                      <input name="merek" type="text" class="form-control" value="<?php echo $d['MEREK']; ?>">
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleFormControlInput1">Harga</label>
                                      <input name="harga" type="text" class="form-control" value="<?php echo $d['HARGA']; ?>">
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleFormControlInput1">Diskon</label>
                                      <input name="diskon" type="text" class="form-control" value="<?php echo $d['DISKON']; ?>">
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleFormControlInput1">Url Gambar</label>
                                      <input name="urlGambar" type="text" class="form-control" value="<?php echo $d['GAMBAR']; ?>">
                                    </div>
                                    <div class="form-group">
                                      <label for="exampleFormControlInput1">Kode 3D</label>
                                      <input name="uuID" type="text" class="form-control" value="<?php echo $d['lensUUID']; ?>">
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
                        <td><?php echo $d['MEREK']; ?></td>
                        <td><?php echo $d['BRAND']; ?></td>
                        <td><?php echo $d['HARGA']; ?></td>
                        <td><?php echo $d['DISKON']; ?></td>
                        <td><?php echo $d['GAMBAR']; ?></td>
                        <td><?php echo $d['lensUUID']; ?></td>
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
    <strong>Copyright &copy; AK49 2023 <a href="index.php">AK49</a>.</strong> All rights reserved.
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
if (isset($_POST["tambah"])) {
  $merek = $_POST['merek'];
  $brand = $_POST['brand'];
  $deskripsi = $_POST['deskripsi'];
  $harga = $_POST['harga'];
  $diskon = $_POST['diskon'];
  $lensUUID = $_POST['uuID'];
  $temp = ('../image/' . $merek);
  if (!file_exists($temp))
    mkdir($temp, 0777, $rekursif = true);

  $rand = rand();
  $ekstensi =  array('png');
  $fileupload = $_FILES['gambarutama']['tmp_name'];
  $filename = $_FILES['gambarutama']['name'];
  $ukuran = $_FILES['gambarutama']['size'];

  $jumlahFile = count($_FILES['listGambar']['name']);
  $ext = pathinfo($filename, PATHINFO_EXTENSION);

  if (!in_array($ext, $ekstensi)) {
    echo "<script>
          alert('Data Gagal di simpan ukuran file extensi salah');
        </script>";
  } else {
    if ($ukuran < 1044070) {
      if (!empty($fileupload)) {
        for ($i = 0; $i < $jumlahFile; $i++) {
          $namaFile = $_FILES['listGambar']['name'][$i];
          $lokasiTmp = $_FILES['listGambar']['tmp_name'][$i];
          $namaBaru = $namaFile;
          $lokasiBaru = "{$temp}/{$namaBaru}";
          $prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);
        }

        $url = 'https://voltaic-nebula-393108.et.r.appspot.com/' . 'image' . '/' . $merek . '/' . $filename;
        move_uploaded_file($_FILES['gambarutama']['tmp_name'], $temp . '/' . $filename);
        mysqli_query($conn, "INSERT INTO produk (ID, MEREK, BRAND, DESKRIPSI, HARGA, DISKON, GAMBAR, lensUUID)
        VALUES (NULL,'$merek','$brand','$deskripsi','$harga','$diskon','$url','$lensUUID')");
        echo "<script>
          alert('Data berhasil di simpan');
          window.location.href=window.location.href;
        </script>";
      }
    } else {
      echo "<script>
          alert('Data Gagal di simpan ukuran file terlalu besar');
        </script>";
    }
  }
}
?>

<?php
if (isset($_POST['simpan'])) {
  //$ukuran = $_POST['ukuran'];
  $idProduk = $_POST['idProduk'];
  $brand = $_POST['brand'];
  $merek = $_POST['merek'];
  $harga = $_POST['harga'];
  $diskon = $_POST['diskon'];
  $urlGambar = $_POST['urlGambar'];
  $lensUUID = $_POST['uuID'];
  // masukkan data ke database
  $query = "UPDATE PRODUK set BRAND = '$brand',MEREK ='$merek', HARGA = '$harga', DISKON = '$diskon', GAMBAR ='$urlGambar', lensUUID='$lensUUID' WHERE ID='$idProduk'";
  $update = mysqli_query($conn, $query);
  if ($update) {
    echo "<script>
          alert('Data berhasil di simpan');
          window.location.href=window.location.href;
        </script>";
  } else {
    echo "<script>
          alert('Data Gagal di simpan');
        </script>";
  }
}
?>