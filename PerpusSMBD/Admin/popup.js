document.addEventListener("DOMContentLoaded", function() {
    var popup = document.getElementById("popup");
    var closeBtn = document.getElementsByClassName("close-btn")[0];
    var openPopupBtns = document.getElementsByClassName("openPopupBtn");

    // Fungsi untuk membuka pop up dan menampilkan riwayat
    function openPopup(event) {
        var id = event.target.getAttribute("data-id");
        var url = "riwayat-buku.php?id=" + id;
        fetch(url)
            .then(response => response.text())
            .then(data => {
                document.getElementById("popupContent").innerHTML = data;
                popup.style.display = "block";
            });
    }

    // Ketika pengguna mengklik <span> (x), tutup pop up
    closeBtn.onclick = function() {
        popup.style.display = "none";
    }

    // Ketika pengguna mengklik di luar pop up, tutup pop up
    window.onclick = function(event) {
        if (event.target == popup) {
            popup.style.display = "none";
        }
    }

    // Pasang event listener pada setiap tombol
    for (var i = 0; i < openPopupBtns.length; i++) {
        openPopupBtns[i].addEventListener("click", function(event) {
            event.preventDefault(); // Mencegah pengalihan halaman
            openPopup(event);
        });
    }
});
