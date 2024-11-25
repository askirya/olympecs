document.addEventListener('DOMContentLoaded', function () {
    const searchToggleBtn = document.getElementById('search-toggle-btn');
    const searchCloseBtn = document.getElementById('search-close-btn');
    const headerNavigation = document.querySelector('.header__navigation');
    const searchForm = document.getElementById('search-form');

    searchToggleBtn.addEventListener('click', function () {
        headerNavigation.classList.add('active');
        document.getElementById('search-query').focus();
    });

    searchCloseBtn.addEventListener('click', function () {
        headerNavigation.classList.remove('active');
        searchForm.reset(); // Опционально: очищаем поле поиска
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && headerNavigation.classList.contains('active')) {
            headerNavigation.classList.remove('active');
            searchForm.reset(); // Опционально: очищаем поле поиска
        }
    });
    
    document.addEventListener('click', function (e) {
        if (!searchForm.contains(e.target) && !searchToggleBtn.contains(e.target)) {
            headerNavigation.classList.remove('active');
            searchForm.reset(); // Опционально: очищаем поле поиска
        }
    });
});