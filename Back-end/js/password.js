
var methods = {};
var mysql = require('mysql'); // MS Sql Server client

function forgotPassword(request, connection, callback){
    sql = "select username, newuser from login where username = '" + request.headers.username + "';" ;
    connection.query(sql, function (err, result) {
        if (err) throw err;
        if(result.length == 0){
            callback (null, false);        
        }
        else if(result[0].newuser == 0){
            callback (null, false);
        }
        else{
            sql = "SELECT SUBSTRING(MD5(RAND()) FROM 1 FOR 6) as password;";
			connection.query(sql, function (err, result) {
				if (err) throw err;
				insertSQL = "insert into duoAuth set ?" ;
				var newEntry = {
					"username" : request.headers.username,
					"otp" : result[0].password
				}
				connection.query(insertSQL, newEntry, function (err, result) {
					if (err) throw err;
				});
            });
            callback (null, true);
        }
    });
}

function updatePassword(request, connection, callback){
    sql = "update login set password = '" + request.body.password + "' where username = '" + request.body.username + "';" ;
    connection.query(sql, function (err, result) {
        if (err) throw err;
        callback(null, true);
    });
}

function resetPassword(request, connection, callback){
    sql = "select username from login where password = '" + request.body.password + "' and username = '" + request.body.username + "';" ;
    connection.query(sql, function (err, result) {
        if (err) throw err;
        if(result.length == 1){
            sql = "update login set password = '" + request.body.new_password + "' where username = '" + request.body.username + "';" ;
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
    forgotPassword: forgotPassword,
    updatePassword: updatePassword,
    resetPassword: resetPassword
};

