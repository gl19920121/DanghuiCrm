<!-- Modal -->
<div class="modal fade jobtype-modal" id="jobtypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content m-auto">
      <div class="modal-header">
        <h5 class="modal-title">请选择职位类别</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-auto pl-0">
              <ul class="jobtype-list" id="jobtypeLeftNav"></ul>
            </div>
            <div class="col align-self-start">
              <div class="row row-cols-3 align-items-start" id="jobtypeBody"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="module">
  import JOBTYPES from '/js/jobtypes.js';

  $('#jobType').keyup(function(e) {
    if(e.keyCode == 8 || e.keyCode == 46) {
      $('#jobType').val('');
    }
  });

  $("[data-toggle='jobtypepicker']").find('.input-group-append').css('cursor', 'pointer').click(function(e) {
    $('#jobtypeModal').modal();
  });

  function jobTypeChange(values = {})
  {
    if (Object.keys(values).length > 0) {
      $('#jobType').val(values.rd);
      $('input[name="type[st]"]').val(values.st);
      $('input[name="type[nd]"]').val(values.nd);
      $('input[name="type[rd]"]').val(values.rd);
    } else {
      $('#jobType').val('');
      $('input[name="type[st]"]').val('');
      $('input[name="type[nd]"]').val('');
      $('input[name="type[rd]"]').val('');
    }
  }

  var list = JOBTYPES.list;
  var relations = JOBTYPES.relations;
  var root = JOBTYPES.category.root;
  var iconPlus = '<svg class="bi bi-plus" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"/><path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/></svg>';
  var iconMinus = '<svg class="bi bi-dash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.5-.5z"/></svg>';
  var defaultOption = {
    'no': 'N08'
  }

  function navSelect(e)
  {
    e.siblings('li').removeClass('selected');
    e.addClass('selected');
  }

  function navItemSelect(e, rootNo)
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

  function addNavItem(no)
  {
    $('#jobtypeBody').empty();
    relations[no].forEach(function(item) {
      $('#jobtypeBody').append($('<div>').addClass('col')
        .append($('<p>').addClass('jobtype-item').attr('id', item).attr('data-icon', '0')
          .click(function() {
            navItemSelect($(this), no);
          })
          .append(iconPlus)
          .append($('<a>')
            .append(list[item][0])
          )
        )
      );
    });
  }

  function init()
  {
    root.forEach(function(item) {
      $('ul#jobtypeLeftNav').append($('<li>').attr('id', item)
        .click(function() {
          navSelect($(this));
          addNavItem(item);
        })
        .append($('<a>').text(list[item][0]))
      )
    });

    navSelect($('ul#jobtypeLeftNav').children('li:first-child'));
    addNavItem(defaultOption.no);
  }

  init();

</script>
