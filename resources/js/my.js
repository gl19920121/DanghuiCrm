// $(function() {
//   $('#goto').bind('keypress',function(event) {
//     window.location.href = "http://www.baidu.com";
//   })
// });

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

  // @foreach (['danger', 'warning', 'success', 'info'] as $msg)
  //   @if(session()->has($msg))
  //     console.log(123);
  //     $('#msgModal').modal()
  //   @endif
  // @endforeach
});
