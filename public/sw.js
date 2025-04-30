importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.2.0/workbox-sw.js');

// Instant update service worker
workbox.core.skipWaiting();
workbox.core.clientsClaim();

// Default strategy set ke NetworkOnly
// Artinya semua request yang tidak terdaftar di strategi selanjutnya akan selalu request ke server
workbox.routing.setDefaultHandler(new workbox.strategies.NetworkOnly());

// CacheFirst
// Daftarkan disini request yang ingin dicache dan nyaris ga akan pernah diupdate
workbox.routing.registerRoute(
  ({request}) => request.destination === 'image',
  new workbox.strategies.CacheFirst()
);
workbox.routing.registerRoute(
  /^https:\/\/unpkg.com/,
  new workbox.strategies.CacheFirst()
);
workbox.routing.registerRoute(
  /^https:\/\/fonts.gstatic.com/,
  new workbox.strategies.CacheFirst()
);

// Precaching
// Daftarkan disini request static yang sangat jarang berubah
// dan punya penampilan data dinamis yang sudah menggunakan ajax secara penuh
// Ketika pun ada update, tinggal raise revision number
workbox.precaching.precacheAndRoute([
  {url: '/offline', revision: '3' },
  {url: '/mobilekit/assets/img/icon/offline.png', revision: '2' },
]);

// Handle request yang ga ada cachenya dengan halaman offline mode
workbox.routing.setCatchHandler(async ({event}) => {
  switch (event.request.destination) {
    case 'document':
      return workbox.precaching.matchPrecache('/offline');
    break;

    default:
      // If we don't have a fallback, just return an error response.
      return Response.error();
  }
});

// NetworkFirst
// Daftarkan disini request yang masih punya rendering dinamis di server-side (termasuk pengecekan require login)
// Dan hanya butuh menampilkan versi cache saat mode offline
workbox.routing.registerRoute(
  ({url}) => url.pathname.startsWith('/'), // Butuh cek login, slider dan sidebar dinamis SSR
  new workbox.strategies.NetworkFirst()
);
workbox.routing.registerRoute(
  ({url}) => url.pathname.startsWith('/feeds'), // Butuh cek login
  new workbox.strategies.NetworkFirst()
);
workbox.routing.registerRoute(
  ({url}) => url.pathname.startsWith('/feed'), // Butuh cek login
  new workbox.strategies.NetworkFirst()
);

// StaleWhileRevalidate
// Daftarkan disini request yang cukup sering berubah dari server-side
// tapi updatenya tidak terlalu krusial untuk segera ditampilkan
// sehingga bisa pakai cache terakhir untuk mempercepat tampil
// Versi updatenya ditampilkan di request selanjutnya
workbox.routing.registerRoute(
  new RegExp('\\.js$'),
  new workbox.strategies.StaleWhileRevalidate()
);
workbox.routing.registerRoute(
  new RegExp('\\.css$'),
  new workbox.strategies.StaleWhileRevalidate()
);

// Push Notification
self.addEventListener('push', function(event) {
  const data = event.data.json();
  const options = {
    body: data.body,
    icon: data.icon,
    data: { url: data.url }
  };

  event.waitUntil(
    self.registration.showNotification(data.title, options)
  );
});

self.addEventListener('notificationclick', function(event) {
  event.notification.close();
  event.waitUntil(
    clients.openWindow(event.notification.data.url)
  );
});
