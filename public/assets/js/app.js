// Inisialisasi AOS (scroll animation)
if (window.AOS) {
  AOS.init({ duration: 850, once: true, offset: 50, easing: 'ease-out-cubic' });
}

// Navbar sticky & shrink: light glassmorphism -> solid glassmorphism saat discroll
(function () {
  const navbar = document.getElementById('mainNavbar');
  if (!navbar) return;
  function updateNavbar() {
    if (window.scrollY > 30) {
      navbar.classList.remove('bg-white/20', 'backdrop-blur-sm', 'border-white/10', 'py-4');
      navbar.classList.add('bg-white/85', 'backdrop-blur-md', 'shadow-lg', 'py-2.5', 'border-white/25');
    } else {
      navbar.classList.remove('bg-white/85', 'backdrop-blur-md', 'shadow-lg', 'py-2.5', 'border-white/25');
      navbar.classList.add('bg-white/20', 'backdrop-blur-sm', 'border-white/10', 'py-4');
    }
  }
  window.addEventListener('scroll', updateNavbar);
  updateNavbar();
})();

// Init hero slider (Swiper) & Interaktivitas lainnya
document.addEventListener('DOMContentLoaded', function () {
  if (window.Swiper) {
    const heroEl = document.querySelector('.hero-swiper');
    if (heroEl) {
      new Swiper(heroEl, {
        loop: true,
        autoplay: { delay: 5000, disableOnInteraction: false },
        effect: 'fade',
        fadeEffect: { crossFade: true },
        pagination: { el: '.hero-swiper .swiper-pagination', clickable: true },
      });
    }

    const testiEl = document.querySelector('.testi-swiper');
    if (testiEl) {
      new Swiper(testiEl, {
        loop: true,
        autoplay: { delay: 4000, disableOnInteraction: false },
        slidesPerView: 1,
        spaceBetween: 30,
        breakpoints: {
          768: { slidesPerView: 2 },
          1024: { slidesPerView: 3 },
        },
        pagination: { el: '.testi-swiper .swiper-pagination', clickable: true },
      });
    }
  }

  // Interaktivitas Galeri Gambar Detail Produk
  const thumbnails = document.querySelectorAll('.product-thumb');
  const mainImage = document.getElementById('mainImage');
  if (mainImage && thumbnails.length > 0) {
    thumbnails.forEach((thumb, idx) => {
      // Set active default pada thumbnail pertama
      if (idx === 0) thumb.classList.add('border-secondary', 'scale-105', 'opacity-100');
      else thumb.classList.add('opacity-70', 'border-transparent');

      thumb.addEventListener('click', function () {
        // Efek transisi keluar
        mainImage.style.transition = 'all 0.2s ease';
        mainImage.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
          mainImage.src = this.src;
          mainImage.classList.remove('opacity-0', 'scale-95');
        }, 150);

        // Ubah state active thumbnail
        thumbnails.forEach(t => {
          t.classList.remove('border-secondary', 'scale-105', 'opacity-100');
          t.classList.add('opacity-70', 'border-transparent');
        });
        this.classList.add('border-secondary', 'scale-105', 'opacity-100');
        this.classList.remove('opacity-70', 'border-transparent');
      });
    });
  }

  // Input kuantitas interaktif (+ / -). Mendukung banyak instance sekaligus
  // (mis. satu per baris keranjang) selama masing-masing dibungkus .qty-group.
  document.querySelectorAll('.qty-group').forEach(function (group) {
    const qtyMinus = group.querySelector('.qty-minus');
    const qtyPlus = group.querySelector('.qty-plus');
    const qtyInput = group.querySelector('.qty-input');
    if (!qtyInput) return;

    const minVal = parseInt(qtyInput.getAttribute('min')) || 1;
    const maxVal = parseInt(qtyInput.getAttribute('max')) || 99;

    if (qtyMinus) {
      qtyMinus.addEventListener('click', function () {
        let current = parseInt(qtyInput.value) || 1;
        if (current > minVal) {
          qtyInput.value = current - 1;
          qtyInput.dispatchEvent(new Event('change'));
        }
      });
    }

    if (qtyPlus) {
      qtyPlus.addEventListener('click', function () {
        let current = parseInt(qtyInput.value) || 1;
        if (current < maxVal) {
          qtyInput.value = current + 1;
          qtyInput.dispatchEvent(new Event('change'));
        }
      });
    }

    // Validasi input manual
    qtyInput.addEventListener('change', function () {
      let val = parseInt(qtyInput.value);
      if (isNaN(val) || val < minVal) qtyInput.value = minVal;
      else if (val > maxVal) qtyInput.value = maxVal;
      qtyInput.dispatchEvent(new Event('qty:settled'));
    });
  });

  // Dropzone bukti transfer: tampilkan nama file & preview saat dipilih
  document.querySelectorAll('.dropzone-input').forEach(function (input) {
    const zone = input.closest('.dropzone');
    if (!zone) return;
    const label = zone.querySelector('.dropzone-label');
    input.addEventListener('change', function () {
      if (input.files && input.files[0]) {
        zone.classList.add('border-secondary', 'bg-secondary/5');
        zone.classList.remove('border-gray-200');
        if (label) label.textContent = input.files[0].name;
      }
    });
  });
});

// Wrapper SweetAlert2 reusable
function toastSuccess(message) {
  if (!window.Swal) return alert(message);
  Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: message,
    showConfirmButton: false,
    timer: 2200,
    timerProgressBar: true,
  });
}

function toastError(message) {
  if (!window.Swal) return alert(message);
  Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'error',
    title: message,
    showConfirmButton: false,
    timer: 2800,
  });
}

function confirmAction(message, callback) {
  if (!window.Swal) {
    if (confirm(message)) callback();
    return;
  }
  Swal.fire({
    title: 'Konfirmasi',
    text: message,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#7A2E1D',
    cancelButtonColor: '#9ca3af',
    confirmButtonText: 'Ya, lanjutkan',
    cancelButtonText: 'Batal',
  }).then((result) => {
    if (result.isConfirmed) callback();
  });
}

// Hubungkan tombol/form dengan data-confirm="pesan" agar munculkan dialog sebelum submit
document.addEventListener('submit', function (e) {
  const form = e.target;
  if (form.hasAttribute('data-confirm')) {
    e.preventDefault();
    confirmAction(form.getAttribute('data-confirm'), () => form.submit());
  }
});

// Tampilkan flash message dari session (dipanggil manual di view via window.__flash)
window.showFlash = function (type, message) {
  if (!message) return;
  if (type === 'success') toastSuccess(message);
  else toastError(message);
};
