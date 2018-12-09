
var methods = {};
var mysql = require('mysql'); // MS Sql Server client
/*
export PATH=${PATH}:/usr/local/mysql/bin/
mysql -u root -p*/

methods.databaseConnection = function (callback){
	var connection = mysql.createConnection({
		host: 'localhost',
		user: 'root',
		password: 'root',
		database: 'lunar_living'
	});
	connection.connect(function(err) {
		console.log(err);	
		if (err) throw err;
		callback (null, connection);
	});
}

exports.data = methods;