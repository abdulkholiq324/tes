<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "perpustakaan";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$name        = "";
$category_id = "";
$writer_id   = "";
$publication_year   = "";
$img         = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
  $op = $_GET['op'];
} else {
  $op = "";
}

if (isset($_POST['simpan-category'])) { //untuk create
  $name        = $_POST['name'];

  if ($name) {
      if ($op == 'edit') { //untuk update
          $sql1       = "update category_tb set name = '$name' where id = '$id'";
          $q1         = mysqli_query($koneksi, $sql1);
          if ($q1) {
              $sukses = "Data berhasil diupdate";
          } else {
              $error  = "Data gagal diupdate";
          }
      } else { //untuk insert
          $sql1   = "insert into category_tb(name) values ('$name')";
          $q1     = mysqli_query($koneksi, $sql1);
          if ($q1) {
              $sukses     = "Berhasil memasukkan data baru";
          } else {
              $error      = "Gagal memasukkan data";
          }
      }
  } else {
      $error = "Silakan masukkan semua data";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Tugas Bootcamp</title>
</head>
<body>
  <div class="container-fluid">
    <h1>Perpustakaan</h1>
    <div style="background-color:#00cccc; padding: 5px;">
      <h2 style="margin-top:10px !important;"><strong>Daftar Buku<strong></h2>
    </div>  
    <div class="container">
      <div style="padding: 10px; display: flex; justify-content: end; ">
        <button type="button" class="btn btn-success">Tambah</button>
      </div>
      <?php
        $sql2   = "select * from book_tb order by id desc";
        $q2     = mysqli_query($koneksi, $sql2);
        $urut = 1;
        while ($r2 = mysqli_fetch_array($q2)) {
          $id         = $r2['id'];
          $name        = $r2['name'];
          $category_id       = $r2['category_id'];
          $writer_id     = $r2['writer_id'];
          $publication_year   = $r2['publication_year'];
      ?>
      <div class="row">
        <div class="col-sm-3" style="background-color:white;">
          <!-- <?php echo $urut++ ?> -->
          <div class="card" style="width: 100%;">
          <div class="card-image" style="align-items:center; display: flex; flex-direction: column; padding:10px;">
            <?php echo '<img class="bd-placeholder-img card-img-top" height="180" src="data:image/jpeg;base64,'.base64_encode( $r2['img'] ).'"/>'; ?>
          </div>
          <div class="card-body" style="padding: 10px 0px;">
            <div class="col-sm-12"><strong>Judul Buku :<?php echo $name ?></strong></div>
            <div class="col-sm-12"><strong>Nama Penulis :
              <?php
              $sql3   = "select * from writer_tb where id='$writer_id'";
              $q3     = mysqli_query($koneksi, $sql3);
              foreach ($q3 as $rows) {
                foreach($rows as $key => $val){
                    echo "$val";
                }
              }
                ?></strong></div>
                
            <div class="col-sm-12">Tahun Terbit :<?php echo $publication_year; ?></div>
          </div>
          <div class="card-body">
            <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
            <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a> 
          </div>
        </div>
      </div>
      <?php
          }
        ?>
    </div>
  </div>
  <!-- Daftar Category -->
  <div style="background-color:#00cccc; padding: 5px;">
    <h2 style="margin-top:10px !important;"><strong>Daftar Category<strong></h2>
  </div>
  <div class="container">
    <div class="card-body">
      <div style="padding: 10px; display: flex; justify-content: end; ">
        <button type="button" class="btn btn-success">Tambah</button>
      </div>
      <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Category</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
          $sql2   = "select * from category_tb order by id desc";
          $q2     = mysqli_query($koneksi, $sql2);
          $urut = 1;
          while ($r2 = mysqli_fetch_array($q2)) {
            $id         = $r2['id'];
            $name        = $r2['name'];
        ?>
        <tr>
          <th scope="row"><?php echo $urut++ ?></th>
          <td scope="row"><?php echo $name ?></td>
          <td scope="row">
              <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
              <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
          </td>
        </tr>
        <?php
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- Daftar Penulis -->
  <div style="background-color:#00cccc; padding: 5px;">
    <h2 style="margin-top:10px !important;"><strong>Daftar Penulis<strong></h2>
  </div>
  <div class="container">
    <div class="card-body">
      <div style="padding: 10px; display: flex; justify-content: end; ">
        <button type="button" class="btn btn-success">Tambah</button>
      </div>
      <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Penulis</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
          $sql2   = "select * from writer_tb order by id desc";
          $q2     = mysqli_query($koneksi, $sql2);
          $urut = 1;
          while ($r2 = mysqli_fetch_array($q2)) {
            $id         = $r2['id'];
            $name        = $r2['name'];
        ?>
        <tr>
          <th scope="row"><?php echo $urut++ ?></th>
          <td scope="row"><?php echo $name ?></td>
          <td scope="row">
              <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
              <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
          </td>
        </tr>
        <?php
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
    <script type="text/javascript">
    </script>
</body>
</html>