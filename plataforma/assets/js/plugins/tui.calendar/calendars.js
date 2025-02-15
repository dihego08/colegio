'use strict';

/* eslint-disable require-jsdoc, no-unused-vars */

var CalendarList = [];

function CalendarInfo() {
    this.id = null;
    this.name = null;
    this.checked = true;
    this.color = null;
    this.bgColor = null;
    this.borderColor = null;
    this.dragBgColor = null;
}

function addCalendar(calendar) {
    CalendarList.push(calendar);
}

function findCalendar(id) {
    var found;

    CalendarList.forEach(function (calendar) {
        if (calendar.id === id) {
            found = calendar;
        }
    });

    return found || CalendarList[0];
}

function hexToRGBA(hex) {
    var radix = 16;
    var r = parseInt(hex.slice(1, 3), radix),
        g = parseInt(hex.slice(3, 5), radix),
        b = parseInt(hex.slice(5, 7), radix),
        a = parseInt(hex.slice(7, 9), radix) / 255 || 1;
    var rgba = 'rgba(' + r + ', ' + g + ', ' + b + ', ' + a + ')';

    return rgba;
}

(function () {
    var calendar;
    var id = 0;
    console.log("ESTAMOS AKISIMISO");
    var calendarList = document.getElementById('calendarList');
    var html = [];
    $.post('logic/servicios.php?parAccion=getSchedule_category', function (responseText) {
        var obj = JSON.parse(responseText);
        $.each(obj.Values, function (index, val) {
            calendar = new CalendarInfo();
            calendar.id = String(val.id);
            calendar.name = val.name;
            calendar.color = val.color;
            calendar.bgColor = val.bgColor;
            calendar.dragBgColor = val.dragBgColor;
            calendar.borderColor = val.borderColor;
            addCalendar(calendar);

            html.push('<div class="lnb-calendars-item"><label>' +
                '<input type="checkbox" class="tui-full-calendar-checkbox-round" value="' + val.id + '" checked>' +
                '<span style="border-color: ' + val.borderColor + '; background-color: ' + val.borderColor + ';"></span>' +
                '<span>' + val.name + '</span>' +
                '</label></div>'
            );

        });
        calendarList.innerHTML = html.join('\n');
        $(".move-today").click();
    });
})();
