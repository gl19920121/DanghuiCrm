$(function () {

  $('#datetimepicker1').datetimepicker({
    locale: 'zh-CN',
    debug: false,
    format: 'L',
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

  $("[data-type='int']").on('input', function() {
    this.value=this.value.replace(/\D/g,'');
  })
});
