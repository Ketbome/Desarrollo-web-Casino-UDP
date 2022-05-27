

self.addEventListener('fetch', (event) => {

  /**
   * Cache Strategy Network first, Cache fallback
   */
  if (event.request.headers.get('accept').includes('application/json')) {
    event.respondWith((async () => {
      try {
        const response = await fetch(event.request)
        const cache = await caches.open('dynamic_files')

        cache.put(event.request.url, response.clone())
        console.log('Return from fetch %s', event.request.url)

        return response

      } catch (error) {
        const cached = await caches.match(event.request)

        if (cached) {
          console.log('Return from cache %s', event.request.url)
          return cached
        }

        throw error
      }
    })())

    return
  }

  /**
   * Cache Strategy Cache first, Network fallback
   */
  if (event.request.method === 'GET') {
    // fetch dynamic files the first time and return the second time from the cache
    event.respondWith((async () => {
      const response = await caches.match(event.request)

      if (response) return response;

      console.log('Dynamic Caching: %s', event.request.url)
      const result = await fetch(event.request)
      const cache = await caches.open('dynamic_files')

      cache.put(event.request.url, result.clone())

      return result
    })())
  }
})