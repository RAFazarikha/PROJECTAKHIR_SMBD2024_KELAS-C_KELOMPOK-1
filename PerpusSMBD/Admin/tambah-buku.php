<?php
    session_start();
    include '../konek.php';

    if(isset($_POST['submit'])){
        $insert = mysqli_query($connect, "CALL inputBuku(
            '".$_POST['judul']."',
            '".$_POST['thnTerbit']."',
            '".$_POST['jmlh']."',
            '".$_POST['pengarang']."',
            '".$_POST['penerbit']."'
        )");
    
    if($insert){
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
                <a class="nav-link active" aria-current="page" href="tambah-buku.php">Daftar Buku</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="../index.php">Keluar</a>
                </li>
            </ul>
            <span class="navbar-text">
                <h2>
                    Tambah Buku
                </h2>
            </span>
            </div>
        </div>
        </nav>
        <table class="table">
            <tbody class="table-group-divider">
                <form action="" method="post">
                    <tr>
                        <td>Judul Buku</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="judul" class="form-control" placeholder="Judul Buku" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Tahun Terbit</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="thnTerbit" class="form-control" placeholder="Tahun Terbit" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Jumlah Buku</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="jmlh" class="form-control" placeholder="Jumlah Buku" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Penulis</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="pengarang" class="form-control" placeholder="Penulis" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Penerbit</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="penerbit" class="form-control" placeholder="Penerbit" required>
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