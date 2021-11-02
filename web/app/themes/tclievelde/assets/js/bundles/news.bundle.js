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

/***/ "./web/app/themes/tclievelde/assets/js/news.js":
/*!*****************************************************!*\
  !*** ./web/app/themes/tclievelde/assets/js/news.js ***!
  \*****************************************************/
/***/ (() => {

eval("window.onload = function () {\n  var newsText = document.getElementsByClassName('news__content');\n\n  for (var i = 0; i < newsText.length; i++) {\n    newsText[i].querySelector('div p').innerHTML = newsText[i].querySelector('div p').innerHTML.slice(0, 500) + (newsText[i].querySelector('div p').innerHTML.length > 500 ? \"...\" : \"\");\n  }\n};\n\n//# sourceURL=webpack:///./web/app/themes/tclievelde/assets/js/news.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./web/app/themes/tclievelde/assets/js/news.js"]();
/******/ 	
/******/ })()
;