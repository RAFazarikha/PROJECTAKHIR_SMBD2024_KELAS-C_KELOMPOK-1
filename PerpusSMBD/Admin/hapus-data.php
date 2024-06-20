<?php
    include '../konek.php';

    if(isset($_GET['id'])){
        try{
            $delete = mysqli_query($connect, "DELETE FROM anggota WHERE id = '".$_GET['id']."'");
            if ($delete) {
                echo '<script>window.location="daftar-anggota.php"</script>';
            } else {
                throw new Exception($connect->error);
            }
        }catch (Exception $e){
            echo '<script>alert("Error: ' . $e->getMessage() . '"); window.location="daftar-anggota.php"</script>';
        }
    }
        
?>