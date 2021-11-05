window.onload = function () {
    const searchbar = document.getElementById('searchbar');
    const players = document.getElementsByClassName('c-match__single-player');
    for (let i=0; i<players.length; i++) {
        searchbar.addEventListener('input', () => {
            if (players[i].querySelector('p').innerText.toUpperCase().startsWith(searchbar.value.toUpperCase())) {
                players[i].classList.add('d-block');
                players[i].classList.remove('d-none');
            } else {
                players[i].classList.add('d-none');
                players[i].classList.remove('d-block');
            }
        })
    }
    // Select player tiles
    let playerCount = 0;
    const activeplayers = document.getElementById('allspelers');
    const errmsg = document.getElementById('errmsg');

    for (let i=0; i<players.length; i++) {
        players[i].addEventListener('click', function () {
            if (!players[i].classList.contains('no-deselect')) {
                if (playerCount < 3) {
                    if (players[i].classList.contains('active-player')) {
                        players[i].classList.remove('active-player');
                        playerCount--
                        updatePlayersWij();
                    } else {
                        players[i].classList.add('active-player');
                        playerCount++
                        updatePlayersWij();
                    }
                }
            } else {
                errmsg.innerHTML = 'Je kunt jezelf niet deselecteren.';
            }
        })
    }

    function updatePlayersWij()
    {
        const allplayers = document.getElementsByClassName('active-player');
        activeplayers.textContent = '';
        for (let i=0; i<allplayers.length; i++) {
            const el = activeplayers.appendChild(document.createElement('input'));
            el.name = 'speler'+[i+1]
            el.value = allplayers[i].textContent.replaceAll(' ', '');
            el.readOnly = true
        }
    }
    updatePlayersWij();
}