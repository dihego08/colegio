'use strict';

/*eslint-disable*/

var ScheduleList = [];

var SCHEDULE_CATEGORY = [
    'milestone',
    'task'
];

function ScheduleInfo() {
    this.id = null;
    this.calendarId = null;

    this.title = null;
    this.body = null;
    this.location = null;
    this.isAllday = false;
    this.start = null;
    this.end = null;
    this.category = '';
    this.dueDateClass = '';

    this.color = null;
    this.bgColor = null;
    this.dragBgColor = null;
    this.borderColor = null;
    this.customStyle = '';

    this.isFocused = false;
    this.isPending = false;
    this.isVisible = true;
    this.isReadOnly = false;
    this.isPrivate = false;
    this.goingDuration = 0;
    this.comingDuration = 0;
    this.recurrenceRule = '';
    this.state = '';

    this.raw = {
        memo: '',
        hasToOrCc: false,
        hasRecurrenceRule: false,
        location: null,
        creator: {
            name: '',
            avatar: '',
            company: '',
            email: '',
            phone: ''
        }
    };
}

function generateTime(schedule, renderStart, renderEnd) {
    var startDate = moment(renderStart.getTime())
    var endDate = moment(renderEnd.getTime());
    var diffDate = endDate.diff(startDate, 'days');

    schedule.isAllday = chance.bool({ likelihood: 30 });
    if (schedule.isAllday) {
        schedule.category = 'allday';
    } else if (chance.bool({ likelihood: 30 })) {
        schedule.category = SCHEDULE_CATEGORY[chance.integer({ min: 0, max: 1 })];
        if (schedule.category === SCHEDULE_CATEGORY[1]) {
            schedule.dueDateClass = 'morning';
        }
    } else {
        schedule.category = 'time';
    }

    startDate.add(chance.integer({ min: 0, max: diffDate }), 'days');
    startDate.hours(chance.integer({ min: 0, max: 23 }))
    startDate.minutes(chance.bool() ? 0 : 30);
    schedule.start = startDate.toDate();

    endDate = moment(startDate);
    if (schedule.isAllday) {
        endDate.add(chance.integer({ min: 0, max: 3 }), 'days');
    }

    schedule.end = endDate
        .add(chance.integer({ min: 1, max: 4 }), 'hour')
        .toDate();

    if (!schedule.isAllday && chance.bool({ likelihood: 20 })) {
        schedule.goingDuration = chance.integer({ min: 30, max: 120 });
        schedule.comingDuration = chance.integer({ min: 30, max: 120 });;

        if (chance.bool({ likelihood: 50 })) {
            schedule.end = schedule.start;
        }
    }
}

function generateNames() {
    var names = [];
    var i = 0;
    var length = chance.integer({ min: 1, max: 10 });

    for (; i < length; i += 1) {
        names.push(chance.name());
    }

    return names;
}

function generateRandomSchedule(calendar, renderStart, renderEnd, sc) {
    console.log("ESTOY EN RANDOM");
    console.log(sc);
    /*const xhr = new XMLHttpRequest();
    xhr.open("POST", "logic/servicios.php?parAccion=getSchedule_list");
    xhr.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
    //const body = JSON.stringify(schedule);
    xhr.onload = (response) => {
        var obj = JSON.parse(response.target.responseText);
        for (let key in obj) {
            console.log(obj[key].title);
        }
    };
    xhr.send();*/
    var schedule = new ScheduleInfo();

    schedule.id = sc.id;
    schedule.calendarId = sc.id_categoria;

    schedule.title = sc.title;
    schedule.body = sc.body;
    schedule.isReadOnly = chance.bool({ likelihood: 20 });
    generateTime(schedule, renderStart, renderEnd);

    schedule.isPrivate = chance.bool({ likelihood: 10 });
    schedule.location = chance.address();
    schedule.attendees = chance.bool({ likelihood: 70 }) ? generateNames() : [];
    schedule.recurrenceRule = chance.bool({ likelihood: 20 }) ? 'repeated events' : '';
    schedule.state = chance.bool({ likelihood: 20 }) ? 'Free' : 'Busy';
    schedule.color = sc.color;
    schedule.bgColor = sc.bgColor;
    schedule.dragBgColor = sc.dragBgColor;
    schedule.borderColor = sc.borderColor;

    if (schedule.category === 'milestone') {
        schedule.color = schedule.bgColor;
        schedule.bgColor = 'transparent';
        schedule.dragBgColor = 'transparent';
        schedule.borderColor = 'transparent';
    }

    schedule.raw.memo = chance.sentence();
    schedule.raw.creator.name = chance.name();
    schedule.raw.creator.avatar = chance.avatar();
    schedule.raw.creator.company = chance.company();
    schedule.raw.creator.email = chance.email();
    schedule.raw.creator.phone = chance.phone();

    if (chance.bool({ likelihood: 20 })) {
        var travelTime = chance.minute();
        schedule.goingDuration = travelTime;
        schedule.comingDuration = travelTime;
    }

    ScheduleList.push(schedule);
    console.log(ScheduleList);
    
}

async function generateSchedule(viewName, renderStart, renderEnd) {
    ScheduleList = [];

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "logic/servicios.php?parAccion=getSchedule_list");
    xhr.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
    //const body = JSON.stringify(schedule);
    xhr.onload = (response) => {
        var obj = JSON.parse(response.target.responseText);
        CalendarList.forEach(function (calendar) {
            console.log("CALENDARIO");
            console.log(calendar);
            console.log("CALENDARIO");
            var i = 0, length = 10;
            if (viewName === 'month') {
                length = 3;
            } else if (viewName === 'day') {
                length = 4;
            }
            for (let key in obj.filter(item => item.id_categoria == calendar.id)) {
                console.log(obj[key].title);
                generateRandomSchedule(calendar, renderStart, renderEnd, obj[key]);
            }
        });
    };
    xhr.onerror = (error) => {
        console.error('Request failed:', error);
    };
    xhr.send();
}
