window.onload = function() {
    const jaarselect = document.getElementById('jaarselect');
    const jaarselecter = document.getElementById('jaarselecter');
    const page = window.location;
    jaarselecter.addEventListener('change', (event) => {
        if (jaarselecter.value !== 'all') {
            jaarselect.href = page.pathname+'?jaar='+jaarselecter.value;
        } else {
            jaarselect.href = page.pathname;
        }
    });
}