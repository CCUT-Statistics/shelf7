/**
 * Forum-style UI enhancements.
 */
(function () {
    /* Collapsible site-info cards */
    var siteInfoCards = document.querySelectorAll('.card.card-site-info');
    siteInfoCards.forEach(function (card) {
        var header = card.querySelector('.card-header');
        if (!header) return;
        header.addEventListener('click', function () {
            card.classList.toggle('is-expanded');
        });
    });

    /* Thread list hover effect */
    var threadItems = document.querySelectorAll('.threadlist > li');
    threadItems.forEach(function (li) {
        li.style.transition = 'background-color 0.15s ease';
        li.addEventListener('mouseenter', function () {
            li.style.backgroundColor = '#f8f9fb';
        });
        li.addEventListener('mouseleave', function () {
            li.style.backgroundColor = '';
        });
    });

    /* Forum board item hover */
    var boardItems = document.querySelectorAll('.forum-board-item');
    boardItems.forEach(function (item) {
        item.style.transition = 'background-color 0.15s ease';
        item.addEventListener('mouseenter', function () {
            item.style.backgroundColor = '#f8f9fb';
        });
        item.addEventListener('mouseleave', function () {
            item.style.backgroundColor = '';
        });
    });

    /* Add smooth scroll to go-top */
    var goTop = document.querySelector('.go-top');
    if (goTop) {
        goTop.addEventListener('click', function (e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
})();
