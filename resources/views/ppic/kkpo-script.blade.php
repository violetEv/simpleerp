    <script>
        const modal = document.getElementById('addModal')
        const form = document.getElementById('crud-form')

        function openModal() {
            modal.classList.remove('hidden')
            modal.classList.add('flex')
        }

        function closeModal() {
            modal.classList.add('hidden')
            modal.classList.remove('flex')
        }

        function resetForm() {
            form.reset()

            // reset semua select Alpine
            document.querySelectorAll('[x-data]').forEach(el => {
                if (el.__x) {
                    el.__x.$data.selected = ''
                }
            })
        }

        function setSelect({
            options,
            selected,
            placeholder
        }) {
            return {
                open: false,
                search: '',
                options: options,
                selected: selected,
                placeholder: placeholder,

                get selectedLabel() {
                    const found = this.options.find(o => o.value == this.selected)
                    return found ? found.label : ''
                },

                get filteredOptions() {
                    return this.options.filter(o =>
                        o.label.toLowerCase().includes(this.search.toLowerCase())
                    )
                },

                toggle() {
                    this.open = !this.open
                },

                select(option) {
                    this.selected = option.value
                    this.open = false
                },

                isSelected(value) {
                    return this.selected == value
                }
            }
        }

        function fillForm(data) {
            document.getElementById('no_kkpo').value = data.no_kkpo ?? ''
            document.getElementById('kp_po').value = data.kp_po ?? ''
            document.getElementById('qty_total').value = data.qty_total ?? ''
            document.getElementById('price').value = data.price ?? ''
            document.getElementById('reject_allowance').value = data.reject_allowance ?? ''

            setSelect('customer_id', data.customer_id)
            setSelect('category_id', data.category_id)
            setSelect('style_id', data.style_id)
            setSelect('color_id', data.color_id)
            setSelect('item_id', data.item_id)
            setSelect('brand_id', data.brand_id)
            setSelect('unit_id', data.unit_id)
            setSelect('currency_id', data.currency_id)
        }

        function openAddModal() {
            resetForm()

            document.getElementById('modal-title').textContent = 'Add KKPO'
            document.getElementById('submit-button').textContent = 'Add KKPO'

            form.action = "{{ route('ppic.kkpomanagement.store') }}"
            document.getElementById('form-method').value = 'POST'

            openModal()
        }

        function openEditModal(data) {
            resetForm()

            document.getElementById('modal-title').textContent = 'Edit KKPO'
            document.getElementById('submit-button').textContent = 'Update KKPO'

            let url = "{{ route('ppic.kkpomanagement.update', ':id') }}"
            url = url.replace(':id', data.id)

            form.action = url
            document.getElementById('form-method').value = 'PUT'

            openModal()

            setTimeout(() => {
                fillForm(data)
            }, 100)
        }
    </script>
