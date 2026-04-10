export function initTrips() {
    initSelect2();
    initPaginatedLists();
    initPerPageSubmit();
    initCollapseToggle();
    initHelperFilter();
    initDestinationTruckFilter();
    initAvatarColors();
}

/* =============================
   SELECT2
============================= */
function initSelect2() {
    const modal = document.getElementById('newTripModal');
    if (!modal || !window.jQuery?.fn?.select2) return;

    modal.addEventListener('shown.bs.modal', () => {
        const $el = $('.select2-destination');

        if ($el.length && !$el.hasClass('select2-hidden-accessible')) {
            $el.select2({
                placeholder: 'Search destination...',
                allowClear: true,
                width: '100%',
                dropdownParent: $('#newTripModal')
            });
        }
    });
}

/* =============================
   PAGINATION (CLIENT SIDE)
============================= */
function initPaginatedLists() {
    document.querySelectorAll('.ui-paginated-list').forEach(list => {
        setupPagination(list, list.dataset.target);
    });
}

function setupPagination(container, key) {
    const perPage = parseInt(container.dataset.perPage || "5", 10);
    const items = [...container.querySelectorAll('.ui-list-item')];
    const controls = document.querySelector(`.ui-list-controls[data-controls="${key}"]`);

    if (!items.length) return;

    let page = 1;
    const totalPages = Math.ceil(items.length / perPage);

    const render = () => {
        const start = (page - 1) * perPage;
        const end = start + perPage;

        items.forEach((el, i) => {
            el.style.display = (i >= start && i < end) ? '' : 'none';
        });

        if (controls) {
            controls.querySelector('.ui-list-page').textContent = `${page} / ${totalPages}`;
            controls.querySelector('.ui-list-prev').disabled = page <= 1;
            controls.querySelector('.ui-list-next').disabled = page >= totalPages;
        }
    };

    controls?.querySelector('.ui-list-prev')?.addEventListener('click', () => {
        if (page > 1) page--, render();
    });

    controls?.querySelector('.ui-list-next')?.addEventListener('click', () => {
        if (page < totalPages) page++, render();
    });

    render();
}

/* =============================
   PER PAGE (SERVER SIDE)
============================= */
function initPerPageSubmit() {
    const select = document.querySelector('select[name="per_page"]');
    if (!select?.form) return;

    select.addEventListener('change', function () {
        const form = this.form;
        form.querySelector('input[name="page"]')?.remove();
        form.submit();
    });
}

/* =============================
   COLLAPSE TOGGLE
============================= */
function initCollapseToggle() {
    document.querySelectorAll('.collapse-toggle').forEach(btn => {

        const target = document.querySelector(btn.dataset.target);
        if (!target) return;

        const collapse = new bootstrap.Collapse(target, { toggle: false });

        btn.addEventListener('click', () => {
            const isOpen = target.classList.contains('show');

            collapse[isOpen ? 'hide' : 'show']();

            const icon = btn.querySelector('i');
            icon.classList.toggle('bi-eye', isOpen);
            icon.classList.toggle('bi-eye-slash', !isOpen);
        });
    });
}

/* =============================
   HELPER FILTER (FIXED BUG)
============================= */
function initHelperFilter() {
    const helper1 = document.getElementById('helper1');
    const helper2 = document.getElementById('helper2');

    if (!helper1 || !helper2) return;

    const filter = () => {
        const selected = helper1.value;

        [...helper2.options].forEach(opt => {
            if (!opt.value) return;

            opt.style.display = opt.value === selected ? 'none' : 'block';
        });

        if (helper2.value === selected) helper2.value = '';
    };

    helper1.addEventListener('change', filter);
}

/* =============================
   DESTINATION + TRUCK FILTER (MERGED)
============================= */
function initDestinationTruckFilter() {

    const $dest = $('#destinationSelect');
    const $truck = $('#truckSelect');

    if (!$dest.length || !$truck.length) return;

    const filterOptions = (selector, typeAttr, value) => {
        selector.find('option').each(function () {
            const type = this.dataset[typeAttr];

            const match = value === 'all' || type === value;

            $(this)
                .prop('disabled', !match)
                .prop('hidden', !match)
                .toggleClass('enabled-option', match);
        });
    };

    const applyFilter = (type) => {
        filterOptions($dest, 'truck', type);
        filterOptions($truck, 'type', type);

        $dest.val('').trigger('change');
        $truck.val('').trigger('change');
    };

    $('input[name="destination_type_filter"]').on('change', function () {
        applyFilter(this.value);
    });

    $dest.on('select2:select', function (e) {
        const selected = e.params.data.element.dataset.truck;

        $truck.find('option').each(function () {
            $(this).prop('hidden', this.dataset.type !== selected);
        });

        $truck.val('').trigger('change');
    });
}

/* =============================
   AVATAR COLORS
============================= */
function initAvatarColors() {
    document.querySelectorAll('.person-avatar').forEach(el => {
        const char = (el.dataset.initial || 'A').charCodeAt(0);
        const index = (char % 8) + 1;
        el.classList.add(`color-${index}`);
    });
}

