import './bootstrap';
import Alpine from 'alpinejs';

import '../css/app.css';
import '../css/sidebar.css';
// import '../css/modules/trips.css';

// import { initTrips } from './modules/trips';

window.Alpine = Alpine;
Alpine.start();

/* =========================
   GLOBAL FUNCTIONS
========================= */
window.toggleOperations = function () {
    const menu = document.getElementById('operationsMenu');
    const arrow = document.getElementById('operationsArrow');

    menu?.classList.toggle('hidden');
    arrow?.classList.toggle('rotate');
};

window.toggleFinance = function () {
    const menu = document.getElementById('financeMenu');
    const arrow = document.getElementById('financeArrow');

    menu?.classList.toggle('hidden');
    arrow?.classList.toggle('rotate');
};

window.toggleManagement = function () {
    const menu = document.getElementById('managementMenu');
    const arrow = document.getElementById('managementArrow');

    menu?.classList.toggle('hidden');
    arrow?.classList.toggle('rotate');
};

window.toggleSidebar = function () {
    const sidebar = document.getElementById('sidebar');
    const content = document.querySelector('[data-content]');

    if (!sidebar || !content) return;

    if (window.innerWidth < 768) {
        sidebar.classList.toggle('show');
    } else {
        const isHidden = sidebar.classList.contains('sidebar-hidden');

        sidebar.classList.toggle('sidebar-hidden', !isHidden);
        content.classList.toggle('content-expanded', !isHidden);
    }
};

/* =========================
   GLOBAL EVENTS
========================= */
document.addEventListener('click', function (e) {
    const sidebar = document.getElementById('sidebar');
    if (!sidebar) return;

    if (window.innerWidth < 768) {
        if (!sidebar.contains(e.target) && !e.target.closest('button')) {
            sidebar.classList.remove('show');
        }
    }
});

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        document.getElementById('sidebar')?.classList.remove('show');
    }
});

/* =========================
   PAGE INIT
========================= */
function initPage() {
    const body = document.body;

    if (body.classList.contains('page-trips')) {
        initTrips();
    }
}

initPage();