
var methods = {};
var mysql = require('mysql'); // MS Sql Server client
var emailFile = require("./sendmail.js");

function createTicket(request, connection, callback){
    var sendTicketEmail = function sendTicketEmail(err, result){
        if(result){
            var newEntry = {
                "username" : request.body.createdBy,
                "aptID" : request.body.aptID,
                "ticketID" : result
            }
            emailFile.sendEmail(newEntry, 2);
			callback (null, true);
        }
        else{
			callback (null, false);
		}
    }
    createTicketHelper(request, connection, sendTicketEmail);
}

function createTicketHelper(request, connection, callback){
    sql = "select count(ticketID) as currNo from tickets where aptID = '" + request.body.aptID + "';" ;
    connection.query(sql, function (err, result) {
        if (err) throw err;
        var ticketID;
        if(result[0].currNo == null){
            ticketID = request.body.aptID + 1;
            newTicketHelper(request, connection, ticketID);
        }
        else{
            ticketID = request.body.aptID + result[0].currNo + 1;
            newTicketHelper(request, connection, ticketID);
        }
        callback (null, ticketID);
    });
}

function newTicketHelper(request, connection, ticketID){
    var aptID = request.body.aptID;
    var createdBy = request.body.createdBy;
    var about = request.body.about;
    var openDate = new Date();
    var sqlOpenDate = openDate.getFullYear() + "-" + (openDate.getMonth() + 1) + "-" + openDate.getDate();
    sql = "insert into tickets(ticketID, aptID, ticketStatus, createdBy, title, about, openDate) values ('" + ticketID + "', '" + aptID + "','" + "CREATED" +"','" + createdBy + "','" + request.body.title + "','" + about + "', '" + sqlOpenDate + "');" ;
    connection.query(sql, function (err, result) {
        if (err) throw err;
    });
}

function updateTicket(request, connection, callback){
    var sendTicketEmail = function sendTicketEmail(err, result){
        if(result){
            callback (null, true);
        }
        else{
			callback (null, false);
		}
    }
    updateTicketHelper(request, connection, sendTicketEmail);
}

function updateTicketHelper(request, connection, callback){
    var updatedBy = request.body.username;
    var ticketID = request.body.ticketID;
    var ticketStatus = request.body.ticketStatus;
    var closedDate = new Date();
    var sqlClosedDate = closedDate.getFullYear() + "-" + (closedDate.getMonth() + 1) + "-" + closedDate.getDate();
    sql = "update tickets set ticketStatus = '" + ticketStatus + "', closedDate = '" + sqlClosedDate + "', lastUpdatedBy = '" + updatedBy +"' where ticketID = '" + ticketID + "';";
    connection.query(sql, function (err, result) {
        if (err) throw err;
        callback(null, true);
    });
}

function getAllTickets(request, connection, callback){
    sql = "select * from tickets;";
    connection.query(sql, function (err, result) {
        if (err) throw err;
        callback(null, result);
    });
}

function getTicketCount(request, connection, callback){
    sql = "select count(ticketID) as total from tickets where ticketStatus = 'CREATED' and aptID in (select aptID from apt where aptLocation = '" + request.headers.location_name + "');";
    connection.query(sql, function (err, result) {
        if (err) throw err;
        callback(null, result[0]);
    });
}

function getTicketAreaStats(request, connection, callback){
    sql = "select count(ticketID) as total, aptLocation as location from tickets natural join apt group by aptLocation;";
    connection.query(sql, function (err, result) {
        if (err) throw err;
        callback(null, result);
    });
}

function getTicketStatusStats(request, connection, callback){
    sql = "select count(ticketID) as total, ticketStatus from tickets group by ticketstatus;";
    connection.query(sql, function (err, result) {
        if (err) throw err;
        callback(null, result);
    });
}

function getTicketAvgStats(request, connection, callback){
    sql = "select AVG(DATEDIFF(closedDate, openDate)) as avgDiff from tickets where ticketStatus = 'CLOSED';";
    connection.query(sql, function (err, result) {
        if (err) throw err;
        callback(null, result[0]);
    });
}

function getUserTickets(request, connection, callback){
    sql = "select * from tickets where aptID in (select aptID from rental natural join members where members.username='" + request.headers.username + "');";
    connection.query(sql, function (err, result) {
        if (err) throw err;
        callback(null, result);
    });
}

function getTicketInfo(request, connection, callback){
    sql = "select * from tickets where ticketID='" + request.headers.ticket_id + "';";
    connection.query(sql, function (err, result) {
        if (err) throw err;
        callback(null, result[0]);
    });
}

function getTicketFilter(request, connection, callback){
    sql = "select * from tickets ";
    var id = request.body.id;
    var apt = request.body.apt;
    var title = request.body.title;
    var status = request.body.status;
    var area = request.body.area;
    if(id == '' && apt == '' && title == '' && status == '' && area == ''){
        sql += ";";
    }
    else{
        sql += "where ";
        var flag = false;
        if(id != ""){
            sql += "ticketID = '" + id + "'";
            flag = true;
        }
        if(apt != ""){
            if(flag){
                sql += " and ";
            }
            sql += "aptID = '" + apt + "'";
            flag = true;
        }
        if(title != ""){
            if(flag){
                sql += " and ";
            }
            sql += "title = '" + title + "'";
            flag = true;
        }
        if(status != ""){
            if(flag){
                sql += " and ";
            }
            sql += "ticketStatus = '" + status + "'";
            flag = true;
        }
        if(area != ""){
            if(flag){
                sql += " and ";
            }
            sql += "aptID in (select aptID from apt where aptLocation = '" + area + "')";
            flag = true;
        }
        sql += ";";
    }
    var ret ={
        query : sql
    }
    callback(null, ret);
}

function getUserTicketFilter(request, connection, callback){
    sql = "select * from tickets where aptID in (select aptID from rental natural join members where members.username = '" + request.body.username + "') ";
    var id = request.body.id;
    var title = request.body.title;
    var status = request.body.status;
    if(id == '' && title == '' && status == ''){
        sql += ";";
    }
    else{
        sql += "and ";
        var flag = false;
        if(id != ""){
            sql += "ticketID = '" + id + "'";
            flag = true;
        }
        if(title != ""){
            if(flag){
                sql += " and ";
            }
            sql += "title = '" + title + "'";
            flag = true;
        }
        if(status != ""){
            if(flag){
                sql += " and ";
            }
            sql += "ticketStatus = '" + status + "'";
            flag = true;
        }
        sql += ";";
    }
    var ret ={
        query : sql
    }
    callback(null, ret);
}

function hitQuery(request, connection, callback){
    sql = request.headers.query;
    connection.query(sql, function (err, result) {
        if (err) throw err;
        callback(null, result);
    });
}

module.exports = {
    createTicket: createTicket,
    updateTicket: updateTicket,
    getAllTickets: getAllTickets,
    getTicketCount: getTicketCount,
    getTicketAreaStats: getTicketAreaStats,
    getTicketStatusStats: getTicketStatusStats,
    getTicketAvgStats: getTicketAvgStats,
    getUserTickets: getUserTickets,
    getTicketInfo: getTicketInfo,
    getTicketFilter: getTicketFilter,
    getUserTicketFilter: getUserTicketFilter,
    hitQuery: hitQuery
};

