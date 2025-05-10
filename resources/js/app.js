import './bootstrap';
import autosize from 'autosize';
import imask from 'imask';
import List from 'list.js';
import Litepicker from 'litepicker';
// import 'litepicker/dist/css/litepicker.css';
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { Indonesian } from "flatpickr/dist/l10n/id.js"; // opsional jika ingin bahasa Indonesia
// Register locale jika pakai bahasa Indonesia
flatpickr.localize(Indonesian);

window.List = List;
window.Litepicker = Litepicker;


import "@tabler/core/dist/js/tabler.min.js";
import Swal from 'sweetalert2';
window.Swal = Swal;

const currentTheme = localStorage.getItem('theme') || 'light';


function setTheme(theme) {
    document.body.classList.remove('theme-light', 'theme-dark');
    document.body.classList.add(`theme-${theme}`);
    localStorage.setItem('theme', theme);
    document.documentElement.setAttribute('data-bs-theme', theme);

    // Perbarui tema pada calendar Flatpickr yang terbuka
    const calendars = document.querySelectorAll('.flatpickr-calendar');
    calendars.forEach(calendar => {
        calendar.classList.remove('dark-theme');
        if (theme === 'dark') {
            calendar.classList.add('dark-theme');
        }
    });
}


// Terapkan tema saat halaman dimuat
setTheme(currentTheme);



// Tangani klik pada tombol ubah tema secara umum
document.querySelectorAll('[data-theme]').forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault(); // Mencegah reload halaman
        const theme = this.getAttribute('data-theme');
        setTheme(theme);
    });
});

window.initializeFlatpickr = function (selector, options = {}) {
    const instance = flatpickr(selector, {
        ...options,
        onOpen: function (selectedDates, dateStr, instance) {
            const theme = localStorage.getItem('theme') || 'light';
            const calendar = instance.calendarContainer;

            // Hapus class lama jika ada
            calendar.classList.remove('dark-theme');

            if (theme === 'dark') {
                calendar.classList.add('dark-theme');
            }
        }
    });
    return instance;
};


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


/************************************
 * LITEPICKER THEME MANAGER (Global)
 ************************************/
const LitepickerTheme = {
    updateThemeVariables: (isDark) => { /* ... */ },
    initThemeObserver: () => { /* ... */ },
    create: (options) => { /* ... */ }
  };

  // Inisialisasi theme observer secara global
  document.addEventListener('DOMContentLoaded', function() {
    LitepickerTheme.initThemeObserver();
  });
