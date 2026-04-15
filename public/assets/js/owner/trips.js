/* =========================================================
   TRIPS MODULE SCRIPT
========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       SELECT2 INIT (NEW TRIP MODAL)
    ===================================================== */
    initSelect2Destination();


    /* =====================================================
       AVAILABLE RESOURCE PAGINATION
    ===================================================== */
    document.querySelectorAll('.ui-paginated-list').forEach(list => {
        initPaginatedList(list, list.dataset.target);
    });


    /* =====================================================
       PER PAGE DROPDOWN AUTO SUBMIT
    ===================================================== */
    initPerPageDropdown();


    /* =====================================================
       AVAILABLE RESOURCE COLLAPSE TOGGLE
    ===================================================== */
    initCollapseToggles();


    /* =====================================================
       HELPER DUPLICATE FILTERING
    ===================================================== */
    initHelperFilter();


    /* =====================================================
       DESTINATION / TRUCK TYPE FILTERING
    ===================================================== */
    initDestinationTruckFiltering();


    /* =====================================================
       PERSON AVATAR COLORS
    ===================================================== */
    initAvatarColors();


    /* =====================================================
       DESTINATION → TRUCK FILTER (MODAL GENERIC)
    ===================================================== */
    initDestinationTruckDependency();
});


/* =========================================================
   SELECT2 DESTINATION
========================================================= */
function initSelect2Destination() {
    const modal = document.getElementById('newTripModal');
    if (!modal) return;

    modal.addEventListener('shown.bs.modal', function () {
        if (
            !window.jQuery ||
            !window.jQuery.fn ||
            typeof window.jQuery.fn.select2 !== 'function'
        ) return;

        const $el = window.jQuery('.select2-destination');

        if ($el.length && !$el.hasClass('select2-hidden-accessible')) {
            $el.select2({
                placeholder: 'Search destination...',
                allowClear: true,
                width: '100%',
                dropdownParent: window.jQuery('#newTripModal')
            });
        }
    });
}


/* =========================================================
   AVAILABLE LIST PAGINATION
========================================================= */
function initPaginatedList(container, key) {
    const perPage = parseInt(container.dataset.perPage || '5', 10);
    const items = Array.from(container.querySelectorAll('.ui-list-item'));
    const controls = document.querySelector(
        `.ui-list-controls[data-controls="${key}"]`
    );

    if (!items.length) return;

    let page = 1;
    const totalPages = Math.ceil(items.length / perPage);

    function render() {
        const start = (page - 1) * perPage;
        const end = start + perPage;

        items.forEach((item, index) => {
            item.style.display =
                index >= start && index < end ? '' : 'none';
        });

        if (!controls) return;

        controls.querySelector('.ui-list-page').textContent =
            `${page} / ${totalPages}`;

        controls.querySelector('.ui-list-prev').disabled =
            page <= 1;

        controls.querySelector('.ui-list-next').disabled =
            page >= totalPages;
    }

    if (controls) {
        controls.querySelector('.ui-list-prev')
            .addEventListener('click', function () {
                if (page > 1) {
                    page--;
                    render();
                }
            });

        controls.querySelector('.ui-list-next')
            .addEventListener('click', function () {
                if (page < totalPages) {
                    page++;
                    render();
                }
            });
    }

    render();
}


/* =========================================================
   PER PAGE DROPDOWN
========================================================= */
function initPerPageDropdown() {
    const perPageSelect = document.querySelector('select[name="per_page"]');

    if (!perPageSelect || !perPageSelect.form) return;

    perPageSelect.addEventListener('change', function () {
        const form = this.form;

        const pageInput = form.querySelector('input[name="page"]');
        if (pageInput) pageInput.remove();

        form.submit();
    });
}


