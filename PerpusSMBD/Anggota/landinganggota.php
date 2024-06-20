<?php
    session_start();
    include '../konek.php';
    $detail1 = mysqli_query($connect, "SELECT * FROM anggota WHERE nama = '".$_GET['nama']."'");
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
                    <a class="nav-link active" aria-current="page" href="#">Daftar Buku</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Keluar</a>
                </li>
            </ul>
            <span class="navbar-text">
                <h2>
                    Hello, <?php echo $_GET['nama']?>
                </h2>
            </span>
            </div>
        </div>
        </nav>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Kode Buku</th>
                        <th scope="col">Judul Buku</th>
                        <th scope="col">Penulis</th>
                        <th scope="col">Penerbit</th>
                        <th scope="col">Jumlah Buku</th>
                        <th scope="col">Option</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    $data = mysqli_query($connect, "SELECT * FROM daftarbukuanggota");
                    $nomor = 0;
                    while($row = mysqli_fetch_assoc($data)){
                        $nomor ++;
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $nomor ?>
                        </th>
                        <td>
                            <?php echo $row['id'] ?>
                        </td>
                        <td>
                            <?php echo $row['judul'] ?>
                        </td>
                        <td>
                            <?php echo $row['pengarang'] ?>
                        </td>
                        <td>
                            <?php echo $row['penerbit'] ?>
                        </td>
                        <td>
                            <?php echo $row['jumlah'] ?>
                        </td>
                        <td>
                            <a href="detail-buku.php?kode=<?php echo $row['id'] ?>&id=<?php echo $anggota['id'] ?>">Detail Buku</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-primary me-md-2 btn-sm" type="button"><a href="kembalikan-buku.php" target="_blank" style="color: #fff;text-decoration: none;">Kembalikan Buku</a></button>
            <button class="btn btn-primary me-md-2 btn-sm" type="button"><a href="cetak-buku.php" target="_blank" style="color: #fff;text-decoration: none;">Cetak Daftar Buku</a></button>
        </div>
    </div>
    

</body>
</html>