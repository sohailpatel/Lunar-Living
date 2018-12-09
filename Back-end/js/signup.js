
var methods = {};
var mysql = require('mysql'); // MS Sql Server client
var emailFile = require("./sendmail.js");

function signUpUser(request, connection, callback){
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
				connection.query(insertSQL, newEntry, function (err, entryOTP) {
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
    signUpUserHelper(request, connection, sendOTP);
}

function signUpUserHelper(request, connection, callback){
	sql = "select username, usertype, newuser from login where username = '" + request.headers.username + "';" ;
	connection.query(sql, function (err, result) {
		if (err) throw err;
		if(result.length == 0){
            callback(null, false);
		}
		else if(result[0].newuser == 0){
            callback(null, result);
        }
        else{
            callback(null, false);
        }
	});
}

function updateNewUser(request, connection, callback){
	sql = "update login set newuser = 1 where username = '" + request.headers.username + "';" ;
    connection.query(sql, function (err, result) {
        if (err) throw err;
        if(result){
            callback(null, true);
        }
        else{
            callback(null, false);
        }
    });
}

function signUpDetails(request, connection, callback){
	sql = "select * from userDetails where username = '" + request.body.username + "';" ;
    connection.query(sql, function (err, result) {
        if (err) throw err;
        if(result.length == 0){
            sql = "insert into userDetails values('"+ request.body.username + "','" + request.body.firstName + "','" + request.body.lastName + "','" + request.body.gender + "')";
			connection.query(sql, function (err, result) {
				if (err) throw err;
				callback(null, true);
			});
        }
        else{
            callback(null, false);
        }
    });
}

module.exports = {
    signUpUser: signUpUser,
	updateNewUser: updateNewUser,
	signUpDetails: signUpDetails
};

