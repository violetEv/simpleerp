import './bootstrap';
import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
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
    selectedOption: null,
    placeholder: config.placeholder || 'Pilih data...',
    searchPlaceholder: config.searchPlaceholder || 'Cari',
    disabled: false,
    onChange: config.onChange || null,

    init() {
        this.syncSelected()

        this.$watch('selected', () => {
            this.syncSelected()
        })
    },

    syncSelected() {
        this.selectedOption = this.options.find(o => o.value == this.selected) || null
    },

    toggle() {
        if (this.disabled) return
        this.open = !this.open
    },

    select(option) {
        this.selected = option.value
        this.selectedOption = option
        this.open = false

        if (this.onChange && typeof window[this.onChange] === 'function') {
            window[this.onChange](option)
        }
    },

    get selectedLabel() {
        return this.selectedOption ? this.selectedOption.label : this.placeholder
    },

    // untuk search
    get filteredOptions() {
        if (!this.search) return this.options
        return this.options.filter(option => option.label.toLowerCase().includes(this.search.toLowerCase()))
    }
}))

Alpine.start()

window.addEventListener('load', () => {
    if (window.HSStaticMethods) {
        window.HSStaticMethods.autoInit();
    }
});

// refresh table
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

        loadData();
        setInterval(loadData, interval);
    });
});