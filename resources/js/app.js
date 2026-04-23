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

Alpine.data('selectSearch', (config = {}) => ({
    open: false,
    search: '',
    options: config.options || [],
    selected: config.selected || '',
    placeholder: config.placeholder || 'Pilih data...',

    toggle() {
        this.open = !this.open
    },

    select(option) {
        this.selected = option.value
        this.open = false
    },

    isSelected(value) {
        return this.selected == value
    },

    get selectedLabel() {
        const found = this.options.find(o => o.value == this.selected)
        return found ? found.label : ''
    },

    get filteredOptions() {
        if (!this.search) return this.options

        return this.options.filter(o =>
            o.label.toLowerCase().includes(this.search.toLowerCase())
        )
    }
}))


Alpine.start()
window.addEventListener('load', () => {
    if (window.HSStaticMethods) {
        window.HSStaticMethods.autoInit();
    }
});
// refresh table tanpa load halaman
document.addEventListener("DOMContentLoaded", () => {
    const tables = document.querySelectorAll("[data-autorefresh]");

    tables.forEach(table => {
        const url = table.dataset.url;
        const interval = parseInt(table.dataset.interval) || 30000;

        const loadData = () => {
            fetch(url)
                .then(res => res.text())
                .then(html => {
                    table.style.opacity = 0.5;

                    setTimeout(() => {
                        table.innerHTML = html;
                        table.style.opacity = 1;
                    }, 150);
                })
                .catch(err => console.error("Auto refresh error:", err));
        };

        // load pertama
        loadData();

        // interval
        setInterval(loadData, interval);
    });
});