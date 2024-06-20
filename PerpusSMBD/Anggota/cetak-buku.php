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
            <a class="navbar-brand" href="#">E-Pustaka</a>
        </div>
        </nav>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">ID Buku</th>
                    <th scope="col">Judul Buku</th>
                    <th scope="col">Tahun Terbit</th>
                    <th scope="col">Jumlah Buku</th>
                    <th scope="col">Penulis</th>
                    <th scope="col">Penerbit</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                $data = mysqli_query($connect, "SELECT * FROM buku");
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
                        <?php echo $row['tahun_terbit'] ?>
                    </td>
                    <td>
                        <?php echo $row['jumlah'] ?>
                    </td>
                    <td>
                        <?php echo $row['pengarang'] ?>
                    </td>
                    <td>
                        <?php echo $row['penerbit'] ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

    

</body>
</html>