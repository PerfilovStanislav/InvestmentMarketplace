self.addEventListener('install', event => {
    event.waitUntil(
        caches.open('richinme')
            .then(cache => {
                cache.addAll([
                    // '/',
                    '/favicon.ico',
                    '/assets/full/full.js',
                    '/assets/full/full.css',
                    // '/src/js/chart.js',
                    // '/src/js/materialize.js',
                    // '/src/js/materialize.min.js',
                    // '/src/css/materialize.css',
                    // '/src/css/materialize.min.css',
                    // '/src/css/style.css',
                    // 'https://fonts.googleapis.com/icon?family=Material+Icons',
                    // 'https://code.jquery.com/jquery-2.1.1.min.js',
                    // 'https://cdn.jsdelivr.net/npm/chart.js@2.8.0'
                ]);
            }));
});

/*
self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open('v1').then(function(cache) {
      return cache.addAll([
        '/',
        '/assets/sw-test/style.css',
        '/assets/sw-test/app.js',
        '/assets/sw-test/image-list.js',
        '/assets/sw-test/star-wars-logo.jpg',
        '/assets/sw-test/gallery/bountyHunters.jpg',
        '/assets/sw-test/gallery/myLittleVader.jpg',
        '/assets/sw-test/gallery/snowTroopers.jpg'
      ]);
    })
  );
});
*/

// self.addEventListener('fetch', event => {
//     event.respondWith(
//         caches.match(event.request)
//             .then(response => {
//                 if (response) {
//                     return response;
//                 } else {
//                     return fetch(event.request);
//                 }
//             })
//     );
// });

self.addEventListener('fetch', event => {
  // В случае не-GET запроса браузер должен сам обрабатывать его
    console.log('request', event)
  if (event.request.method !== 'GET') return;

  // Обрабатываем запрос с помощью логики service worker
  event.respondWith(async function() {
    // Пытаемся получить ответ из кеша.
    const cache = await caches.open('richinme');
    // console.log(cache)
    const cachedResponse = await cache.match(event.request);

    console.log(event, cachedResponse)

    if (cachedResponse) {
      // Если кеш был найден, возвращаем данные из него
      // и запускаем фоновое обновление данных в кеше.
      event.waitUntil(cache.add(event.request));
      return cachedResponse;
    }

    // В случае, если данные не были найдены в кеше, получаем их с сервера.
    console.log('not cached ' + event.request.url)
    return fetch(event.request);
  }());
});
