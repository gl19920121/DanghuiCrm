$(function () {

  // $('body').on('click', ".distpicker", function() {
  //   $(this).distpicker();
  // });

  //**********  多选导出  **********//

  checkedList = {};

  parseParam = function (param, key) {
    let paramStr = "";
    if(param instanceof String || param instanceof Number || param instanceof Boolean) {
      paramStr += "&" + key + "=" + encodeURIComponent(param);
    } else {
      $.each(param, function(i) {
        var k = key == null ? i : key + "%5B" + i + "%5D";
        paramStr += '&' + parseParam(this, k);
      });
    }

    return paramStr.substr(1);
  };

  excelDownload = function (url) {
    url += "&" + parseParam(checkedList, "id");
    url = url.replaceAll("&amp;", "&");
    checkedList = {};
    $('.scheckbox').prop("checked", false);
    window.location.href = url;
  }

  $('.scheckbox').change(function () {
    let checked = $(this).is(':checked');
    let id = $(this).data('id');
    let type = $(this).data('type');

    if (typeof(id) == "undefined") {
      return;
    }

    let key = type + "-" + id;
    let item = {'id': id, 'type': type};

    if (checked) {
      checkedList[key] = item;
    } else {
      delete checkedList[key];
    }
  })

  $('.all').click(function () {
    let checked = $(this).is(':checked');
    $('.scheckbox').prop("checked", checked);
    $('.scheckbox').change();
  })

  //**********  多选导出  **********//

    $('body').on('mouseenter', ".datetimepicker", function() {
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

    $('body').on('mouseenter', ".datemonthpicker", function() {
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

    $('body').on('focus', 'input[data-type="int"]', function() {
        // $(this).value = this.value.replace(/\D/g, '');
        $(this).on('input', function() {
            this.value = this.value.replace(/\D/g, '');
        })
    })

    $('body').on('focus', 'input[data-type="double"]', function() {
        $(this).on('input', function() {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        })
    })

    _fixType = function (type)
    {
      type = type.toLowerCase().replace(/jpg/i, 'jpeg');
      let r = type.match(/png|jpeg|bmp|gif/)[0];
      return 'image/' + r;
    }

    fileDownload = function (downloadUrl, imgType, fileName)
    {
      let aLink = document.createElement('a');
      aLink.style.display = 'none';
      aLink.href = downloadUrl;
      aLink.download = fileName + '.' + imgType;
      // 触发点击-然后移除
      document.body.appendChild(aLink);
      aLink.click();
      document.body.removeChild(aLink);
    }

    takeScreenshot = function (domId, canvasId, imgType, fileName)
    {
      window.pageYoffset = 0;
      document.documentElement.scrollTop = 0;
      document.body.scrollTop = 0;

      html2canvas(document.querySelector("#" + domId)).then(canvas => {
        document.querySelector("#" + canvasId).appendChild(canvas);
        //延迟执行确保万无一失，玄学
        setTimeout(() => {
          let type = imgType;
          let oCanvas = document.querySelector("#" + canvasId).getElementsByTagName("canvas")[0];
          let imgData = oCanvas.toDataURL(type);//canvas转换为图片
          // 加工image data，替换mime type，方便以后唤起浏览器下载
          imgData = imgData.replace(_fixType(type), 'image/octet-stream');
          fileDownload(imgData, type, fileName);
          $('body').remove('canvas');
        }, 0);
      });
    }

    function logoSelect()
    {
        let fileselect = $('[data-toggle="filechoose"][data-type="logo"]');
        let inputFile = fileselect.children('input[type="file"]');
        let inputText = fileselect.children('input[type="text"]');
        let imgLogo = fileselect.children('img');

        inputText.css('cursor', 'pointer');

        inputFile.change(function () {
            let file = $(this).get(0).files[0];
            inputText.val(file.name);

            let reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function (ev) {
                imgLogo.attr("src", ev.target.result);
                imgLogo.removeAttr("hidden");
            }
        })

        inputText.click(function () {
            inputFile.click();
        })
    }

    function avatarSelect()
    {
        let fileselect = $('[data-toggle="filechoose"][data-type="avatar"]');
        let inputFile = fileselect.children('input[type="file"]');
        let imgLogo = fileselect.children('img');
        let imgSize = fileselect.data('size');

        imgLogo.css('cursor', 'pointer');
        // if (imgSize == 'normal') {
        //   imgLogo.css('width', '150px');
        //   imgLogo.css('height', '150px');
        // } else if ('small') {
        //   imgLogo.css('width', '80px');
        //   imgLogo.css('height', '80px');
        // }

        inputFile.change(function () {
            let file = $(this).get(0).files[0];

            let reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function (ev) {
                imgLogo.attr("src", ev.target.result);
                imgLogo.removeAttr("hidden");
            }
        })

        imgLogo.click(function () {
            inputFile.click();
        })
    }

    function coverSelect()
    {
        let fileselect = $('[data-toggle="filechoose"][data-type="cover"]');
        let inputFile = fileselect.children('input[type="file"]');
        let button = fileselect.children('button');
        let img = fileselect.children('img');

        img.css('cursor', 'pointer');

        inputFile.change(function () {
            let file = $(this).get(0).files[0];

            let reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function (ev) {
                img.attr("src", ev.target.result);
                img.removeAttr("hidden");
            }

            button.hide();
        })

        button.click(function () {
            inputFile.click();
        })
        img.click(function () {
            inputFile.click();
        })
    }

    function appInit()
    {
        logoSelect();
        avatarSelect();
        coverSelect();
    }

    appInit();

});
