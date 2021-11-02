window.onload = function() {
    const newsText = document.getElementsByClassName('news__content');
    for(let i=0;i<newsText.length;i++) {
        newsText[i].querySelector('div p').innerHTML = newsText[i].querySelector('div p').innerHTML.slice(0, 500) + (newsText[i].querySelector('div p').innerHTML.length > 500 ? "..." : "");
    }
}