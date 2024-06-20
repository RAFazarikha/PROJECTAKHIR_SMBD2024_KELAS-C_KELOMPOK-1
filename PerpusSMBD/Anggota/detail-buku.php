<?php
    session_start();
    include '../konek.php';
    $detail1 = mysqli_query($connect, "SELECT * FROM anggota WHERE id = '".$_GET['id']."'");
    $anggota = mysqli_fetch_assoc($detail1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Pustaka</title>
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg" style="background-color: #fff;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">E-Pustaka</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link" href="index.php">Keluar</a>
                </li>
            </ul>
            <span class="navbar-text">
                <h2>
                    Detail Buku
                </h2>
            </span>
            </div>
        </div>
        </nav>
        <table class="table">
            <tbody class="table-group-divider">
                <?php 
                    $detail = mysqli_query($connect, "SELECT * FROM buku WHERE id = '".$_GET['kode']."'");
                    $baris = mysqli_fetch_assoc($detail)
                ?>
                    <tr>
                        <td>Kode Buku</td>
                        <td>:</td>
                        <td>
                            <?php echo $baris['id'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Judul Buku</td>
                        <td>:</td>
                        <td>
                            <?php echo $baris['judul'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tahun Terbit</td>
                        <td>:</td>
                        <td>
                            <?php echo $baris['tahun_terbit'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Jumlah Buku</td>
                        <td>:</td>
                        <td>
                            <?php echo $baris['jumlah'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Penulis</td>
                        <td>:</td>
                        <td>
                            <?php echo $baris['pengarang'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Penerbit</td>
                        <td>:</td>
                        <td>
                            <?php echo $baris['penerbit'] ?>
                        </td>
                    </tr>
            </tbody>
        </table>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-primary me-md-2 btn-sm" type="button"><a href="pinjam.php?kode=<?php echo $baris['id'] ?>&id=<?php echo $anggota['id'] ?>" style="color: #fff;text-decoration: none;">Pinjam Buku</a></button>
        </div>
    </div>
    

</body>
</html>