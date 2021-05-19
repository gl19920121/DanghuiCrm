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
      $('#industry').val(values.rd);
      $('input[name="industry[st]"]').val(values.st);
      $('input[name="industry[nd]"]').val(values.nd);
      $('input[name="industry[rd]"]').val(values.rd);
    } else {
      $('#industry').val('');
      $('input[name="industry[st]"]').val('');
      $('input[name="industry[nd]"]').val('');
      $('input[name="industry[rd]"]').val('');
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
    e.siblings('li').removeClass('selected');
    e.addClass('selected');

    addNavItem(e, pno);
  }

  function navItemSelect(e, item)
  {
    e.siblings('li').removeClass('selected');
    e.addClass('selected');

    addNavSecItem(item);
  }

  function navSecItemSelect(e, rootNo)
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

      relations[no].forEach(function(item) {
        $($('.item-detail').children('div').first()).append($('<div>').addClass('col').addClass('text-truncate').attr('data-dismiss', 'modal').attr('aria-label', 'Close').click(function() {
            jobTypeChange({ st: list[rootNo][0], nd: list[no][0], rd: list[item][0] });
        })
          .append($('<span>').attr('title', list[item][0])
            .append($('<a>').text(list[item][0]))
          )
        )
      });
    } else {
      e.find('svg').replaceWith(iconPlus);
      e.attr('data-icon', '0');
    }
  }

  function addNavItem(e, pno)
  {
    var pid = pno+'Item';console.log(pid);
    // e.siblings('li').find('ul').empty();
    $('#'+pno+'Item').remove();

    var parent = e.append($('<ul>').attr('id', pno+'Item'));

    relations[pno].forEach(function(no) {
        parent.append($('<li>').addClass('text-truncate')
            .append($('<a>').text(list[no][0]))
        )
    });
  }

  function addNavSecItem(pno)
  {
    $('#industryBody').empty();
    relations[pno].forEach(function(no) {
      $('#industryBody').append($('<div>').addClass('col')
        .append($('<p>').addClass('jobtype-item').addClass('text-truncate').attr('id', no).attr('data-icon', '0').attr('title', list[no][0])
          .click(function() {
            navItemSelect($(this), pno);
          })
          .append(iconPlus)
          .append($('<a>')
            .append(list[no][0])
          )
        )
      );
    });
  }

  function init()
  {
    root.forEach(function(no) {
      $('ul#industryLeftNav').append($('<li>').attr('id', no)
        .click(function() {
          navSelect($(this), no);
        })
        .append($('<a>').text(list[no][0]))
      )
    });

    // navSelect($('ul#industryLeftNav').children('li:first-child'), defaultOption.no);
  }

  init();

</script>
