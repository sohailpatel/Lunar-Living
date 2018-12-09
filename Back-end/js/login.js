
var methods = {};
var mysql = require('mysql'); // MS Sql Server client
var emailFile = require("./sendmail.js");

function checkAuthenticateUser(request, connection, callback){
    var sendOTP = function sendOTP(err, result){
        if(result){
			sql = "delete from duoAuth where username = '" + request.headers.username + "';" ;
			connection.query(sql, function (err, result) {
				if (err) throw err;
			});
			sql = "SELECT SUBSTRING(MD5(RAND()) FROM 1 FOR 6) as password;";
			connection.query(sql, function (err, result) {
				if (err) throw err;
				insertSQL = "insert into duoAuth set ?" ;
				var newEntry = {
					"username" : request.headers.username,
					"otp" : result[0].password
				}
				connection.query(insertSQL, newEntry, function (err, insertOTP) {
					if (err) throw err;
					emailFile.sendEmail(newEntry, 1);
				});
			});
			callback (null, result[0]);
        }
        else{
			callback (null, false);
		}
    }
  	checkAuthenticUserHelper(request, connection, sendOTP);
}

function checkAuthenticUserHelper(request, connection, callback){
	sql = "select username, usertype, newuser, userstatus from login where username = '" + request.headers.username + "' and password = '" + request.headers.password + "';" ;
	connection.query(sql, function (err, result) {
		if (err) throw err;
		if(result.length == 0){
			callback(null, false);
		}
		else{
			callback(null, result);
		}
	});
}

function checkAuthenticateOTP(request, connection, callback){
    var sendOTP = function sendOTP(err, result){
        if(result){
			sql = "delete from duoAuth where username = '" + request.headers.username + "';" ;
			connection.query(sql, function (err, result) {
				if (err) throw err;
			});
			callback (null, true);
        }
        else{
			callback (null, false);
		}
    }
	checkAuthenticateOTPHelper(request, connection, sendOTP);
}

function checkAuthenticateOTPHelper(request, connection, callback){
	sql = "select username from duoAuth where username = '" + request.headers.username + "' and otp = '" + request.headers.otp + "';" ;
	connection.query(sql, function (err, result) {
		if (err) throw err;
		if(result.length == 0){
			callback(null, false);
		}
		else{
			callback(null, true);
		}
	});
}

function allLogins(request, connection, callback){
	sql = "select username, usertype, userstatus from login;" ;
	connection.query(sql, function (err, result) {
		if (err) throw err;
		callback(null, result);
	});
}

function enableUser(request, connection, callback){
	sql = "update login set userstatus = 1 where username = '" + request.body.userinfo + "';" ;
	connection.query(sql, function (err, result) {
		if (err) throw err;
		callback(null, true);
	});
}

function disableUser(request, connection, callback){
	sql = "update login set userstatus = 0 where username = '" + request.body.userinfo + "';" ;
	connection.query(sql, function (err, result) {
		if (err) throw err;
		callback(null, true);
	});
}

function createNewUser(request, connection, callback){
    sql = "SELECT SUBSTRING(MD5(RAND()) FROM 1 FOR 6) as password;";
	connection.query(sql, function (err, result) {
		if (err) throw err;
		sql = "select username from login where username = '" + request.body.email_ID +"';";
		connection.query(sql, function (err, entryPresent) {
			if (err) throw err; 
			if(entryPresent.length == 0){
				sql = "insert into login values ('" + request.body.email_ID + "', '" + result[0].password +"', " + request.body.usertype + ", 0, 1);" ;
				connection.query(sql, function (err, result) {
					if (err) throw err;
				});
				var newEntry = {
					"userInfo" : request.body.email_ID
				}
				emailFile.sendEmail(newEntry, 9);
				callback(null, true);
			}
			else{
				callback(null, false);
			}
		});
	});
}

module.exports = {
	checkAuthenticateUser: checkAuthenticateUser,
	checkAuthenticateOTP : checkAuthenticateOTP,
	allLogins: allLogins,
	enableUser: enableUser,
	disableUser: disableUser,
	createNewUser: createNewUser
};

