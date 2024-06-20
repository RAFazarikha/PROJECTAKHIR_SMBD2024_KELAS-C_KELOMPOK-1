<?php
    session_start();
    include '../konek.php';

    if(isset($_POST['submit'])){
        $insert = mysqli_query($connect, "CALL inputPeminjaman(
            '".$_POST['tglKembali']."',
            '".$_POST['idAnggota']."',
            '".$_POST['idPetugas']."',
            '".$_POST['idBuku']."'
        )");
    
    if($insert){
        $kurang = mysqli_query($connect, "UPDATE buku SET jumlah = jumlah-1 WHERE id = '".$_GET['kode']."'");
        echo '<script>window.location = "landingadmin.php"</script>';
    }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Pustaka</title>
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-xxl" style="width: 100%;">
        <nav class="navbar navbar-expand-lg" style="background-color: #fff;">
        <div class="container-fluid">
            <a class="navbar-brand" href="landingadmin.php">E-Pustaka</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="tambah-peminjaman.php">Daftar Peminjaman</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="../index.php">Keluar</a>
                </li>
            </ul>
            <span class="navbar-text">
                <h2>
                    Tambah Peminjaman
                </h2>
            </span>
            </div>
        </div>
        </nav>
        <table class="table">
            <tbody class="table-group-divider">
                <form action="" method="post">
                    <tr>
                        <td>Rencana Kembali</td>
                        <td>:</td>
                        <td>
                            <input type="date" name="tglKembali" class="form-control" placeholder="Tanggal Kembali" required>
                        </td>
                    </tr>
                    <tr>
                        <td>ID Anggota</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="idAnggota" class="form-control" placeholder="ID Anggota" required>
                        </td>
                    </tr>
                    <tr>
                        <td>ID Petugas</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="idPetugas" class="form-control" placeholder="ID Petugas" required>
                        </td>
                    </tr>
                    <tr>
                        <td>ID Buku</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="idBuku" class="form-control" placeholder="ID Buku" required>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <div class="col-auto">
                                <input type="submit" name="submit" class="form-control" placeholder="Submit Data">
                            </div>
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>
    </div>
</body>
</html>