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

/***/ "./web/app/themes/tclievelde/assets/js/competition.js":
/*!************************************************************!*\
  !*** ./web/app/themes/tclievelde/assets/js/competition.js ***!
  \************************************************************/
/***/ (() => {

eval("window.onload = function () {\n  var jaarselect = document.getElementById('jaarselect');\n  var jaarselecter = document.getElementById('jaarselecter');\n  var page = window.location;\n  jaarselecter.addEventListener('change', function (event) {\n    if (jaarselecter.value !== 'all') {\n      jaarselect.href = page.pathname + '?jaar=' + jaarselecter.value;\n    } else {\n      jaarselect.href = page.pathname;\n    }\n  });\n};\n\n//# sourceURL=webpack:///./web/app/themes/tclievelde/assets/js/competition.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./web/app/themes/tclievelde/assets/js/competition.js"]();
/******/ 	
/******/ })()
;