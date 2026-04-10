import './bootstrap';
import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
// preline
import 'preline'

window.Alpine = Alpine

Alpine.plugin(collapse)

Alpine.store('sidebar', {
    isExpanded: true,
    isMobileOpen: false,

    toggleExpanded() {
        this.isExpanded = !this.isExpanded
    },

    toggleMobileOpen() {
        this.isMobileOpen = !this.isMobileOpen
    },

    closeMobile() {
        this.isMobileOpen = false
    }
})

Alpine.start()