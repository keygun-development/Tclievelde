/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./web/app/themes/tclievelde/assets/js/activeplayers.js":
/*!**************************************************************!*\
  !*** ./web/app/themes/tclievelde/assets/js/activeplayers.js ***!
  \**************************************************************/
/***/ (() => {

eval("window.onload = function () {\n  var searchbar = document.getElementById('searchbar');\n  var players = document.getElementsByClassName('c-match__single-player');\n\n  var _loop = function _loop(i) {\n    searchbar.addEventListener('input', function () {\n      if (players[i].querySelector('p').innerText.toUpperCase().startsWith(searchbar.value.toUpperCase())) {\n        players[i].classList.add('d-block');\n        players[i].classList.remove('d-none');\n      } else {\n        players[i].classList.add('d-none');\n        players[i].classList.remove('d-block');\n      }\n    });\n  };\n\n  for (var i = 0; i < players.length; i++) {\n    _loop(i);\n  } // Select player tiles\n\n\n  var playerCount = 0;\n  var activeplayers = document.getElementById('allspelers');\n  var errmsg = document.getElementById('errmsg');\n\n  var _loop2 = function _loop2(_i) {\n    players[_i].addEventListener('click', function () {\n      if (!players[_i].classList.contains('no-deselect')) {\n        if (playerCount < 3) {\n          if (players[_i].classList.contains('active-player')) {\n            players[_i].classList.remove('active-player');\n\n            playerCount--;\n            updatePlayers();\n          } else {\n            players[_i].classList.add('active-player');\n\n            playerCount++;\n            updatePlayers();\n          }\n        } else if (players[_i].classList.contains('active-player')) {\n          players[_i].classList.remove('active-player');\n\n          playerCount--;\n          updatePlayers();\n        }\n      } else {\n        errmsg.innerHTML = 'Je kunt jezelf niet deselecteren.';\n      }\n    });\n  };\n\n  for (var _i = 0; _i < players.length; _i++) {\n    _loop2(_i);\n  }\n\n  function updatePlayers() {\n    var allplayers = document.getElementsByClassName('active-player');\n    var lidnummer = document.getElementById('lidnummer');\n    activeplayers.textContent = ''; // Make this for the lidnummer first\n\n    if (lidnummer) {\n      var el = activeplayers.appendChild(document.createElement('input'));\n      el.name = 'speler1';\n      el.value = lidnummer.textContent.replaceAll(' ', '');\n      el.readOnly = true;\n    } // Then loop through the active players\n\n\n    for (var _i2 = 0; _i2 < allplayers.length; _i2++) {\n      var _el = activeplayers.appendChild(document.createElement('input'));\n\n      var windowLocation = window.location.href.split('?');\n\n      for (var x = 0; x < windowLocation.length; x++) {\n        if (windowLocation[x] === 'newreservation') {\n          _el.name = 'speler' + [_i2 + 1];\n        } else {\n          _el.name = 'speler' + [_i2 + 2];\n        }\n      }\n\n      _el.value = allplayers[_i2].textContent.replaceAll(' ', '');\n      _el.readOnly = true;\n    }\n  }\n\n  function updatePlayersEdit() {\n    var allplayerswij = document.getElementsByClassName('active-players');\n    var wij = document.getElementsByClassName('c-match__single-player');\n\n    for (var _i3 = 0; _i3 < wij.length; _i3++) {\n      wij[_i3].textContent = wij[_i3].textContent.replaceAll(/(\\r\\n|\\n|\\r)/gm, '');\n      wij[_i3].textContent = wij[_i3].textContent.replaceAll(' ', '');\n\n      for (var x = 0; x < allplayerswij.length; x++) {\n        if (allplayerswij[x].value.replace(/\\s/g, '') === wij[_i3].textContent) {\n          wij[_i3].classList.add('active-player');\n        }\n      }\n    }\n  }\n\n  updatePlayersEdit();\n  updatePlayers();\n};\n\n//# sourceURL=webpack:///./web/app/themes/tclievelde/assets/js/activeplayers.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./web/app/themes/tclievelde/assets/js/activeplayers.js"]();
/******/ 	
/******/ })()
;