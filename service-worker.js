const CACHE_NAME = 'portfolio-cache-v1';
const ASSETS_TO_CACHE = [
    './',
    './index.html',
    './a-propos.html',
    './projets.html',
    './contact.html',
    './asset/style/styles.css',
    './asset/style/a-propos.css',
    './asset/js/script.js',
    './asset/js/projets.js',
    './asset/image/Projet-farm-ia.png',
    './asset/image/css-logo.png',
    './asset/image/edugen pro.png',
    './asset/image/eduqtoi.png',
    './asset/image/html-logo-2.webp',
    './asset/image/js-logo-2.webp',
    './asset/image/photo-de-milann-lede.jpeg',
    './asset/image/portfolio-tristan.png',
    './asset/image/projet-ecole.png'
];

// Installation : Mise en cache des ressources
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log('[Service Worker] Mise en cache des fichiers');
                return cache.addAll(ASSETS_TO_CACHE);
            })
    );
});

// Activation : Nettoyage des anciens caches
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keyList) => {
            return Promise.all(
                keyList.map((key) => {
                    if (key !== CACHE_NAME) {
                        console.log('[Service Worker] Suppression de l\'ancien cache', key);
                        return caches.delete(key);
                    }
                })
            );
        })
    );
});

// Fetch : Récupération depuis le cache ou le réseau
self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request)
            .then((response) => {
                // Retourne la ressource si elle est dans le cache
                if (response) {
                    return response;
                }
                // Sinon, la récupère sur le réseau
                return fetch(event.request).then(
                    (response) => {
                        // Vérifie si la réponse est valide
                        if (!response || response.status !== 200 || response.type !== 'basic') {
                            return response;
                        }

                        // Met en cache la nouvelle ressource pour le futur
                        const responseToCache = response.clone();
                        caches.open(CACHE_NAME)
                            .then((cache) => {
                                cache.put(event.request, responseToCache);
                            });

                        return response;
                    }
                );
            })
    );
});
