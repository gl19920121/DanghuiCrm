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

  function navItemSelect(e)
  {
    if (e.attr('data-icon') == '0') {
      e.find('svg').replaceWith(iconMinus);
      e.attr('data-icon', '1');
    } else {
      e.find('svg').replaceWith(iconPlus);
      e.attr('data-icon', '0');
    }
  }

  function addNavItem(no)
  {
    relations[no].forEach(function(item) {
      $('#jobtypeBody').append($('<div>').addClass('col')
        .append($('<p>').addClass('jobtype-item').attr('data-icon', '0')
          .click(function() {
            navItemSelect($(this));
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
    navSelect($('ul#jobtypeLeftNav').children('li:first-child'));
    addNavItem(defaultOption.no);
  }

  root.forEach(function(item) {
    $('ul#jobtypeLeftNav').append('<li id="' + item + '"><a href="#">' + list[item][0] + '</a></li>');
  });

  $('ul#jobtypeLeftNav li').click(function() {
    navSelect($(this));
    var no = $(this).attr('id');
    $('#jobtypeBody').empty();
    addNavItem(no);
  });

  init();

</script>
