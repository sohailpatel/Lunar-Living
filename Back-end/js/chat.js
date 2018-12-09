
var methods = {};
var mysql = require('mysql'); // MS Sql Server client
var emailFile = require("./sendmail.js");

function sendMsg(request, connection, callback){
    var appointmentDate = new Date();
    sql = "select msg from chats where username = '" + request.body.username +"';";
    connection.query(sql, function (err, check) {
        if(check.length == 0){
            var msg = appointmentDate.getHours() + ":" +appointmentDate.getSeconds() + "^" + request.body.firstName + "-" + request.body.msg;
            sql = "insert into chats value('" + request.body.username + "','" + request.body.firstName + "','" + msg + "',0, 0, 1, 1);";
            connection.query(sql, function (err, result) {
                if (err) throw err;
            });
        }
        else{
            var msg = check[0].msg + "~" + appointmentDate.getHours() + ":" +appointmentDate.getSeconds() + "^" +request.body.firstName + "-" +  request.body.msg;
            sql = "update chats set msg ='" + msg + "', deliveredUser = 0, readUser = 0, deliveredAdmin = 1, readAdmin = 1 where username = '" + request.body.username + "';";
            connection.query(sql, function (err, result) {
                if (err) throw err;
            });
        }
    });
    callback(null, true);
}

function fetchUserMsg(request, connection, callback){
    sql = "select msg from chats where username = '" + request.headers.username +"';";
    connection.query(sql, function (err, result) {
        sql = "update chats set deliveredUser = 0 where username = '" + request.headers.username + "';";
        connection.query(sql, function (err, update) {
            if (err) throw err;
        });
        callback (null, result[0]);
    });
}

function fetchReadMsg(request, connection, callback){
    sql = "update chats set readUser = 0 where username = '" + request.headers.username + "';";
    connection.query(sql, function (err, update) {
        if (err) throw err;
    });
    callback (null, result[0]);
}

function sendAdminMsg(request, connection, callback){
    var appointmentDate = new Date();
    sql = "select msg from chats where username = '" + request.body.username +"';";
    connection.query(sql, function (err, check) {
        if(check.length == 0){
            
        }
        else{
            var msg = check[0].msg + "~" + appointmentDate.getHours() + ":" +appointmentDate.getSeconds() + "^" +request.body.firstName + "-" +  request.body.msg;
            sql = "update chats set msg ='" + msg + "', deliveredUser = 1, readUser = 1, deliveredAdmin = 0, readAdmin = 0 where username = '" + request.body.username + "';";
            connection.query(sql, function (err, result) {
                if (err) throw err;
            });
        }
    });
    callback(null, true);
}

function fetchAdminMsg(request, connection, callback){
    sql = "select msg from chats where username = '" + request.headers.username +"';";
    connection.query(sql, function (err, result) {
        sql = "update chats set deliveredAdmin = 0 where username = '" + request.headers.username + "';";
        connection.query(sql, function (err, update) {
            if (err) throw err;
        });
        callback (null, result[0]);
    });
}

function fetchAdminReadMsg(request, connection, callback){
    sql = "update chats set readAdmin = 0 where username = '" + request.headers.username + "';";
    connection.query(sql, function (err, update) {
        if (err) throw err;
    });
    callback (null, result[0]);
}

function fetchAllAdminMsg(request, connection, callback){
    sql = "select username, msg from chats where readAdmin = 1;";
    connection.query(sql, function (err, result) {
        sql = "update chats set deliveredAdmin = 0 where username = '" + request.headers.username + "';";
        connection.query(sql, function (err, update) {
            if (err) throw err;
        });
        callback (null, result);
    });
}

function checkUserStatus(request, connection, callback){
    sql = "select deliveredUser, readUser from chats where username = '" + request.headers.username +"';";
    connection.query(sql, function (err, result) {
       callback (null, result[0]);
    });
}

function checkAdminStatus(request, connection, callback){
    sql = "select deliveredAdmin, readAdmin from chats where username = '" + request.headers.username +"';";
    connection.query(sql, function (err, result) {
       callback (null, result[0]);
    });
}

module.exports = {
    sendMsg: sendMsg,
    fetchUserMsg: fetchUserMsg,
    fetchReadMsg: fetchReadMsg,
    sendAdminMsg: sendAdminMsg,
    fetchAdminMsg: fetchAdminMsg,
    fetchAdminReadMsg: fetchAdminReadMsg,
    fetchAllAdminMsg: fetchAllAdminMsg,
    checkUserStatus: checkUserStatus,
    checkAdminStatus: checkAdminStatus
};

