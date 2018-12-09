
var methods = {};
var mysql = require('mysql'); // MS Sql Server client
var emailFile = require("./sendmail.js");

function getAllOxygenLevels(request, connection, callback){
    sql = "select * from oxygenLevel";
    connection.query(sql, function (err, result) {
        callback (null, result);
    });
}

function getOxygenLevels(request, connection, callback){
    sql = "select e2.aptID, e2.amount, e1.start_date, e1.end_date from (select * from stopOxygen) e1 right join (select * from oxygenLevel where aptID in (select aptID from rental where groupNo in (select groupNo from members where username = '" + request.headers.username + "'))) e2 on e1.aptID = e2.aptID"
    connection.query(sql, function (err, result) {
        callback (null, result);
    });
}

function stopOxygenSuply(request, connection, callback){
    var startDate = new Date(request.body.start_date);
    var endDate = new Date(request.body.end_date);
    var sqlStartDate = startDate.getFullYear() + "-" + (startDate.getMonth() + 1) + "-" + startDate.getDate();
    var sqlEndDate = endDate.getFullYear() + "-" + (endDate.getMonth() + 1) + "-" + endDate.getDate();
    sql = "select * from stopOxygen where aptID = '" + request.body.aptID + "';";
    connection.query(sql, function (err, check) {
        if(check.length == 0){
            sql = "insert into stopOxygen values('" + request.body.aptID + "', '" + sqlStartDate + "', '" + sqlEndDate + "');";
            console.log(sql);
            connection.query(sql, function (err, result) {
                callback (null, true);
            });
        }
        else{
            sql = "update stopOxygen set start_date = '" + sqlStartDate + "', end_date = '" + sqlEndDate + "' where aptID = '" + request.body.aptID + "';";
            connection.query(sql, function (err, result) {
                callback (null, true);
            });
        }
    });
}

function getOxygenInfo(request, connection, callback){
    sql = "select * from stopOxygen where aptID = '" + request.body.aptID + "';";
    connection.query(sql, function (err, check) {
        if(check.length == 0){
            callback (null, false);
        }
        else{
            callback (null, check);
        }
    });
}

function cancelAllRequest(request, connection, callback){
    sql = "delete from stopOxygen where aptID = '" + request.body.aptID + "';";
    connection.query(sql, function (err, check) {
        if (err) throw err;
        else{
            callback (null, true);
        }
    });
}

module.exports = {
    getAllOxygenLevels: getAllOxygenLevels,
    getOxygenLevels: getOxygenLevels,
    stopOxygenSuply: stopOxygenSuply,
    getOxygenInfo: getOxygenInfo,
    cancelAllRequest: cancelAllRequest
};

