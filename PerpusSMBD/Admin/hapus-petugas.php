<?php
    include '../konek.php';

    if(isset($_GET['id'])){
        try{
            $delete = mysqli_query($connect, "DELETE FROM petugas WHERE id = '".$_GET['id']."'");
            if ($delete) {
                echo '<script>window.location="daftar-petugas.php"</script>';
            } else {
                throw new Exception($connect->error);
            }
        }catch (Exception $e){
            echo '<script>alert("Error: ' . $e->getMessage() . '"); window.location="daftar-petugas.php"</script>';
        }
    }
?>