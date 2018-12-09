
var methods = {};
var mysql = require('mysql'); // MS Sql Server client
var emailFile = require("./sendmail.js");

function getAllEvents(request, connection, callback){
    var now = new Date();
    var sqlEventDate = now.getFullYear() + "-" + (now.getMonth() + 1) + "-" + now.getDate();
    sql = "select * from events where eventStatus = 'CREATED' and DATEDIFF(eventDate, '" + sqlEventDate + "') >= 0;";
    connection.query(sql, function (err, result) {
        if (err) throw err;
        callback (null, result);
    });
}

function createEvent(request, connection, callback){
    var sendEventEmail = function sendTicketEmail(err, result){
        if(result){
            var newEntry = {
                "username" : request.body.userinfo,
                "title" : request.body.title,
                "eventID" : result
            }
            emailFile.sendEmail(newEntry, 6);
			callback (null, true);
        }
        else{
			callback (null, false);
		}
    }
    createEventHelper(request, connection, sendEventEmail);
}

function createEventHelper(request, connection, callback){
    var now = new Date();
    var eventDate = new Date(request.body.event_date);
    var sqlEventDate = eventDate.getFullYear() + "-" + (eventDate.getMonth() + 1) + "-" + eventDate.getDate();
    sql = "select count(eventId) as total from events;";
    connection.query(sql, function (err, check) {
        if (err) throw err;
        var eventId = now.getFullYear().toString() + now.getMonth().toString() + now.getDate().toString() + check[0].total.toString();
        sql = "insert into events(eventId, title, describtion, userinfo, eventDate, eventStatus) values ('" + eventId + "', '" + request.body.title + "', '" + request.body.desc  + "', '" + request.body.userinfo  + "','" + sqlEventDate + "', 'CREATED');";
        connection.query(sql, function (err, result) {
            if (err) throw err;
            callback (null, eventId);
        });    
    });
}

function getEventInfo(request, connection, callback){
    sql = "select * from events where eventId = '" + request.headers.event_id + "';";
    connection.query(sql, function (err, check) {
        if (err) throw err;
        if(check.length == 0){
            callback (null, false);
        }
        else{
            callback (null, check[0]);
        }
    });
}

function cancelEvent(request, connection, callback){
    sql = "update events set eventStatus ='CANCEL' where eventId = '" + request.headers.event_id + "';";
    connection.query(sql, function (err, check) {
        if (err) throw err;
        else{
            callback (null, true);
        }
    });
}

function updateIntrested(request, connection, callback){
    sql = "select * from events where eventId = '" + request.body.event_id + "';";
    connection.query(sql, function (err, check) {
        var currUsers = check[0].intrested;
        currUsers += "~" + request.body.username;
        var maybe = check[0].maybe;
        var notIntrested = check[0].notIntrested;
        var replaceString = "~" + request.body.username;
        if(maybe != null)
            maybe = maybe.replace(replaceString, '')
        if(notIntrested != null)
            notIntrested = notIntrested.replace(replaceString, '')
        sql = "update events set intrested ='" + currUsers +"', maybe ='" + maybe + "', notIntrested = '" + notIntrested + "' where eventId = '" + request.body.event_id + "';";
        connection.query(sql, function (err, result) {
            if (err) throw err;
            else{
                callback (null, true);
            }
        });
    });
}

function updateNotIntrested(request, connection, callback){
    sql = "select * from events where eventId = '" + request.body.event_id + "';";
    connection.query(sql, function (err, check) {
        var currUsers = check[0].notIntrested;
        currUsers += "~" + request.body.username;
        var maybe = check[0].maybe;
        var intrested = check[0].intrested;
        var replaceString = "~" + request.body.username;
        if(maybe != null)
            maybe = maybe.replace(replaceString, '')
        if(intrested != null)
            intrested = intrested.replace(replaceString, '')
        sql = "update events set intrested ='" + intrested +"', maybe ='" + maybe + "', notIntrested = '" + currUsers + "' where eventId = '" + request.body.event_id + "';";
        connection.query(sql, function (err, result) {
            if (err) throw err;
            else{
                callback (null, true);
            }
        });
    });
}

function updateMaybe(request, connection, callback){
    sql = "select * from events where eventId = '" + request.body.event_id + "';";
    connection.query(sql, function (err, check) {
        var currUsers = check[0].maybe;
        currUsers += "~" + request.body.username;
        var intrested = check[0].intrested;
        var notIntrested = check[0].notIntrested;
        var replaceString = "~" + request.body.username;
        if(intrested != null)
            intrested = intrested.replace(replaceString, '')
        if(notIntrested != null)
            notIntrested = notIntrested.replace(replaceString, '')
        sql = "update events set intrested ='" + intrested +"', maybe ='" + currUsers + "', notIntrested = '" + notIntrested + "' where eventId = '" + request.body.event_id + "';";
        connection.query(sql, function (err, result) {
            if (err) throw err;
            else{
                callback (null, true);
            }
        });
    });
}

function getUserReply(request, connection, callback){
    sql = "select eventId, if(intrested like '" + request.headers.username + "', 'Yes', 'No') as intrested, if(maybe like '" + request.headers.username + "', 'Yes', 'No') as maybe, if(notIntrested like '" + request.headers.username + "', 'Yes', 'No') as notIntrested from events where intrested like '" + request.headers.username + "' or maybe like '" + request.headers.username + "' or notintrested like '" + request.headers.username + "';";
    connection.query(sql, function (err, check) {
        if (err) throw err;
        else{
            callback (null, true);
        }
    });
}

function updateEvent(request, connection, callback){
    sql = "update events set describtion = '" + request.body.describtion + "' where eventId = '" + request.body.event_id + "';";
    connection.query(sql, function (err, check) {
        if (err) throw err;    
        callback(null, true);
    });
}

function deleteEvent(request, connection, callback){
    sql = "select * from events where eventId = '" + request.headers.event_id + "';";
    connection.query(sql, function (err, getData) {
        if (err) throw err;  
        sql = "delete from events where eventId = '" + request.headers.event_id + "';";
        connection.query(sql, function (err, check) {
            if (err) throw err;  
            var usernames = getData[0].intrested + "~" + getData[0].maybe;
            console.log(usernames);
            var newEntry = {
                "eventId" : getData[0].eventId,
                "title" : getData[0].title,
                "usernames" : usernames
            }
            emailFile.sendEmail(newEntry, 8);
            callback(null, true);
        });
    });
}

module.exports = {
    getAllEvents: getAllEvents,
    createEvent: createEvent,
    getEventInfo: getEventInfo,
    cancelEvent: cancelEvent,
    updateIntrested: updateIntrested,
    updateNotIntrested: updateNotIntrested,
    updateMaybe: updateMaybe,
    getUserReply: getUserReply,
    updateEvent: updateEvent,
    deleteEvent: deleteEvent
};

