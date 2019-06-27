/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
module.exports = __webpack_require__(2);


/***/ }),
/* 1 */
/***/ (function(module, exports) {

$(".product-wrapper>a.product-item2").parent().css({
    "padding": "5px 0",
    "justify-content": "space-between"
});

$('.alert .close').on('click', function () {
    $(this).parent().fadeOut(200);
});

$('.slide-toggle').click(function (event) {
    /* Act on the event */
    event.preventDefault();
    if ($(this).parent().hasClass('lose-effic') == 1) {
        return false;
    };
    $(this).siblings('.weui-media-box_text').toggle();
    var state = $(this).siblings('.weui-media-box_text').css('display');
    if (state == 'none') {
        $(this).children('img').css('display', 'none');
        $(this).children('.open').css('display', 'block');
    } else if (state == 'block') {
        $(this).children('img').css('display', 'none');
        $(this).children('.shut').css('display', 'block');
    }
});

$('.credit .g-content .click-detail').on('click', function (event) {
    event.preventDefault();
    /* Act on the event */
    $(this).parent().siblings('.detail-txt').toggle();
    var state = $(this).parent().siblings('.detail-txt').css('display');
    if (state == 'none') {
        $(this).siblings().children('img').css('display', 'none');
        $(this).siblings().children('.open').css('display', 'inline-block');
    } else if (state == 'block') {
        $(this).siblings().children('img').css('display', 'none');
        $(this).siblings().children('.shut').css('display', 'inline-block');
    }
});

/***/ }),
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);