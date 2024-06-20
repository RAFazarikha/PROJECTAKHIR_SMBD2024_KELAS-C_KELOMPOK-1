<?php
    session_start();
    include '../konek.php';
    

    if(isset($_POST['submit'])){
        $pass_md5 = md5($_POST['pw']);
        $insert = mysqli_query($connect, "UPDATE petugas SET
            username = '".$_POST['userName']."',
            PASSWORD = '".$pass_md5."',
            nama = '".$_POST['nm']."',
            telp = '".$_POST['tlp']."',
            alamat = '".$_POST['almt']."'
            WHERE id = '".$_GET['id']."'
            ");
    
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
                <a class="nav-link active" aria-current="page" href="tambah-petugas.php">Daftar Petugas</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="../index.php">Keluar</a>
                </li>
            </ul>
            <span class="navbar-text">
                <h2>
                    Tambah Petugas
                </h2>
            </span>
            </div>
        </div>
        </nav>
        <table class="table">
            <tbody class="table-group-divider">
                <form action="" method="post">
                    <?php
                        $data = mysqli_query($connect, "SELECT * FROM petugas WHERE id = '".$_GET['id']."'");
                        while($row = mysqli_fetch_assoc($data)){
                    ?>
                    <tr>
                        <td>Username</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="userName" class="form-control" placeholder="Username" value="<?php echo $row['username'] ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="pw" class="form-control" placeholder="Password" value="<?php echo $row['PASSWORD'] ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="nm" class="form-control" placeholder="Nama Petugas" value="<?php echo $row['nama'] ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>No. Handphone</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="tlp" class="form-control" placeholder="Nomor HP" value="<?php echo $row['telp'] ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="almt" class="form-control" placeholder="Alamat Petugas" value="<?php echo $row['alamat'] ?>" required>
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
                    <?php
                        }
                    ?>
                </form>
            </tbody>
        </table>
    </div>
</body>
</html>