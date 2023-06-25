<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "akademik";

$koneksi = mysqli_connect($host,$user,$pass,$db);
if(!$koneksi){
    die("tidak bisa terkoneksi ke database");
}
$npm = "";
$nama = "";
$alamat = "";
$nilai = "";
$sukses = "";
$error = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}

if($op == 'edit'){
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM 'mahasiswa' WHERE id = '$id'";
    $q1 = mysqli_query($koneksi,$sql1);
    $r1 = mysqli_fetch_array($q1);
    $npm = $r1['npm'];
    $nama = $r1['nama'];
    $alamat = $r1['alamat'];
    $nilai = $r1['nilai'];

    if($npm == ''){
        $error = "data tidak ditemukan";
    }
}

if(isset($_POST['simpan'])){ //untuk create
    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nilai = $_POST['nilai'];

    if($npm && $nama && $alamat && $nilai){
        if($op == 'edit'){//untuk update
            $sql1 = "UPDATE 'mahasiswa' SET npm = '$npm', nama='$nama',alamat='$alamat', fakultas='$fakultas' WHERE id = '$id' ";
            $q1 = mysqli_query($koneksi,$sql1);
            if($q1){
                $sukses = "Data Berhasil DIupdate";
            }else{
                $error = "Data gagal Diupdate";
            }
        }else{ //untuk insert
            $sql1 = "insert into mahasiswa (npm,nama,alamat,nilai) values ('$npm','$nama','$alamat','$nilai')";
            $q1 = mysqli_query($koneksi,$sql1);
        
            if($q1){
                $sukses = "berhasil memasukkan data baru";
            }else{
                $error = "gagal memassukkan data";
            }
        }
        
    }else{
        $error = "Shilakan masukkan semua data";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px;
        }
        .card {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="mx-auto">
        //untuk mmasukkan data
    <div class="card">
    <div class="card-header">
    Create Data
    </div>
    <div class="card-body">
        <?php
        if($error){
            ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error ?>
            </div>
            <?php
        }
        ?>
        <?php
        if($sukses){
            ?>
            <div class="alert alert-success" role="alert">
                <?php echo $error ?>
            </div>
            <?php
        }
        ?>
        <form action="" method="POST">
        <div class="mb-3 row">
            <label for="npm" class="col-sm-2 col-form-label">NPM</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="npm" name="npm" value="<?php echo $npm?>">
        </div>
        </div>
        <div class="mb-3 row">
            <label for="nama" class="col-sm-2 col-form-label">NAMA</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $npm?>">
        </div>
        </div>
        <div class="mb-3 row">
            <label for="alamat" class="col-sm-2 col-form-label">ALAMAT</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat?>">
        </div>
        </div>
        <div class="mb-3 row">
            <label for="nilai" class="col-sm-2 col-form-label">nilai</label>
            <div class="col-sm-10">
            <select class="form-control" name="nilai" id="nilai">
            <option value="pilih_nilai">- Pilih nilai -</option>
            <option value="A" <?php if($nilai == "A") echo "selected"?>>A</option>
            <option value="A-" <?php if($nilai == "A-") echo "selected"?>>A-</option>
            <option value="B+" <?php if($nilai == "B+") echo "selected"?>>B+</option>
            <option value="B" <?php if($nilai == "B") echo "selected"?>>B</option>
            <option value="B-" <?php if($nilai == "B-") echo "selected"?>>B-</option>
            <option value="C+" <?php if($nilai == "C+") echo "selected"?>>C+</option>
            <option value="C" <?php if($nilai == "C") echo "selected"?>>C</option>
            <option value="D" <?php if($nilai == "D") echo "selected"?>>D</option>
            <option value="E" <?php if($nilai == "E") echo "selected"?>>E</option>
            </select>
        </div>
        </div>
        <div class="col-12">
            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
        </div>
        </form>
    </div>
</div>
<div class="card">
    Untuk Mengeluarkan data
    <div class="card-header tect-white bg-secondary">
    data mahasiswa
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">NPM</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">nilai</th>
                    <th scope="col">Aksi</th>
                </tr>
                <tbody>
                    <?php
                    $sql2 = "SELECT * FROM mahasiswa order by id desc";
                    $q1 = mysqli_query($koneksi,$sql2);
                    $urut = 1;
                    while($r2 = mysqli_fetch_array($q2)){
                        $id = $r2['id'];
                        $npm = $r2['npm'];
                        $nama = $r2['nama'];
                        $alamat = $r2['alamat'];
                        $nilai = $r2['nilai'];

                        ?>
                        <tr>
                            <th scope="row"><?php echo $urut++ ?></th>
                            <td scope="row"><?php echo $npm ?></td>
                            <td scope="row"><?php echo $nama ?></td>
                            <td scope="row"><?php echo $alamat ?></td>
                            <td scope="row"><?php echo $nilai ?></td>
                            <td scope="row">
                            <a href="undex.php?op=edit&id=<?php echo $id?>"><button type="button" class="btn btn-warning">Edit</button></a>
                            <a href="index.php?op=delete&id=<?php echo $id?>"> <button type="button" class="btn btn-danger">Delete</button></a>
                            <button type="button" class="btn btn-danger">Delete</button>
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