<!-- Modal -->
<div class="modal fade jobtype-modal" id="industryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content m-auto">
      <div class="modal-header">
        <h5 class="modal-title">请选择行业</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-auto pl-0">
              <ul class="jobtype-list" id="industryLeftNav"></ul>
            </div>
            <div class="col align-self-start">
              <div class="row row-cols-3 align-items-start" id="industryBody"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="module">
  import DATA from '/js/industry.js';

  $('#industry').keyup(function(e) {
    if(e.keyCode == 8 || e.keyCode == 46) {
      $('#industry').val('');
    }
  });

  $("[data-toggle='industrypicker']").find('.input-group-append').css('cursor', 'pointer').click(function(e) {
    $('#industryModal').modal();
  });

  function jobTypeChange(values = {})
  {
    if (Object.keys(values).length > 0) {
      $('#industry').val(values.th);
      $('input[name="industry[st]"]').val(values.st);
      $('input[name="industry[nd]"]').val(values.nd);
      $('input[name="industry[rd]"]').val(values.rd);
      $('input[name="industry[th]"]').val(values.th);
    } else {
      $('#industry').val('');
      $('input[name="industry[st]"]').val('');
      $('input[name="industry[nd]"]').val('');
      $('input[name="industry[rd]"]').val('');
      $('input[name="industry[th]"]').val('');
    }
  }

  var list = DATA.list;
  var relations = DATA.relations;
  var root = DATA.category.root;
  var iconPlus = '<svg class="bi bi-plus" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"/><path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/></svg>';
  var iconMinus = '<svg class="bi bi-dash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.5-.5z"/></svg>';
  var defaultOption = {
    'no': 'No1'
  }

  function navSelect(e, pno)
  {
    $('#sec'+pno).closest('li').siblings('li').find('ul').hide();
    $('#sec'+pno).toggle('fast');
  }

  function navItemSelect(e, rootNo, pno)
  {
    e.closest('ul').closest('li').siblings('li').find('li').removeClass('selected');
    e.siblings('li').removeClass('selected');
    e.addClass('selected');

    addNavSecItem(rootNo, pno);
  }

  function navSecItemSelect(e, rootNo, pNo)
  {
    $('div').remove('.item-detail');

    var no = e.attr('id');
    var item = e.parent('div.col');
    var index = item.index();
    var colIndex = index % 3;
    var colClass = '';
    var targetIndex = index + (2 - colIndex);
    var children = item.parent().children();
    var count = children.length;
    var maxIndex = count - 1;
    if (targetIndex > maxIndex) {
      targetIndex = maxIndex;
    }
    if (colIndex == 0) {
      colClass = 'st';
    } else if (colIndex == 1) {
      colClass = 'nd';
    } else if (colIndex == 2) {
      colClass = 'rd';
    }

    var selected = e.attr('data-icon') == '1';
    item.siblings('div').find('p').addClass('selected').attr('data-icon', '0');
    item.siblings('div').find('svg').replaceWith(iconPlus);


    if (!selected) {
      e.find('svg').replaceWith(iconMinus);
      e.attr('data-icon', '1');

      children.eq(targetIndex).after($('<div>').addClass('col-12')
        .append($('<div>').addClass('item-detail').addClass(colClass)
          .append($('<div>').addClass('row').addClass('row-cols-3').addClass('align-items-start'))
        )
      );

      var all = '全部'+list[no][0];
        $($('.item-detail').children('div').first()).append($('<div>').addClass('col').addClass('text-truncate').attr('data-dismiss', 'modal').attr('aria-label', 'Close').click(function() {
            jobTypeChange({ st: list[rootNo][0], nd: list[pNo][0], rd: list[no][0], th: list[no][0]});
        })
          .append($('<span>').attr('title', all)
            .append($('<a>').text(all))
          )
        )
      if (relations.hasOwnProperty(no)) {
        relations[no].forEach(function(item) {
            $($('.item-detail').children('div').first()).append($('<div>').addClass('col').addClass('text-truncate').attr('data-dismiss', 'modal').attr('aria-label', 'Close').click(function() {
                jobTypeChange({ st: list[rootNo][0], nd: list[pNo][0], rd: list[no][0], th: list[item][0] });
            })
              .append($('<span>').attr('title', list[item][0])
                .append($('<a>').text(list[item][0]))
              )
            )
          });
      }

    } else {
      e.find('svg').replaceWith(iconPlus);
      e.attr('data-icon', '0');
    }
  }

  function addNavSecItem(rootNo, pNo)
  {
    $('#industryBody').empty();

    var all = '全部'+list[pNo][0];
    $('#industryBody').append($('<div>').addClass('col-12').addClass('item-all').addClass('text-truncate').attr('data-dismiss', 'modal').attr('aria-label', 'Close').click(function() {
            jobTypeChange({ st: list[rootNo][0], nd: list[pNo][0], rd: list[pNo][0], th: list[pNo][0]});
        })
        .append($('<span>').attr('title', all)
            .append($('<a>').text(all))
        )
    );
    if (relations.hasOwnProperty(pNo)) {
        relations[pNo].forEach(function(no) {
          $('#industryBody').append($('<div>').addClass('col')
            .append($('<p>').addClass('jobtype-item').addClass('text-truncate').attr('id', no).attr('data-icon', '0').attr('title', list[no][0])
              .click(function() {
                navSecItemSelect($(this), rootNo, pNo);
              })
              .append(iconPlus)
              .append($('<a>')
                .append(list[no][0])
              )
            )
          );
        });
    }
  }

  function init()
  {
    root.forEach(function(rootNo) {
      var secId = 'sec'+rootNo;
      $('ul#industryLeftNav').append($('<li>').attr('id', rootNo)
        .append($('<p>')
            .click(function() {
              navSelect($(this), rootNo);
            })
            .append($('<a>').text(list[rootNo][0]))
        )

        .append($('<ul>').addClass('sec-list').attr('id', secId).css('display', 'none'))
      )
      relations[rootNo].forEach(function(no) {
        $('#'+secId).append($('<li>').addClass('text-truncate')
            .click(function() {
              navItemSelect($(this), rootNo, no);
            })
            .append($('<a>').text(list[no][0]))
        )
      });
    });

    // navSelect($('ul#industryLeftNav').children('li:first-child'), defaultOption.no);
  }

  init();

</script>
