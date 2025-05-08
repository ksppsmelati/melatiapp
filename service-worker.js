const CACHE_NAME_STATIC = 'melatiapp-static-cache-v8';

// Daftar aset statis yang ingin di-cache
const STATIC_ASSETS = [
  '/assets/css/bootstrap.css',
  '/assets/css/colors.css',
  '/assets/css/components.css',
  '/assets/css/core.css',
  '/assets/css/main.css',
  '/assets/css/icons/fontawesome/styles.min.css',
  '/js/core/app.js',
  '/js/core/libraries/bootstrap.min.js',
  '/js/core/libraries/jquery.min.js',
  '/assets/css/icons/icomoon/styles.css',
  '/assets/js/plugins/loaders/pace.min.js',
  '/assets/js/plugins/loaders/blockui.min.js',
  '/assets/js/plugins/forms/styling/switchery.min.js',
  '/assets/js/plugins/forms/styling/uniform.min.js',
  '/assets/js/plugins/forms/selects/bootstrap_multiselect.js',
  '/assets/js/plugins/ui/moment/moment.min.js',
  '/assets/js/plugins/pickers/daterangepicker.js',
  '/assets/calender/js/pignose.calendar.js',
  '/assets/css/melatiapp.css',
  '/assets/js/select2.min.js',
  'https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.all.min.js',
  'https://code.jquery.com/jquery-3.6.0.min.js',
  'https://code.jquery.com/ui/1.12.1/jquery-ui.js',
  'https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js',
  'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css',
  'https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css',
];

// Install Service Worker
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME_STATIC).then(cache => {
      return cache.addAll(STATIC_ASSETS);
    })
  );
  self.skipWaiting(); // Aktifkan worker setelah install
});

// Fetch event - Stale-while-revalidate untuk aset statis
self.addEventListener('fetch', event => {
  const requestURL = new URL(event.request.url);

  // Untuk aset statis
  if (STATIC_ASSETS.includes(requestURL.pathname)) {
    event.respondWith(
      caches.match(event.request).then(cachedResponse => {
        const fetchPromise = fetch(event.request).then(networkResponse => {
          // Simpan versi terbaru dari aset statis di cache
          return caches.open(CACHE_NAME_STATIC).then(cache => {
            cache.put(event.request, networkResponse.clone());
            return networkResponse;
          });
        });

        // Kembalikan cache yang tersedia segera, atau tunggu hasil dari jaringan jika tidak ada di cache
        return cachedResponse || fetchPromise;
      })
    );
  } else {
    // Untuk data dinamis yang berasal dari MySQL, selalu fetch dari jaringan
    event.respondWith(
      fetch(event.request).catch(() => {
        // Jika jaringan gagal, tidak ada fallback (karena aplikasi tidak bisa digunakan offline)
        return new Response('Network error. Please check your connection.', { status: 503 });
      })
    );
  }
});

// Aktivasi Service Worker dan bersihkan cache lama
self.addEventListener('activate', event => {
  const cacheWhitelist = [CACHE_NAME_STATIC]; // Whitelist hanya untuk aset statis

  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (!cacheWhitelist.includes(cacheName)) {
            return caches.delete(cacheName); // Hapus cache lama
          }
        })
      );
    })
  );
  self.clients.claim(); // Ambil alih semua client aktif
});
