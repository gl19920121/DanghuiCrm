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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/my.js":
/*!****************************!*\
  !*** ./resources/js/my.js ***!
  \****************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  // $('body').on('click', ".distpicker", function() {
  //   $(this).distpicker();
  // });
  $('body').on('mouseenter', ".datetimepicker", function () {
    $(this).datetimepicker({
      locale: 'zh-CN',
      debug: false,
      format: 'YYYY-MM-DD',
      tooltips: {
        today: 'Go to today',
        clear: 'Clear selection',
        close: 'Close the picker',
        selectMonth: '选择月份',
        prevMonth: 'Previous Month',
        nextMonth: 'Next Month',
        selectYear: '选择年份',
        prevYear: 'Previous Year',
        nextYear: 'Next Year',
        selectDecade: '选择年代',
        prevDecade: 'Previous Decade',
        nextDecade: 'Next Decade',
        prevCentury: 'Previous Century',
        nextCentury: 'Next Century',
        pickHour: 'Pick Hour',
        incrementHour: 'Increment Hour',
        decrementHour: 'Decrement Hour',
        pickMinute: 'Pick Minute',
        incrementMinute: 'Increment Minute',
        decrementMinute: 'Decrement Minute',
        pickSecond: 'Pick Second',
        incrementSecond: 'Increment Second',
        decrementSecond: 'Decrement Second',
        togglePeriod: 'Toggle Period',
        selectTime: '选择时间',
        selectDate: '选择日期'
      }
    });
  });
  $('body').on('mouseenter', ".datemonthpicker", function () {
    $(this).datetimepicker({
      locale: 'zh-CN',
      debug: false,
      // format: 'L',
      viewMode: 'months',
      format: 'YYYY-MM',
      tooltips: {
        today: 'Go to today',
        clear: 'Clear selection',
        close: 'Close the picker',
        selectMonth: '选择月份',
        prevMonth: 'Previous Month',
        nextMonth: 'Next Month',
        selectYear: '选择年份',
        prevYear: 'Previous Year',
        nextYear: 'Next Year',
        selectDecade: '选择年代',
        prevDecade: 'Previous Decade',
        nextDecade: 'Next Decade',
        prevCentury: 'Previous Century',
        nextCentury: 'Next Century',
        pickHour: 'Pick Hour',
        incrementHour: 'Increment Hour',
        decrementHour: 'Decrement Hour',
        pickMinute: 'Pick Minute',
        incrementMinute: 'Increment Minute',
        decrementMinute: 'Decrement Minute',
        pickSecond: 'Pick Second',
        incrementSecond: 'Increment Second',
        decrementSecond: 'Decrement Second',
        togglePeriod: 'Toggle Period',
        selectTime: '选择时间',
        selectDate: '选择日期'
      }
    });
  });
  $('body').on('focus', 'input[data-type="int"]', function () {
    // $(this).value = this.value.replace(/\D/g, '');
    $(this).on('input', function () {
      this.value = this.value.replace(/\D/g, '');
    });
  });

  _fixType = function _fixType(type) {
    type = type.toLowerCase().replace(/jpg/i, 'jpeg');
    var r = type.match(/png|jpeg|bmp|gif/)[0];
    return 'image/' + r;
  };

  fileDownload = function fileDownload(downloadUrl, imgType, fileName) {
    var aLink = document.createElement('a');
    aLink.style.display = 'none';
    aLink.href = downloadUrl;
    aLink.download = fileName + '.' + imgType; // 触发点击-然后移除

    document.body.appendChild(aLink);
    aLink.click();
    document.body.removeChild(aLink);
  };

  takeScreenshot = function takeScreenshot(domId, canvasId, imgType, fileName) {
    window.pageYoffset = 0;
    document.documentElement.scrollTop = 0;
    document.body.scrollTop = 0;
    html2canvas(document.querySelector("#" + domId)).then(function (canvas) {
      document.querySelector("#" + canvasId).appendChild(canvas); //延迟执行确保万无一失，玄学

      setTimeout(function () {
        var type = imgType;
        var oCanvas = document.querySelector("#" + canvasId).getElementsByTagName("canvas")[0];
        var imgData = oCanvas.toDataURL(type); //canvas转换为图片
        // 加工image data，替换mime type，方便以后唤起浏览器下载

        imgData = imgData.replace(_fixType(type), 'image/octet-stream');
        fileDownload(imgData, type, fileName);
        $('body').remove('canvas');
      }, 0);
    });
  };

  function logoSelect() {
    var fileselect = $('[data-toggle="filechoose"][data-type="logo"]');
    var inputFile = fileselect.children('input[type="file"]');
    var inputText = fileselect.children('input[type="text"]');
    var imgLogo = fileselect.children('img');
    inputText.css('cursor', 'pointer');
    inputFile.change(function () {
      var file = $(this).get(0).files[0];
      inputText.val(file.name);
      var reader = new FileReader();
      reader.readAsDataURL(file);

      reader.onload = function (ev) {
        imgLogo.attr("src", ev.target.result);
        imgLogo.removeAttr("hidden");
      };
    });
    inputText.click(function () {
      inputFile.click();
    });
  }

  function avatarSelect() {
    var fileselect = $('[data-toggle="filechoose"][data-type="avatar"]');
    var inputFile = fileselect.children('input[type="file"]');
    var imgLogo = fileselect.children('img');
    var imgSize = fileselect.data('size');
    imgLogo.css('cursor', 'pointer'); // if (imgSize == 'normal') {
    //   imgLogo.css('width', '150px');
    //   imgLogo.css('height', '150px');
    // } else if ('small') {
    //   imgLogo.css('width', '80px');
    //   imgLogo.css('height', '80px');
    // }

    inputFile.change(function () {
      var file = $(this).get(0).files[0];
      var reader = new FileReader();
      reader.readAsDataURL(file);

      reader.onload = function (ev) {
        imgLogo.attr("src", ev.target.result);
        imgLogo.removeAttr("hidden");
      };
    });
    imgLogo.click(function () {
      inputFile.click();
    });
  }

  function coverSelect() {
    var fileselect = $('[data-toggle="filechoose"][data-type="cover"]');
    var inputFile = fileselect.children('input[type="file"]');
    var button = fileselect.children('button');
    var img = fileselect.children('img');
    img.css('cursor', 'pointer');
    inputFile.change(function () {
      var file = $(this).get(0).files[0];
      var reader = new FileReader();
      reader.readAsDataURL(file);

      reader.onload = function (ev) {
        img.attr("src", ev.target.result);
        img.removeAttr("hidden");
      };

      button.hide();
    });
    button.click(function () {
      inputFile.click();
    });
    img.click(function () {
      inputFile.click();
    });
  }

  function appInit() {
    logoSelect();
    avatarSelect();
    coverSelect();
  }

  appInit();
});

/***/ }),

/***/ 1:
/*!**********************************!*\
  !*** multi ./resources/js/my.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/wwwroot/DanghuiCrm/resources/js/my.js */"./resources/js/my.js");


/***/ })

/******/ });