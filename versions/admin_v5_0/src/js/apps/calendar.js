(function(document, window, $) {
  'use strict';

  window.AppCalendar = App.extend({
    handleFullcalendar: function() {
      var my_events = [{
        title: 'All Day Event',
        start: '2015-10-01'
      }, {
        title: 'Long Event',
        start: '2015-10-07',
        end: '2015-10-10',
        backgroundColor: $.colors("cyan", 600),
        borderColor: $.colors("cyan", 600)
      }, {
        id: 999,
        title: 'Repeating Event',
        start: '2015-10-09T16:00:00',
        backgroundColor: $.colors("red", 600),
        borderColor: $.colors("red", 600)
      }, {
        title: 'Conference',
        start: '2015-10-11',
        end: '2015-10-13'
      }, {
        title: 'Meeting',
        start: '2015-10-12T10:30:00',
        end: '2015-10-12T12:30:00'
      }, {
        title: 'Lunch',
        start: '2015-10-12T12:00:00'
      }, {
        title: 'Meeting',
        start: '2015-10-12T14:30:00'
      }, {
        title: 'Happy Hour',
        start: '2015-10-12T17:30:00'
      }, {
        title: 'Dinner',
        start: '2015-10-12T20:00:00'
      }, {
        title: 'Birthday Party',
        start: '2015-10-13T07:00:00'
      }];
      var my_options = {
        header: {
          left: null,
          center: 'prev,title,next',
          right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: '2015-10-12',
        selectable: true,
        selectHelper: true,
        select: function() {
          $('#addNewEvent').modal('show');
        },
        editable: true,
        eventLimit: true,
        windowResize: function(view) {
          var width = $(window).outerWidth();
          var options = $.extend({}, my_options);
          options.events = view.calendar.getEventCache();
          options.aspectRatio = width < 667 ? 0.5 : 1.35;

          $('#calendar').fullCalendar('destroy');
          $('#calendar').fullCalendar(options);
        },
        eventClick: function(event) {
          console.log(event)
          var color = event.backgroundColor ? event.backgroundColor : $.colors('blue', 600);
          $('#editEname').val(event.title);

          if (event.start) {
            $('#editStarts').datepicker('update', event.start._d);
          } else {
            $('#editStarts').datepicker('update', '');
          }
          if (event.end) {
            $('#editEnds').datepicker('update', event.end._d);
          } else {
            $('#editEnds').datepicker('update', '');
          }

          $('#editColor [type=radio]').each(function() {
            var $this = $(this),
              value = $this.data('color').split('|'),
              value = $.colors(value[0], value[1]);
            if (value === color) {
              $this.prop('checked', true);
            } else {
              $this.prop('checked', false);
            }
          });
          $('#editColor [value=' + event.backgroundColor + ']').prop('checked', true);

          $('#editNewEvent').modal('show').one('hidden.bs.modal', function(e) {
            event.title = $('#editEname').val();

            var color = $('#editColor [type=radio]:checked').data('color').split('|');
            color = $.colors(color[0], color[1]);
            event.backgroundColor = color;
            event.borderColor = color;

            event.start = new Date($('#editStarts').data('datepicker').getDate());
            event.end = new Date($('#editEnds').data('datepicker').getDate());
            $('#calendar').fullCalendar('updateEvent', event);
          })
        },
        eventDragStart: function() {
          $('.site-action').addClass('site-action-toggle');
        },
        eventDragStop: function() {
          $('.site-action').removeClass('site-action-toggle');
        },
        events: my_events,
        droppable: true
      };

      var _options;
      var my_options_mobile = $.extend({}, my_options);

      my_options_mobile.aspectRatio = 0.5;
      _options = $(window).outerWidth() < 667 ? my_options_mobile : my_options;

      $('#editNewEvent').modal();
      $('#calendar').fullCalendar(_options);
    },

    handleSelective: function() {
      var member = [{
        id: 'uid_1',
        name: 'Herman Beck',
        avatar: '../../../assets/portraits/1.jpg'
      }, {
        id: 'uid_2',
        name: 'Mary Adams',
        avatar: '../../../assets/portraits/2.jpg'
      }, {
        id: 'uid_3',
        name: 'Caleb Richards',
        avatar: '../../../assets/portraits/3.jpg'
      }, {
        id: 'uid_4',
        name: 'June Lane',
        avatar: '../../../assets/portraits/4.jpg'
      }];

      var items = [{
        id: 'uid_1',
        name: 'Herman Beck',
        avatar: '../../../assets/portraits/1.jpg'
      }, {
        id: 'uid_2',
        name: 'Caleb Richards',
        avatar: '../../../assets/portraits/2.jpg'
      }];

      $('[data-plugin="jquery-selective"]').selective({
        namespace: 'addMember',
        local: member,
        selected: items,
        buildFromHtml: false,
        tpl: {
          optionValue: function(data) {
            return data.id;
          },
          frame: function() {
            return '<div class="' + this.namespace + '">' +
              this.options.tpl.items.call(this) +
              '<div class="' + this.namespace + '-trigger">' +
              this.options.tpl.triggerButton.call(this) +
              '<div class="' + this.namespace + '-trigger-dropdown">' +
              this.options.tpl.list.call(this) +
              '</div>' +
              '</div>' +
              '</div>'
          },
          triggerButton: function() {
            return '<div class="' + this.namespace + '-trigger-button"><i class="wb-plus"></i></div>';
          },
          listItem: function(data) {
            return '<li class="' + this.namespace + '-list-item"><img class="avatar" src="' + data.avatar + '">' + data.name + '</li>';
          },
          item: function(data) {
            return '<li class="' + this.namespace + '-item"><img class="avatar" src="' + data.avatar + '" title="' + data.name + '">' +
              this.options.tpl.itemRemove.call(this) +
              '</li>';
          },
          itemRemove: function() {
            return '<span class="' + this.namespace + '-remove"><i class="wb-minus-circle"></i></span>';
          },
          option: function(data) {
            return '<option value="' + this.options.tpl.optionValue.call(this, data) + '">' + data.name + '</option>';
          }
        }
      });
    },

    handleAction: function() {
      $('.site-action').on('click', function() {
        var $this = $(this);

        if (!$this.hasClass('site-action-toggle')) {
          $('#addNewCalendarForm').modal('show');
        }
      });

      $('.site-action').on('mouseover', function() {
        var $this = $(this);

        if ($this.hasClass('site-action-toggle')) {
          $(this).addClass('active');
        }
      });

      $('.site-action').on('mouseleave', function() {
        var $this = $(this);

        if ($this.hasClass('site-action-toggle')) {
          $(this).removeClass('active');
        }
      });
    },

    handleEventList: function() {
      $('#addNewEventBtn').on('click', function() {
        $('#addNewEvent').modal('show');
      });

      $('.calendar-list .calendar-event').each(function() {
        var $this = $(this),
          color = $this.data('color').split('-');
        $this.data('event', {
          title: $this.data('title'),
          stick: $this.data('stick'),
          backgroundColor: $.colors(color[0], color[1]),
          borderColor: $.colors(color[0], color[1])
        });
        $this.draggable({
          zIndex: 999,
          revert: true,
          revertDuration: 0,
          helper: function() {
            return '<a class="fc-day-grid-event fc-event fc-start fc-end" style="background-color:' + $.colors(color[0], color[1]) + ';border-color:' + $.colors(color[0], color[1]) + '">' +
              '<div class="fc-content">' +
              '<span class="fc-title">' + $this.data('title') + '</span>' +
              '</div>' +
              '</a>';
          }
        });
      });
    },

    run: function(next) {
      $('#addNewCalendarForm').modal({
        show: false
      });


      this.handleEventList();
      this.handleFullcalendar();
      this.handleAction();
      this.handleSelective();

      next();
    }
  });
})(document, window, jQuery);
