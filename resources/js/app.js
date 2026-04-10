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

//SIDEBAR
window.toggleSidebar = function () {
    const sidebar = document.getElementById('sidebar');
    const content = document.querySelector('[data-content]');

    sidebar.classList.toggle('sidebar-hidden');

    // adjust content spacing (desktop)
    if (window.innerWidth >= 768) {
        content.classList.toggle('md:ml-[260px]');
    }
}