import './bootstrap';
import autosize from 'autosize';
import imask from 'imask';
import List from 'list.js';
window.List = List;

import "@tabler/core/dist/js/tabler.min.js";
import Swal from 'sweetalert2';
window.Swal = Swal;
// Ambil tema yang disimpan atau gunakan default 'light'
const currentTheme = localStorage.getItem('theme') || 'light';
console.log('Current Theme:', currentTheme); // Cek apakah nilai yang diambil sudah benar

// Fungsi untuk mengubah tema
function setTheme(theme) {
    console.log('Setting theme:', theme); // Cek apakah fungsi dipanggil dengan benar

    // Menghapus kelas tema lama dan menambahkan yang baru
    document.body.classList.remove('theme-light', 'theme-dark');
    document.body.classList.add(`theme-${theme}`);

    // Simpan tema ke localStorage
    localStorage.setItem('theme', theme);

    // Terapkan perubahan tema ke elemen root (html)
    document.documentElement.setAttribute('data-bs-theme', theme);
}

// Terapkan tema saat halaman dimuat
setTheme(currentTheme);

// Mengatur tombol untuk mengubah tema
document.querySelector('.hide-theme-dark')?.addEventListener('click', function () {
    setTheme('dark');
});

document.querySelector('.hide-theme-light')?.addEventListener('click', function () {
    setTheme('light');
});


import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Script untuk modal logout
document.addEventListener("DOMContentLoaded", function () {
    var modalTriggers = document.querySelectorAll('[data-bs-toggle="modal"]');
    modalTriggers.forEach(function (trigger) {
        trigger.addEventListener('click', function (event) {
            var openModal = document.querySelector('.modal.show');
            if (openModal) {
                var modal = bootstrap.Modal.getInstance(openModal);
                modal.hide();
            }
        });
    });

    // Modal logout
    var logoutModalElement = document.getElementById('logoutModal');
    if (logoutModalElement) {
        var logoutModal = new bootstrap.Modal(logoutModalElement);
        var logoutButton = document.querySelector('a[data-bs-toggle="modal"][data-bs-target="#logoutModal"]');
        if (logoutButton) {
            logoutButton.addEventListener('click', function (e) {
                e.preventDefault();
                logoutModal.show();
            });
        }
    }

    // Menangani modal tentang Siesde
    var aboutModalElement = document.getElementById('modal-scrollable');
    if (aboutModalElement) {
        var aboutModal = new bootstrap.Modal(aboutModalElement);
        var aboutButton = document.querySelector('a[data-bs-toggle="modal"][data-bs-target="#modal-scrollable"]');
        if (aboutButton) {
            aboutButton.addEventListener('click', function (e) {
                e.preventDefault();
                aboutModal.show();
            });
        }
    }
});

window.showAlert = function (type, message) {
    console.log('Alert type:', type);  // Menampilkan tipe alert (success/error)
    console.log('Message:', message);  // Menampilkan pesan

    Swal.fire({
        title: type === 'success' ? 'Berhasil!' : 'Gagal!',
        text: message,
        icon: type,
        position: 'top-end', // Menampilkan di pojok kanan atas
        showConfirmButton: false, // Menghilangkan tombol OK
        timer: 3000, // Menutup otomatis setelah 3 detik
        toast: true // Mengubah tampilan seperti toast (notifikasi kecil)
    });
};

