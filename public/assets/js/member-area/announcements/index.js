document.addEventListener('DOMContentLoaded', function () {
    // Mobile Sidebar Toggle (Matched logic)
    const mobileBtn = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebarMenu');
    if (mobileBtn) {
        mobileBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // Simple Filter Logic (Visual Mockup)
    const filterType = document.getElementById('filterType');
    const searchTitle = document.getElementById('searchTitle');

    [filterType, searchTitle].forEach(el => {
        el.addEventListener('input', function () {
            console.log(`Filtering by: ${filterType.value} and Search: ${searchTitle.value}`);
            // Frontend filtering logic would go here
        });
    });
});
