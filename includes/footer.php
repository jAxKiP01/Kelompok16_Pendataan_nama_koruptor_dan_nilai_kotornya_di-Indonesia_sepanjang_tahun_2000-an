<?php
// File: includes/footer.php
?>
            </div> <!-- end content-wrapper -->
        </div> <!-- end main-content -->
    </div> <!-- end d-flex -->

    <!-- Bootstrap 5.3 JS Bundle (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS untuk interaksi modal -->
    <script>
        // Script untuk mengisi form edit pada modal
        // Contoh untuk halaman buku
        const editBukuModal = document.getElementById('editBukuModal');
        if (editBukuModal) {
            editBukuModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-bs-id');
                const judul = button.getAttribute('data-bs-judul');
                const penulis = button.getAttribute('data-bs-penulis');
                const penerbit = button.getAttribute('data-bs-penerbit');
                const tahun = button.getAttribute('data-bs-tahun');
                const stok = button.getAttribute('data-bs-stok');
                const harga = button.getAttribute('data-bs-harga');
                const id_penjual = button.getAttribute('data-bs-idpenjual');

                const modalTitle = editBukuModal.querySelector('.modal-title');
                const modalBodyInputId = editBukuModal.querySelector('#edit_id_buku');
                const modalBodyInputJudul = editBukuModal.querySelector('#edit_judul');
                const modalBodyInputPenulis = editBukuModal.querySelector('#edit_penulis');
                const modalBodyInputPenerbit = editBukuModal.querySelector('#edit_penerbit');
                const modalBodyInputTahun = editBukuModal.querySelector('#edit_tahun');
                const modalBodyInputStok = editBukuModal.querySelector('#edit_stok');
                const modalBodyInputHarga = editBukuModal.querySelector('#edit_harga');
                const modalBodySelectPenjual = editBukuModal.querySelector('#edit_id_penjual');

                modalTitle.textContent = `Edit Buku: ${judul}`;
                modalBodyInputId.value = id;
                modalBodyInputJudul.value = judul;
                modalBodyInputPenulis.value = penulis;
                modalBodyInputPenerbit.value = penerbit;
                modalBodyInputTahun.value = tahun;
                modalBodyInputStok.value = stok;
                modalBodyInputHarga.value = harga;
                modalBodySelectPenjual.value = id_penjual;
            });
        }
        
        // Contoh untuk halaman penjual
        const editPenjualModal = document.getElementById('editPenjualModal');
        if (editPenjualModal) {
            editPenjualModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-bs-id');
                const nama = button.getAttribute('data-bs-nama');
                const alamat = button.getAttribute('data-bs-alamat');
                const telepon = button.getAttribute('data-bs-telepon');

                const modalTitle = editPenjualModal.querySelector('.modal-title');
                const modalBodyInputId = editPenjualModal.querySelector('#edit_id_penjual');
                const modalBodyInputNama = editPenjualModal.querySelector('#edit_nama_penjual');
                const modalBodyInputAlamat = editPenjualModal.querySelector('#edit_alamat');
                const modalBodyInputTelepon = editPenjualModal.querySelector('#edit_telepon');

                modalTitle.textContent = `Edit Penjual: ${nama}`;
                modalBodyInputId.value = id;
                modalBodyInputNama.value = nama;
                modalBodyInputAlamat.value = alamat;
                modalBodyInputTelepon.value = telepon;
            });
        }
    </script>
</body>
</html>
