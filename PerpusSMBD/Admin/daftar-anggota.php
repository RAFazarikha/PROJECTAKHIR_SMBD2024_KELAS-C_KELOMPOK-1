<?php
    session_start();
    include '../konek.php';
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
                <a class="nav-link active" aria-current="page" href="daftar-anggota.php">Daftar Anggota</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="daftar-buku.php">Daftar Buku</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="daftar-petugas.php">Daftar Petugas</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="../index.php">Keluar</a>
                </li>
            </ul>
            <span class="navbar-text">
                <h2>
                    Hello, Admin
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
                        <th scope="col">ID Anggota</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Gender</th>
                        <th scope="col">No. HP</th>
                        <th scope="col">Option</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    $data = mysqli_query($connect, "SELECT * FROM daftaranggota");
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
                            <?php echo $row['nama'] ?>
                        </td>
                        <td>
                            <?php echo $row['gen'] ?>
                        </td>
                        <td>
                            <?php echo $row['hp'] ?>
                        </td>
                        <td>
                            <a href="ubah-anggota.php?id=<?php echo $row['id']?>" onclick="return confirm('Yakin ?')" class="pe-3">Edit</a>
                            <a href="hapus-data.php?id=<?php echo $row['id']?>" onclick="return confirm('Yakin ?')">Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-primary me-md-2 btn-sm" type="button"><a href="tambah-anggota.php" style="color: #fff; text-decoration: none;">Tambah Anggota</a></button>
        </div>
    </div>
</body>
</html>