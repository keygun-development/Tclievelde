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

/***/ "./web/app/themes/tclievelde/assets/js/uploads.js":
/*!********************************************************!*\
  !*** ./web/app/themes/tclievelde/assets/js/uploads.js ***!
  \********************************************************/
/***/ (() => {

eval("window.onload = function () {\n  var profielfoto = document.getElementById('profielfoto');\n  var errormsg = document.getElementById('errormsg');\n  var image = document.getElementById('selectedimage');\n  profielfoto.addEventListener('change', function (event) {\n    var file = profielfoto.files[0];\n\n    if (file.type == 'image/jpeg' || file.type == 'image/png') {\n      var filesize = file.size / 1024 / 1024;\n      var reader = new FileReader();\n      reader.readAsDataURL(file);\n\n      reader.onload = function (e) {\n        image.src = e.target.result;\n        errormsg.innerText = '';\n      };\n\n      if (filesize >= 5) {\n        errormsg.innerText = \"Image is: \" + filesize + \" Mib, dit is te groot crop de image of gebruik een andere.\";\n        image.src = '';\n      }\n    } else {\n      errormsg.innerText = \"Sorry, maar type: \" + file.type + \" wordt niet ondersteund.\";\n      image.src = '';\n    }\n  });\n};\n\n//# sourceURL=webpack:///./web/app/themes/tclievelde/assets/js/uploads.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./web/app/themes/tclievelde/assets/js/uploads.js"]();
/******/ 	
/******/ })()
;