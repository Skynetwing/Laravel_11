function setActiveMenu() {
    const currentUrl = window.location.href;
    const sidebarLinks = document.querySelectorAll('.sidebar-inner .sidenav-item-link');
    sidebarLinks.forEach(link => {
        if (link.href === currentUrl) {
            const parentLi = link.closest('li');
            if (parentLi) {
                parentLi.classList.add('active');
            }
            const collapseMenu = link.closest('.collapse');
            if (collapseMenu) {
                collapseMenu.classList.add('show');
                const parentMenuLi = collapseMenu.closest('li');
                if (parentMenuLi) {
                    parentMenuLi.classList.add('active');
                }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', setActiveMenu);
