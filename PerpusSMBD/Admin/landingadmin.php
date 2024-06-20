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
                <a class="nav-link" href="daftar-anggota.php">Daftar Anggota</a>
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
                        <th scope="col" class="text-center col-4">Jumlah Petugas</th>
                        <th scope="col" class="text-center col-4">Jumlah Anggota</th>
                        <th scope="col" class="text-center col-4">Jumlah Buku</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    $data = mysqli_query($connect, "SELECT * FROM dashboardAdmin");
                    
                    while($row = mysqli_fetch_assoc($data)){
                        
                    ?>
                    <tr>
                        <td scope="col" class="text-center fs-1">
                            <?php echo $row['jumlahPetugas'] ?>
                        </td>
                        <td scope="col" class="text-center fs-1">
                            <?php echo $row['jumlahAnggota'] ?>
                        </td>
                        <td scope="col" class="text-center fs-1">
                            <?php echo $row['jumlahBuku'] ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <table class="table fs-6">
            <tr>
                <td class="col-6 text-center">
                    <b>Daftar Peminjaman</b>
                    <table class="table table-sm table-bordered mt-4">
                        <tr>
                            <th class="fs-6">ID</th>
                            <th class="fs-6">Tanggal Pinjam</th>
                            <th class="fs-6">ID Anggota</th>
                            <th class="fs-6">ID Petugas</th>
                            <th class="fs-6">ID Buku</th>
                            <th class="fs-6">Option</th>
                        </tr>
                        <?php
                            $data = mysqli_query($connect, "SELECT * FROM daftarpeminjaman");
                            while($row = mysqli_fetch_assoc($data)){
                        ?>
                        <tr>
                            <th scope="row">
                                <?php echo $row['id'] ?>
                            </th>
                            <td>
                                <?php echo $row['tglPinjam'] ?>
                            </td>
                            <td>
                                <?php echo $row['idAnggota'] ?>
                            </td>
                            <td>
                                <?php echo $row['idPetugas'] ?>
                            </td>
                            <td>
                                <?php echo $row['idBuku'] ?>
                            </td>
                            <td>
                                <a href="hapus-petugas.php?id=<?php echo $row['id']?>" onclick="return confirm('Yakin ?')">Hapus</a>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </table>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary me-md-2 btn-sm" type="button"><a href="tambah-peminjaman.php" style="color: #fff; text-decoration: none;">Tambah Peminjaman</a></button>
                    </div>
                </td>
                <td class="col-6 text-center">
                    <b>Daftar Pengembalian</b>
                    <table class="table table-sm table-bordered mt-4">
                    <tr>
                            <th>ID</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Denda</th>
                            <th>ID Anggota</th>
                            <th>ID Petugas</th>
                            <th>ID Buku</th>
                            <th>Option</th>
                        </tr>
                        <?php
                            $data = mysqli_query($connect, "SELECT * FROM daftarpengembalian");
                            while($row = mysqli_fetch_assoc($data)){
                        ?>
                        <tr>
                            <th scope="row">
                                <?php echo $row['id'] ?>
                            </th>
                            <td>
                                <?php echo $row['tglPengembalian'] ?>
                            </td>
                            <td>
                                <?php echo $row['denda'] ?>
                            </td>
                            <td>
                                <?php echo $row['idAnggota'] ?>
                            </td>
                            <td>
                                <?php echo $row['idPetugas'] ?>
                            </td>
                            <td>
                                <?php echo $row['idBuku'] ?>
                            </td>
                            <td>
                                <a href="hapus-petugas.php?id=<?php echo $row['id']?>" onclick="return confirm('Yakin ?')">Hapus</a>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </table>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary me-md-2 btn-sm" type="button"><a href="tambah-pengembalian.php" style="color: #fff; text-decoration: none;">Tambah Pengembalian</a></button>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>