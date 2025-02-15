(function($) {

  "use strict";

  var date = new Date();
  var yyyy = date.getFullYear().toString();
  var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
  var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();

  var options = {
    events_source: 'eventos.php',
    language: 'es-ES',
    modal: '#events-modal',
    modal_type: 'ajax',
    modal_title: function(event) { return event.title },
    view: 'month',
    tmpl_path: 'components/bootstrap-calendar/tmpls/',
    tmpl_cache: false,
    day: yyyy+"-"+mm+"-"+dd,

    onAfterEventsLoad: function(events) {
      if(!events) {
        return;
      }

      var list = $('#eventlist');
      list.html('');

      $.each(events, function(key, val) {
        $(document.createElement('li'))
        .html('<a href="' + val.url + '">' + val.title + '</a>')
        .appendTo(list);
      });
    },
    onAfterViewLoad: function(view) {
      $('.page-header h3').text(this.getTitle());
      $('.btn-group button').removeClass('active');
      $('button[data-calendar-view="' + view + '"]').addClass('active');
    },
    classes: {
      months: {
        general: 'label'
      }
    }
  };

  var calendar = $('#calendar').calendar(options);

  $('.btn-group button[data-calendar-nav]').each(function() {
    var $this = $(this);
    $this.click(function() {
      calendar.navigate($this.data('calendar-nav'));
    });
  });

  $('.btn-group button[data-calendar-view]').each(function() {
    var $this = $(this);
    $this.click(function() {
      calendar.view($this.data('calendar-view'));
    });
  });

  $('#events-modal .modal-header, #events-modal .modal-footer').click(function(e){
    //e.preventDefault();
    //e.stopPropagation();
  });
}(jQuery));
