<?php
    session_start();
    include 'konek.php';

    if(isset($_POST['loginadmin'])){
        $berhasil = mysqli_query($connect, "SELECT * FROM petugas WHERE id = '".$_POST['idadmin']."' AND password = '".MD5($_POST['pass1'])."'");

        if(mysqli_num_rows($berhasil) > 0){
            $a = mysqli_fetch_object($berhasil);

            $_SESSION['stat_login'] = true;
            $_SESSION['id'] = $a->id;
            $_SESSION['nama'] = $a->nama;
            $nama = mysqli_query($connect, "SELECT nama FROM petugas WHERE id = '".$_POST['idadmin']."' AND password = '".MD5($_POST['pass1'])."'");
            $row = mysqli_fetch_assoc($nama);
            $name = $row['nama'];

            echo '<script>window.location="Admin/landingadmin.php"</script>';
        }else{
            $pesan_error = 'anda tidak memiliki akses masuk';
            echo "<script>alert('$pesan_error')</script>";
        }
    }elseif(isset($_POST['loginmember'])){
      $berhasil2 = mysqli_query($connect, "SELECT * FROM anggota WHERE id = '".$_POST['idanggota']."' AND pass = '".MD5($_POST['pass2'])."'");

      if(mysqli_num_rows($berhasil2) > 0){
          $a = mysqli_fetch_object($berhasil2);

          $_SESSION['stat_login'] = true;
          $_SESSION['id'] = $a->id_anggota;
          $_SESSION['nama'] = $a->nama;
          $nama1 = mysqli_query($connect, "SELECT nama FROM anggota WHERE id = '".$_POST['idanggota']."' AND pass = '".MD5($_POST['pass2'])."'");
          $row1 = mysqli_fetch_assoc($nama1);
          $name1 = $row1['nama'];

          echo '<script>window.location="Anggota/landinganggota.php?nama='.$name1.'"</script>';
      }else{
          $pesan_error = 'anda tidak memiliki akses masuk';
          echo "<script>alert('$pesan_error')</script>";
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
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container" id="container">

    <div class="form-container register-container" id="form-admin">
      <form action="" method="post">
        <h1>Admin hire.</h1>
        <input type="text" name="idadmin" placeholder="ID Admin">
        <input type="password" name="pass1" placeholder="Password">
        <button name="loginadmin">Login</button>
      </form>
    </div>

    <div class="form-container register-container" id="form-member">
      <form action="" method="post">
        <h1>Member hire.</h1>
        <input type="text" name="idanggota" placeholder="ID Member">
        <input type="password" name="pass2" placeholder="Password">
        <button name="loginmember">Login</button>
      </form>
    </div>

    <div class="form-container login-container">
      <form action="#">
        <h1>Who are you?</h1>
        <button id="adminButton">Admin
          
        </button>
        <button id="memberButton">Member
          
        </button>
      </form>
    </div>
    

    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left" id="admin-overlay" style="display: flex;">
          <h1 class="title1">Hello <br> admin</h1>
          <p>let's organize the book room</p>
          <button class="ghost" id="back1">Back
            <i class="lni lni-arrow-left login"></i>
          </button>
        </div>
        <div class="overlay-panel overlay-left" id="member-overlay" style="display: flex;">
          <h1 class="title1">Hello <br> member</h1>
          <p>come explore your book room </p>
          <button class="ghost" id="back2">Back
            <i class="lni lni-arrow-left login"></i>
          </button>
        </div>
        <div class="overlay-panel overlay-right">
          <h1 class="title">Let's Start</h1>
          <p>opening the window to your world</p>
        </div>
      </div>
    </div>

  </div>


  <script src="script.js"></script>

</body>
</html>