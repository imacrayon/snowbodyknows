import Sortable from 'sortablejs/modular/sortable.core.esm.js';

export default function (endpoint) {
    return {
        init() {
            let self = this
            this.sortable = new Sortable(this.$el, {
                handle: '[data-handle]',
                dragClass: 'sortable-drag',
                ghostClass: 'sortable-ghost',
                animation: 150,
                onSort() {
                    self.save()
                }
            })
        },
        sortable: null,
        selected: '',
        order: [],
        start: null,
        cleanup: () => { },
        announce(message) {
            document.getElementById('announcer').textContent = message
        },
        toggle(event) {
            if (!this.selected) {
                this.enableKeyboard(event.target)
                this.announce(`Grabbed. Current position in list: ${this.start} of ${this.order.length}. Press up and down arrow to change position, Spacebar to drop, Escape to cancel.`)
            } else {
                this.save()
                let index = this.order.indexOf(this.selected)
                this.announce(`Dropped. Final position in list: ${index + 1} of ${this.order.length}.`)
                this.disableKeyboard()
            }
        },
        enableKeyboard(element) {
            this.selected = element.closest('[data-id]').dataset.id
            this.order = this.sortable.toArray()
            this.start = this.order.indexOf(this.selected)

            let handler = (event) => {
                if (event.key === 'ArrowDown') this.next()
                if (event.key === 'ArrowRight') this.next()
                else if (event.key === 'ArrowUp') this.previous()
                else if (event.key === 'ArrowLeft') this.previous()
                else if (event.key === 'Escape') this.stop()
                else if (event.key === 'Tab') this.selected && event.preventDefault()
            }

            element.addEventListener('keydown', handler)
            this.cleanup = () => element.removeEventListener('keydown', handler)
        },
        disableKeyboard() {
            this.cleanup()
            this.selected = null
            this.order = []
            this.start = null
        },
        next() {
            let index = this.order.indexOf(this.selected)
            let to = index === this.order.length - 1 ? 0 : index + 1
            this.move(index, to)
            this.announce(`New position in list: ${to + 1} of ${this.order.length}.`)
        },
        previous() {
            let index = this.order.indexOf(this.selected)
            let to = index === 0 ? this.order.length - 1 : index - 1
            this.move(index, to)
            this.announce(`New position in list: ${to + 1} of ${this.order.length}.`)
        },
        stop() {
            let index = this.order.indexOf(this.selected)
            this.move(index, this.start)
            this.announce(`Dropped. Re-order cancelled.`)
            this.disableKeyboard()
        },
        move(index, to) {
            this.order.splice(index, 1)
            this.order.splice(to, 0, this.selected)
            let focused = document.activeElement
            this.sortable.sort(this.order, true)
            focused.focus()
        },
        save() {
            let body = new FormData()
            this.sortable.toArray().forEach(id => body.append('sort[]', id))

            fetch(endpoint, {
                method: 'post',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                },
                body,
            })
        }
    }
}
