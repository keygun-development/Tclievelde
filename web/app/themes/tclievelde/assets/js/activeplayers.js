window.onload = function () {
    const location = window.location.href.split('/');
    for (let i=0; i<location.length; i++) {
        if (location[i] === '?newmatch') {
            const datetimelocal = document.getElementById('datetime-local');
            let dateVal = new Date();
            var day = dateVal.getDate().toString().padStart(2, "0");
            var month = (1 + dateVal.getMonth()).toString().padStart(2, "0");
            var hour = dateVal.getHours().toString();
            var minute = dateVal.getMinutes().toString();
            if (hour < 10) {
                if (minute < 10) {
                    datetimelocal.value = dateVal.getFullYear() + "-" + month + "-" + (day) + "T0" + (hour) + ":0" + (minute);
                } else {
                    datetimelocal.value = dateVal.getFullYear() + "-" + month + "-" + (day) + "T0" + (hour) + ":" + (minute);
                }
            } else {
                if (minute < 10) {
                    datetimelocal.value = dateVal.getFullYear() + "-" + month + "-" + (day) + "T" + (hour) + ":0" + (minute);
                } else {
                    datetimelocal.value = dateVal.getFullYear() + "-" + month + "-" + (day) + "T" + (hour) + ":" + (minute);
                }
            }
            const competitie = document.getElementById('competitie')
            competitie.value = dateVal.getFullYear();
        }
    }

    const jaarselect = document.getElementById('jaarselect');
    const jaarselecter = document.getElementById('jaarselecter');
    jaarselecter.addEventListener('change', (event) => {
        if (jaarselecter.value !== 'all') {
            jaarselect.href = '/wedstrijden/?jaar='+jaarselecter.value;
        } else {
            jaarselect.href = '/wedstrijden/';
        }
    });

    // Select player tiles
    const playerswij = document.getElementsByClassName('c-match__single-player-wij');
    const playerszij = document.getElementsByClassName('c-match__single-player-zij');
    let errormsgwij = document.getElementById('playerlengthwij');
    let errormsgzij = document.getElementById('playerlengthzij');
    let activewijplayers = 0;
    let activezijplayers = 0;
    let activeplayerswij = document.getElementById('allspelerswij');
    let activeplayerszij = document.getElementById('allspelerszij');

    for (let i=0; i<playerswij.length; i++) {
        playerswij[i].addEventListener('click', function () {
            if (playerswij[i].classList.contains('active-player-wij')) {
                playerswij[i].classList.remove('active-player-wij');
                playerszij[i].classList.remove('disabled-player-zij');
                errormsgwij.style.display = 'none'
                errormsgwij.innerHTML = '';
                activewijplayers--;
                updatePlayersWij();
            } else {
                if (playerszij[i].classList.contains('active-player-zij')) {
                } else {
                    if (activewijplayers < 3) {
                        playerswij[i].classList.add('active-player-wij');
                        playerszij[i].classList.add('disabled-player-zij');
                        activewijplayers++;
                        updatePlayersWij();
                    } else {
                        errormsgwij.style.display = 'block'
                        errormsgwij.innerHTML = "U heeft al 3 spelers geselecteerd.";
                    }
                }
            }
        })
    }

    for (let i=0; i<playerszij.length; i++) {
        playerszij[i].addEventListener('click', function () {
            if (playerszij[i].classList.contains('active-player-zij')) {
                playerszij[i].classList.remove('active-player-zij');
                playerswij[i].classList.remove('disabled-player-wij');
                errormsgzij.style.display = 'none'
                errormsgzij.innerHTML = '';
                activezijplayers--;
                updatePlayersZij()
            } else {
                if (playerswij[i].classList.contains('active-player-wij')) {
                } else {
                    if (activezijplayers < 3) {
                        playerszij[i].classList.add('active-player-zij');
                        playerswij[i].classList.add('disabled-player-wij');
                        activezijplayers++;
                        updatePlayersZij()
                    } else {
                        errormsgzij.style.display = 'block'
                        errormsgzij.innerHTML = "U heeft al 3 spelers geselecteerd.";
                    }
                }
            }
        })
    }

    function updatePlayersWij()
    {
        const allplayerswij = document.getElementsByClassName('active-player-wij');
        activeplayerswij.textContent = '';
        for (let i=0; i<allplayerswij.length; i++) {
            const el = activeplayerswij.appendChild(document.createElement('input'));
            el.name = 'spelerswij'+[i+1]
            el.value = allplayerswij[i].textContent.replaceAll(' ', '');
            el.readOnly = true
        }
    }

    function updatePlayersWijEdit()
    {
        const allplayerswij = document.getElementsByClassName('active-players-wij-edit');
        const wij = document.getElementsByClassName('c-match__single-player-wij');
        const zij = document.getElementsByClassName('c-match__single-player-zij');
        for (let i=0; i<wij.length; i++) {
            wij[i].textContent = wij[i].textContent.replaceAll(/(\r\n|\n|\r)/gm, '')
            wij[i].textContent = wij[i].textContent.replaceAll(' ', '')
            for (let x=0; x<allplayerswij.length; x++) {
                if (allplayerswij[x].value == wij[i].textContent) {
                    wij[i].classList.add('active-player-wij');
                    zij[i].classList.add('disabled-player-zij')
                }
            }
        }
    }

    function updatePlayersZij()
    {
        const allplayerszij = document.getElementsByClassName('active-player-zij');
        activeplayerszij.textContent = '';
        for (let i=0; i<allplayerszij.length; i++) {
            const el = activeplayerszij.appendChild(document.createElement('input'));
            el.name = 'spelerszij'+[i+1]
            el.value = allplayerszij[i].textContent.replaceAll(' ', '');
            el.readOnly = true
        }
    }
    function updatePlayersZijEdit()
    {
        const allplayerszij = document.getElementsByClassName('active-players-zij-edit');
        const wij = document.getElementsByClassName('c-match__single-player-wij');
        const zij = document.getElementsByClassName('c-match__single-player-zij');
        for (let i=0; i<zij.length; i++) {
            zij[i].textContent = zij[i].textContent.replaceAll(/(\r\n|\n|\r)/gm, '')
            zij[i].textContent = zij[i].textContent.replaceAll(' ', '')
            for (let x=0; x<allplayerszij.length; x++) {
                if (allplayerszij[x].value == zij[i].textContent) {
                    zij[i].classList.add('active-player-zij');
                    wij[i].classList.add('disabled-player-wij')
                }
            }
        }
    }
    updatePlayersZijEdit()
    updatePlayersWijEdit()
}