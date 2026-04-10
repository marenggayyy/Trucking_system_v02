import './bootstrap';

import Alpine from 'alpinejs';

import '../css/app.css';
import '../css/sidebar.css'; // ✅ ADD THIS

window.Alpine = Alpine;

Alpine.start();

window.toggleOperations = function () {
    const menu = document.getElementById('operationsMenu');
    const arrow = document.getElementById('operationsArrow');

    menu.classList.toggle('hidden');
    arrow.classList.toggle('rotate');
}

//SIDEBAR//
window.toggleSidebar = function () {
    const sidebar = document.getElementById('sidebar');
    const content = document.querySelector('[data-content]');

    if (window.innerWidth < 768) {
        // 📱 MOBILE → overlay mode
        sidebar.classList.toggle('show');
    } else {
        // 💻 DESKTOP → push layout
        const isHidden = sidebar.classList.contains('sidebar-hidden');

        if (isHidden) {
            sidebar.classList.remove('sidebar-hidden');
            content.classList.remove('content-expanded');
        } else {
            sidebar.classList.add('sidebar-hidden');
            content.classList.add('content-expanded');
        }
    }
}

document.addEventListener('click', function (e) {
    const sidebar = document.getElementById('sidebar');

    if (window.innerWidth < 768) {
        if (!sidebar.contains(e.target) && !e.target.closest('button')) {
            sidebar.classList.remove('show');
        }
    }
});

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        document.getElementById('sidebar').classList.remove('show');
    }
});