/* =========================================================
   COLLAPSE TOGGLE BUTTONS
========================================================= */
function initCollapseToggles() {
    document.querySelectorAll('.collapse-toggle').forEach(btn => {

        const targetSelector = btn.dataset.target;
        const targetEl = document.querySelector(targetSelector);

        if (!targetEl) return;

        const collapse = new bootstrap.Collapse(targetEl, {
            toggle: false
        });

        btn.addEventListener('click', function () {

            const icon = btn.querySelector('i');
            const isOpen = targetEl.classList.contains('show');

            if (isOpen) {
                collapse.hide();

                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');

            } else {
                collapse.show();

                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    });
}


/* =========================================================
   HELPER FILTERING
========================================================= */
function initHelperFilter() {
    const helper1 = document.getElementById('helper1');
    const helper2 = document.getElementById('helper2');

    if (!helper1 || !helper2) return;

    function filterHelpers() {
        const selectedHelper1 = helper1.value;

        Array.from(helper2.options).forEach(option => {

            if (option.value === '') return;

            option.style.display =
                option.value === selectedHelper1
                    ? 'none'
                    : 'block';
        });

        if (helper2.value === selectedHelper1) {
            helper2.value = '';
        }
    }

    helper1.addEventListener('change', filterHelpers);
}


/* =========================================================
   DESTINATION / TRUCK TYPE FILTERING
========================================================= */
function initDestinationTruckFiltering() {
    const destinationSelect = $('#destinationSelect');
    const truckSelect = $('#truckSelect');

    if (!destinationSelect.length || !truckSelect.length) return;

    function applyTypeFilter(type) {

        $('#destinationSelect option').each(function () {
            const destType = this.dataset.truck;

            if (type === 'all') {
                $(this).prop('disabled', false).prop('hidden', false);
                $(this).addClass('enabled-option');
            } else {
                const isMatch = destType === type;

                $(this)
                    .prop('disabled', !isMatch)
                    .prop('hidden', !isMatch);

                $(this).toggleClass('enabled-option', isMatch);
            }
        });

        destinationSelect.val('').trigger('change.select2');
        destinationSelect.trigger('change');

        $('#truckSelect option').each(function () {
            const truckType = this.dataset.type;

            if (type === 'all') {
                $(this).prop('disabled', false).prop('hidden', false);
                $(this).addClass('enabled-option');
            } else {
                const isMatch = truckType === type;

                $(this)
                    .prop('disabled', !isMatch)
                    .prop('hidden', !isMatch);

                $(this).toggleClass('enabled-option', isMatch);
            }
        });

        truckSelect.val('').trigger('change');
    }

    document.querySelectorAll(
        'input[name="destination_type_filter"]'
    ).forEach(radio => {
        radio.addEventListener('change', function () {
            applyTypeFilter(this.value);
        });
    });

    destinationSelect.on('select2:select', function (e) {

        const selectedOption = e.params.data.element;
        const requiredTruck = selectedOption.dataset.truck;

        $('#truckSelect option').each(function () {

            const type = this.dataset.type;

            if (!type) return;

            $(this).prop('hidden', type !== requiredTruck);
        });

        truckSelect.val('').trigger('change');
    });
}


/* =========================================================
   PERSON AVATAR COLORIZER
========================================================= */
function initAvatarColors() {
    document.querySelectorAll('.person-avatar').forEach(el => {

        const initial = el.dataset.initial || 'A';
        const index = (initial.charCodeAt(0) % 8) + 1;

        el.classList.add(`color-${index}`);
    });
}


/* =========================================================
   GENERIC DESTINATION → TRUCK DEPENDENCY
========================================================= */
function initDestinationTruckDependency() {
    document.querySelectorAll(
        'select[name="destination_id"]'
    ).forEach(destSelect => {

        destSelect.addEventListener('change', function () {

            const selectedOption =
                this.options[this.selectedIndex];

            const selectedTruckType =
                selectedOption.getAttribute('data-truck');

            const modal = this.closest('.modal');
            const truckSelect =
                modal.querySelector('select[name="truck_id"]');

            if (!truckSelect) return;

            truckSelect.value = '';

            Array.from(truckSelect.options).forEach(option => {

                const truckType =
                    option.getAttribute('data-truck');

                option.style.display =
                    !truckType || truckType === selectedTruckType
                        ? ''
                        : 'none';
            });
        });
    });
}