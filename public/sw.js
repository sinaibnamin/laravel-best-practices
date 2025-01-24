const CACHE_NAME = 'lottery-string-v3s';

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(async (cache) => {
            const cacheAssets = [
                '/admin_assets/dist/css/alt/adminlte.components.css',
                '/admin_assets/dist/js/adminlte.min.js',
                '/admin_assets/plugins/jquery/jquery.min.js',
                '/admin_assets/dist/css/adminlte.min.css',
                '/admin_assets/dist/css/fw6/css/all.css',
                '/admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js',
                '/admin_assets/dist/js/adminlte.js',
                'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback',
                '/admin_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css',
                '/admin_assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css',
                // '/admin_assets/dist/css/custom.css',
                'https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.js',
                '/admin_assets/dist/css/fw6/webfonts/fa-sharp-solid-900.woff2',
                '/admin_assets/dist/css/fw6/webfonts/fa-solid-900.woff2',
                '/admin_assets/dist/css/fw6/webfonts/fa-sharp-light-300.woff2',
                '/admin_assets/dist/css/fw6/webfonts/fa-regular-400.woff2',
                '/admin_assets/dist/css/fw6/webfonts/fa-sharp-regular-400.woff2',

                // '/admin_assets/dist/js/menu_active.js',
                '/admin_assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
                'https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.css',
            ];
            // console.log('Caching all paths:', cacheAssets);
            try {
              for (const asset of cacheAssets) {
                  await cache.add(asset);
                  // console.log('added', asset);
              }
            //   console.log('All assets cached successfully');
          } catch (error) {
              console.error('Failed to cache asset:', error);
          }
        })
    );
});

// Activate the service worker and clean up old caches
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(
                keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))
            );
        })
    );
});

// Fetch from cache first, then from network
self.addEventListener('fetch', event => {
  event.respondWith(
      caches.match(event.request).then(response => {
          if (response) {
              // console.log(`Serving ${event.request.url} from cache.`);
              return response; // Serve from cache
          }

          // console.log(`Fetching ${event.request.url} from network.`);
          return fetch(event.request).catch(error => {
              console.error('Network request failed:', error);
              throw error; // Rethrow to prevent swallowing the error
          });
      })
  );
});