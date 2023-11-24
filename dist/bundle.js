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

/***/ "./js/wcl-functions.js":
/*!*****************************!*\
  !*** ./js/wcl-functions.js ***!
  \*****************************/
/***/ (() => {

eval("const ready = (callback) => {\r\n\tif (document.readyState != \"loading\") callback();\r\n\telse document.addEventListener(\"DOMContentLoaded\", callback);\r\n}\r\n\r\nready(() => {\r\n\r\n\r\n\t/*\r\n\t* Prevent CF7 form duplication emails\r\n\t*/\r\n\tlet cf7_forms_submit = document.querySelectorAll('.wpcf7-form .wpcf7-submit');\r\n\r\n\tif (cf7_forms_submit) {\r\n\t\tcf7_forms_submit.forEach((element) => {\r\n\r\n\t\t\telement.addEventListener('click', (e) => {\r\n\r\n\t\t\t\tlet form = element.closest('.wpcf7-form');\r\n\r\n\t\t\t\tif (form.classList.contains('submitting')) {\r\n\t\t\t\t\te.preventDefault();\r\n\t\t\t\t}\r\n\r\n\t\t\t});\r\n\r\n\t\t});\r\n\t}\r\n\r\n\tconsole.log(12123)\r\n\r\n\r\n\t/* SCRIPTS GO HERE */\r\n\r\n\r\n});\n\n//# sourceURL=webpack:///./js/wcl-functions.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./js/wcl-functions.js"]();
/******/ 	
/******/ })()
;