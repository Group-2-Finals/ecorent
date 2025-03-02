const itemsPerPage = 12;
const items = document.querySelectorAll('.items');
var itemPage = 1;

function showPage(page) {
    const start = (page - 1) * itemsPerPage;
    const end = start + itemsPerPage;

    items.forEach((item, index) => {
        item.style.display = (index >= 0 && index < end) ? 'block' : 'none';
    });
}

function showMore() {
    itemPage++;

    showPage(itemPage);
    checkItemPerPage()
}

function checkItemPerPage() {
    if (itemPage * itemsPerPage >= items.length) {
        const goBack = document.getElementById('loadMore');
        goBack.innerHTML = 'GO BACK TO TOP';

        goBack.onclick = function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        };
    }
}

function validateInput(input) {
    input.value = input.value.replace(/[^0-9.]/g, '');
}

showPage(itemPage);
checkItemPerPage()