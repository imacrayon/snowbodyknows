import Sortable from 'sortablejs/modular/sortable.core.esm.js';

export default function (endpoint) {
    return {
        init() {
            new Sortable(this.$el, {
                handle: '[data-handle]',
                dragClass: 'sortable-drag',
                ghostClass: 'sortable-ghost',
                animation: 150,
                onEnd() {
                    let body = new FormData()
                    this.toArray().forEach(id => body.append('sort[]', id))

                    fetch(endpoint, {
                        method: 'post',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                        },
                        body,
                    })
                }
            })
        }
    }
}
