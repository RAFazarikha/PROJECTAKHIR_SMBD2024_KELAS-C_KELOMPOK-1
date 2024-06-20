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
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script>
    window.print();
  </script>
</head>
<body style="display: block;">
        <nav class="navbar navbar-expand-lg" style="background-color: #fff;">
        <div class="container-fluid">
            <span class="navbar-text">
                <h2>
                    Bukti Peminjaman
                </h2>
            </span>
        </div>
        </nav>
        <table class="table">
            <tbody class="table-group-divider">
                <?php 
                    $detail = mysqli_query($connect, "SELECT * FROM peminjaman WHERE id = '".$_GET['id']."'");
                    $baris = mysqli_fetch_assoc($detail);
                    $detail2 = mysqli_query($connect, "SELECT * FROM peminjaman_detail WHERE peminjaman_id = '".$_GET['id']."'");
                    $baris2 = mysqli_fetch_assoc($detail2)
                ?>
                    <tr>
                        <td>ID Peminjaman</td>
                        <td>:</td>
                        <td>
                            <?php echo $baris['id'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>ID Buku</td>
                        <td>:</td>
                        <td>
                            <?php echo $baris2['buku_id'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Pinjam</td>
                        <td>:</td>
                        <td>
                            <?php echo $baris['tanggal_pinjam'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Rencana Kembali</td>
                        <td>:</td>
                        <td>
                            <?php echo $baris['tanggal_kembali'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>ID Anggota</td>
                        <td>:</td>
                        <td>
                            <?php echo $baris['anggota_id'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>ID Petugas</td>
                        <td>:</td>
                        <td>
                            <?php echo $baris['petugas_id'] ?>
                        </td>
                    </tr>
            </tbody>
        </table>

</body>
</html>