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
  <link rel="stylesheet" href="popup.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-xxl" style="width: 100%;">
        <div id="popup" class="popup">
            <div class="popup-content">
                <span class="close-btn">&times;</span>
                <h2>Riwayat Buku Dipinjam</h2>
                <table class="table" id="popupContent">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">ID Anggota</th>
                            <th scope="col">Nama Anggota</th>
                            <th scope="col">Tanggal Dipinjam</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        $idriwayat = $_GET['id'];
                        $data = mysqli_query($connect, "CALL riwayatBuku('$idriwayat')");
                        $nomor = 0;
                        while($rw = mysqli_fetch_assoc($data)){
                            $nomor ++;
                        ?>
                        <tr>
                            <th scope="row">
                                <?php echo $nomor ?>
                            </th>
                            <td>
                                <?php echo $rw['idAnggota'] ?>
                            </td>
                            <td>
                                <?php echo $rw['namaAnggota'] ?>
                            </td>
                            <td>
                                <?php echo $rw['tglPinjam'] ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="popup.js"></script>

</body>
</html>