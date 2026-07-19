const sidebar = () => document.getElementById('admin-sidebar');
const overlay = () => document.getElementById('admin-sidebar-overlay');

window.openAdminSidebar = () => {
	const panel = sidebar();
	const backdrop = overlay();

	if (!panel || !backdrop) {
		return;
	}

	panel.classList.remove('-translate-x-full');
	backdrop.classList.remove('opacity-0', 'pointer-events-none');
	backdrop.classList.add('opacity-100', 'pointer-events-auto');
	document.body.classList.add('overflow-hidden');
};

window.closeAdminSidebar = () => {
	const panel = sidebar();
	const backdrop = overlay();

	if (!panel || !backdrop) {
		return;
	}

	panel.classList.add('-translate-x-full');
	backdrop.classList.add('opacity-0', 'pointer-events-none');
	backdrop.classList.remove('opacity-100', 'pointer-events-auto');
	document.body.classList.remove('overflow-hidden');
};

window.toggleAdminSidebar = () => {
	const panel = sidebar();

	if (!panel) {
		return;
	}

	if (panel.classList.contains('-translate-x-full')) {
		window.openAdminSidebar();
		return;
	}

	window.closeAdminSidebar();
};

window.addEventListener('resize', () => {
	if (window.innerWidth >= 1024) {
		window.closeAdminSidebar();
	}
});
