import '@github/relative-time-element'
import Alpine from 'alpinejs'
import ajax from '@imacrayon/alpine-ajax'

Alpine.plugin(ajax)

let components = Array.from(['sortable']).filter(name => {
    return document.querySelector(`[x-data^="${name}"]`)
}).map(async name => {
    Alpine.data(name, (await import(`./components/${name}.js`)).default)
})

Promise.all(components).then(() => {
    Alpine.start()
    window.Alpine = Alpine
})
