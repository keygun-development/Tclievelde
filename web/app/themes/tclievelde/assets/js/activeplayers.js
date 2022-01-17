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
                        updatePlayers();
                    } else {
                        players[i].classList.add('active-player');
                        playerCount++
                        updatePlayers();
                    }
                } else if (players[i].classList.contains('active-player')) {
                    players[i].classList.remove('active-player');
                    playerCount--
                    updatePlayers();
                }
            } else {
                errmsg.innerHTML = 'Je kunt jezelf niet deselecteren.';
            }
        })
    }

    function updatePlayers()
    {
        const allplayers = document.getElementsByClassName('active-player');
        activeplayers.textContent = '';

        // Then loop through the active players
        for (let i=0; i<allplayers.length; i++) {
            const el = activeplayers.appendChild(document.createElement('input'));
            const elID = activeplayers.appendChild(document.createElement('input'));
            let windowLocation = window.location.href.split('?')
            for (let x=0; x<windowLocation.length; x++) {
                if (windowLocation[x] === 'newreservation') {
                    el.name = 'speler'+[i+1]
                    elID.name = 'speler'+[i+1]+'Id'
                } else {
                    el.name = 'speler'+[i+2]
                    elID.name = 'speler'+[i+2]+'Id'
                }
            }
            el.value = allplayers[i].innerText;
            elID.hidden = true;
            elID.value = allplayers[i].id;
            el.readOnly = true
        }
    }

    updatePlayers();
}