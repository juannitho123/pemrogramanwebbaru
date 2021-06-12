<?php
$host ="localhost";
$user ="root";
$pass ="";
$db   ="db_akademik";

$koneksi		= mysqli_connect($host,$user,$pass,$db);
if(!$koneksi){ // cek koneksi
	die("Tidak bisa terkoneksi ke data base");
}
$nim	 	  	="";		
$nama		    ="";
$jurusan   	="";
$alamat 		="";
$sukses			="";
$error			="";

if(isset($_GET['op'])){
  $op = $_GET ['op'];
}else{
  $op = "";
}
if($op == 'delete'){
  $id         = $_get['id'];
  $sql1       ="delete from mahasiswa where id = '$id'";
  $q1         = mysqli_query($koneksi,$sql1);
  if($q1){
    $sukses = "Berhasil menghapus data";
  }else{
    $error  = "Gagal melakukan delete data";
  }
}

if($op == 'edit'){
  $id       = $_GET['id'];
  $sql1     = "select * from mahasiswa where id = '$id'";
  $q1       = mysqli_query($koneksi,$sql1);
  $r1       = mysqli_fetch_array($q1);
  $nim			= $r1['nim'];
	$nama			= $r1['nama'];
	$jurusan	= $r1['jurusan'];
  $alamat		= $r1['alamat']; 
  
  if($nim ==''){
    $error = "Data tidak ditemukan";
  }
}

if(isset($_POST['simpan'])){ // untuk create
	$nim			= $_POST['nim'];
	$nama			= $_POST['nama'];
	$jurusan	= $_POST['jurusan'];
	$alamat		= $_POST['alamat'];

	if($nim && $nama && $jurusan && $alamat){
    if($op == 'edit'){// untuk update
      $sql1   = "update mahasiswa set nim = '$nim' ,nama ='$nama' ,jurusan = '$jurusan' ,alamat = '$alamat' where id = '$id' ";
      $q1     = mysqli_query($koneksi,$sql1);
      if($q1){
        $sukses = "Data berhasil diupdate";
      }else{
        $error = "Data gagal diupdate";
      }
      }else{//untuk insert
       $sql1 	= "insert into mahasiswa(nim,nama,jurusan,alamat) values ('$nim','$nama','$jurusan','$alamat')";
		$q1		= mysqli_query($koneksi,$sql1);
		if($q1){
			$sukses		= "Berhasil memasukan data baru";
		}else{
			$error 		= "Gagal memasukan data";
		}
   }
	}else{
		$error = "Silahkan masukkan semua data";
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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <style>
        .mx-auto {width: 800px}
		.card {margin-top: 10px}
	</style>
</head>
<body>
	<div class="mx-auto">
	<!-- untuk memasukan data -->
	<div class="card">
  <div class="card-header">
    Create / Edit Data
  </div>
  <div class="card-body">
  <?php
  if($error){
	  ?>
       <div class="alert alert-danger" role="alert">
 <?php echo $error ?>
</div>
	  <?php
    header("refresh:5;url=index.php");//5detik
  }
  ?>
  <?php
  if($sukses){
	  ?>
       <div class="alert alert-sukses" role="alert">
 <?php echo $sukses ?>
</div>
	  <?php
    header("refresh:5;url=index.php");
  }
  ?>
    <form action="" method="POST">
	<div class="mb-3 row">
    <label for="nim" class="col-sm-2 col-form-label">Nim</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="nim"   id="nim" value="<?php echo $nim ?>">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $nama ?>">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
    <div class="col-sm-10">
     <select class="from-control" name="jurusan" id="jurusan">
      <option value="">- Pilih Jurusan -</option>
      <option value="SI" <?php if($jurusan == "SI") echo "selected"?>>SI</option>
      <option value="SK"<?php if($jurusan == "SK") echo "selected"?>>SK</option>
      </select>
    </div>
  </div>
  <div class="mb-3 row">
    <label for="nim" class="col-sm-2 col-form-label">Alamat</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="alamat"  id="alamat" value="<?php echo $alamat ?>">
    </div>
  </div>
  <div class="col-12"> 
		<input type="submit" name="simpan" value="simpan" value="Simpan Data" class="btn btn-primary"/>
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
          <th scope="col">No</th>
          <th scope="col">Nim</th>
          <th scope="col">Nama</th>
          <th scope="col">Jurusan</th>
          <th scope="col">Alamat</th>
          <th scope="col">Aksi</th>
    </tr>
    <tbody>
          <?php 
          $sql2 = "select * from mahasiswa order by id desc";
          $q2   = mysqli_query($koneksi,$sql2);
          $urut =1;
          while($r2 = mysqli_fetch_array($q2)){
            $nim			= $r2['nim'];
	          $nama			= $r2['nama'];
	          $jurusan	= $r2['jurusan'];
          	$alamat		= $r2['alamat'];  
            
            ?>
            <tr>
            <th scope="row"><?php echo $urut++ ?></th>
            <td scope="row"><?php echo $nim ?></td>
            <td scope="row"><?php echo $nama ?></td>
            <td scope="row"><?php echo $jurusan ?></td>
            <td scope="row"><?php echo $alamat ?></td>
            <td scope="row">
            <a href="index.php?op=edit&id=<? echo $id?>"><button type="button" class="btn btn-danger">Edit</button></a>
            <a href="index.php?op=delete&id=<? echo $id?>"  onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-warning">Delete</button></a>
            
            
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
