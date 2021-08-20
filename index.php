<?php
$host    = "localhost";
$user    = "root";
$pass    = "";
$db      = "akademik";

$koneksi = mysqli_connect($host,$user,$pass,$db);
if(!$koneksi){//cek koneksi
    die("tidak bisa terkoneksi ke database");
}
$nim      = "";
$nama     = "";
$alamat   = "";
$fakultas = "";
$sukses   = "";
$error    = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete * from mahasiswa where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "berhasil hapus data";
    }else {
        $error  = "gagal melakukan delete data";
    }
}

if($op == 'edit'){
    $id       = $_GET['id'];
    $sql1     = "select * from mahasiswa where id = '$id'";
    $q1       = mysqli_query($koneksi,$sql1);
    $r1       = mysqli_fetch_array($q1);
    $nim      = $r1['nim'];
    $nama     = $r1['nama'];
    $alamat   = $r1['alamat'];
    $fakultar = $r1['fakultas'];

    if($nim == ''){
        $error = "Data Tidak Ditemukan";
    }
}

if(isset($_POST['simpan'])){//untuk create
 $nim      = $_POST['nim'];
 $nama     = $_POST['nama'];
 $alamat   = $_POST['alamat'];
 $fakultas = $_POST['fakultas'];

 if($nim && $nama && $alamat && $fakultas){
     if($op == 'edit'){//untuk update
         $sql1      = "update mahasiswa set nim = '$nim',nama='$nama',alamat = '$alamat',fakultas = '$fakultas' where id = '$id'";
         $q1        = mysqli_query($koneksi,$sql1);
         if($q1){
             $sukses = "Data berhasil diupdate";
         }else{
             $error  = "Data gagal diupdate";
         }
     }else{//untuk insert
        $sql1 = "insert into mahasiswa(nim,nama,alamat,fakultas) values ('$nim','$nama','$alamat','$fakultas')";
        $q1   = mysqli_query($koneksi,$sql1);
        if($q1){
            $sukses    = "Berhasil Memasukkan Data Baru";
        }else {
            $error     = "Gagal Memasukkan Data";
        }   
     }
  $sql1 = "insert into mahasiswa(nim,nama,alamat,fakultas) values ('$nim','$nama','$alamat','$fakultas')";
  $q1   = mysqli_query($koneksi,$sql1);
  if($q1){
      $sukses    = "Berhasil Memasukkan Data Baru";
  }else {
      $error     = "Gagal Memasukkan Data";
  }
 }else{
     $error = "Silahkan Masukkan Semua Data";
 }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <style>
        .mx-auto {widht:800px}
        .card {margin-top: 10px;}
    </style>
</head>
<body>
   <div class="mx-auto">
    <!-- untuk memasukkan data -->
   <div class="card">
  <div class="card-header">
    create / Edit Data
  </div>
  <div class="card-body">
      <?php
      if($error){
         ?>
         <div class="alert alert-danger" role="alert">
          <?php echo $error ?>
</div>
         <?php
         header("refresh:5;url=index.php");
      }
      ?>
      <?php
      if($sukses){
         ?>
         <div class="alert alert-success" role="alert">
          <?php echo $sukses ?>
</div>
         <?php
      }
      ?>
   <form action="" method="post">
   <div class="mb-3 row">
    <label for="nim" class="col-sm-2 col-form-label">Nim</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="fakultas" class="col-sm-2 col-form-label">Fakultas</label>
    <div class="col-sm-10">
     <select class="form-contro" name="fakultas" id="fakultas">
         <option value="">Pilih Fakultas -</option>
         <option value="kedokteran" <?php if($fakultas == "kedokteran") echo "selected"?>>kedokteran</option>
         <option value="soshum" <?php if($fakultas == "soshum") echo "selected"?>>soshum</option>
         <option value="sospol" <?php if($fakultas == "sospol") echo "selected"?>>sospol</option>
         <option value="saintek"<?php if($fakultas == "saintek") echo "selected"?> >saintek</option>
     </select>
    </div>
  </div>
  <div class="col-12">
      <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
  </div>
   </form>
  </div>
</div>
<!-- untuk mengeluarkan data -->
<div class="card">
  <div class="card-header text-white bg-secondary">
    Data Mahasiswa
  </div>
  <div class="card-body">
   <table class="table">
       <thead>
           <tr>
               <th scope="col">#</th>
               <th scope="col">Nim</th>
               <th scope="col">Nama</th>
               <th scope="col">Alamat</th>
               <th scope="col">fakultas</th>
               <th scope="col">Aksi</th>
           </tr>
           <tbody>
               <?php
               $sql2   = "select * from mahasiswa order by id desc";
               $q2     = mysqli_query($koneksi,$sql2);
               $urut   = 1;
               while($r2 = mysqli_fetch_array($q2)){
                   $id       = $r2['id'];
                   $nim      = $r2['nim'];
                   $nama     = $r2['nama'];
                   $alamat   = $r2['alamat'];
                   $fakultas = $r2['fakultas'];

                   ?>
                   <tr>
                       <th scope="row"><?php echo $urut++ ?></th>
                       <td scope="row"><?php echo $nim ?></td>
                       <td scope="row"><?php echo $nama ?></td>
                       <td scope="row"><?php echo $alamat ?></td>
                       <td scope="row"><?php echo $fakultas ?></td>
                       <td scope="row">
                           <a href="index.php?op=Edit&id=<?php echo $id?> "><button type="button" class="btn btn-warning">Edit</button></a>
                           <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                       
                       
                       </td>
                   </tr>
                   <?php
               }
               ?>
           </tbody>
       </thead>
   </table>
  </div>
</div>
   </div> 
</body>
</html>