// $(function() {
//   $('#goto').bind('keypress',function(event) {
//     window.location.href = "http://www.baidu.com";
//   })
// });

$(function () {
  // $.extend(true, $.fn.datetimepicker.defaults, {

  // });
  $('#datetimepicker1').datetimepicker({
    locale: 'zh-CN',
    debug: true,
    format: 'L',
    // icons: {
    //   time: 'far fa-clock',
    //   date: 'far fa-calendar',
    //   up: 'fas fa-arrow-up',
    //   down: 'fas fa-arrow-down',
    //   previous: 'fas fa-chevron-left',
    //   next: 'fas fa-chevron-right',
    //   today: 'fas fa-calendar-check',
    //   clear: 'far fa-trash-alt',
    //   close: 'far fa-times-circle'
    // },
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
    },
  });
});
