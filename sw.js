'use strict';
let deferredPrompt;

self.addEventListener('beforeinstallprompt', (e) => {
    console.log('asd');
    e.preventDefault();
    deferredPrompt = e;
});

self.addEventListener('install', async event => {
    self.skipWaiting();
    event.waitUntil(
        caches.open('richinme')
            .then(cache => {
                cache.addAll([
                    '/',
                    '/favicon.ico',
                    '/assets/js/my-addons.js',
                    '/assets/icons/favicon-16x16.png',
                    '/assets/icons/favicon-32x32.png',
                    // '/assets/full/full.css',
                    '/site.webmanifest',
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

// self.addEventListener('activate', function (event) {
//     event.waitUntil(
//         caches.keys().then(function (cacheNames) {
//             return Promise.all(
//                 cacheNames
//                     .filter(function (cacheName) {
//                         console.log('remove ?', cacheName)
//                         // Return true if you want to remove this cache,
//                         // but remember that caches are shared across
//                         // the whole origin
//                     })
//                     .map(function (cacheName) {
//                         return caches.delete(cacheName);
//                     }),
//             );
//         }),
//     );
// });


// addEventListener('fetch', function(event) {
//     event.respondWith(
//         caches.match(event.request)
//             .then(function(response) {
//                 if (response) {
//                     return response;     // if valid response is found in cache return it
//                 } else {
//                     return fetch(event.request)     //fetch from internet
//                         .then(function(res) {
//                             return caches.open('richinme')
//                                 .then(function(cache) {
//                                     cache.put(event.request.url, res.clone());    //save the response for future
//                                     return res;   // return the fetched data
//                                 })
//                         })
//                         .catch(function(err) {       // fallback mechanism
//                             return caches.open('errors')
//                                 .then(function(cache) {
//                                     return cache.match('/');
//                                 });
//                         });
//                 }
//             })
//     );
// });

self.addEventListener('fetch', event => {
    const url = new URL(event.request.url)

    if (url.host !== location.host) {
        return false;
    }

    if (typeof event !== 'object') {
        console.warn(event)
    }

    const cache = caches.open('richinme');
    event.respondWith((async () => {
        const forceCached = ['/site.webmanifest', '/favicon.ico', '/']

        /*if (
            url.pathname.indexOf('/assets/') === 0 ||
            url.pathname.indexOf('/screens/') === 0 ||
            forceCached.indexOf(url.pathname) !== -1
        ) {
            const cachedResponse = await cache.match(await event.request);
            if (cachedResponse) {
                return cachedResponse;
            }
        }*/

        if (event.request.method === 'POST') {
            return fetch(event.request).then(async response => {
                if (response && response.statusText === 'OK' && response.type === 'basic' ) {
                    // const cache = await caches.open('richinme');
                    await cache.put(event.request, response.clone());
                }
                return response;
            }).catch(async err => {
                return cache.match(event.request).then(async res => {
                    return res
                }).catch(err => {
                    console.log('err', err)
                    return new Response(JSON.parse('{"alert": {"document": {"danger": {"hhh": "yyy"}}}}'),
                        {headers: {"Content-Type": "application/json"}});
                });
            });
        }

        if (event.request.method === 'GET') {
            if (
                url.pathname.indexOf('/assets/') === 0 ||
                url.pathname.indexOf('/screens/') === 0 ||
                forceCached.indexOf(url.pathname) !== -1
            ) {
                return fetch(event.request).then(async response => {
                    if (response && response.statusText === 'OK' && response.type === 'basic' ) {
                        const cache = caches.open('richinme');
                        await cache.put(event.request, response.clone());
                    }
                    return response;
                }).catch(async err => {
                    const cache = caches.open('richinme');
                    return cache.match(event.request).catch(err => {
                        console.log('err', err)
                        return new Response();
                    });
                });
            } else {
                return fetch(event.request).then(async response => {
                    return response;
                }).catch(async err => {
                    fetch(event.request)
                    const cache = caches.open('richinme');
                    return await cache.match('/')
                });
            }
        }
    })());
});

