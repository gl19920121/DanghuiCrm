$(function () {

    $('body').on('mouseenter', ".datetimepicker", function() {
        $(this).datetimepicker({
            locale: 'zh-CN',
            debug: false,
            // format: 'L',
            viewMode: 'months',
            format: 'YYYY/MM',
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

        imgLogo.css('cursor', 'pointer');
        imgLogo.css('width', '150px');
        imgLogo.css('height', '150px');

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

    function appInit()
    {
        logoSelect();
        avatarSelect();
    }

    appInit();

});
