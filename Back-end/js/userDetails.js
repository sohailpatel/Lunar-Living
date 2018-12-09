
var methods = {};
var mysql = require('mysql'); // MS Sql Server client
var emailFile = require("./sendmail.js");

function delay(){
	return new Promise(resolve => setTimeout(resolve, 100));
}

async function delayedLog(){
	await delay();
}

function getUserDetails(request, connection, callback){
    sql = "select first_name, last_name, gender from userDetails where username = '" + request.headers.username + "';" ;
	connection.query(sql, function (err, result) {
		if (err) throw err;
		if(result.length == 0){
			callback(null, false);
		}
		else{
			callback(null, result[0]);
		}
	});
}

function getUserLease(request, connection, callback){
	sql = "select groupNo from members where username = '" + request.headers.username + "';" ;
	connection.query(sql, function (err, result) {
		if (err) throw err;
		if(result.length == 0){
			callback(null, false);
		}
		else{
			var allLeaseData = function allLeaseData(err, result){
				callback(null, result);
			}
			getUserLeaseHelper(request, connection, result, allLeaseData);
		}
	});
}

async function getUserLeaseHelper(request, connection, groupNos, callback){
	var allLeaseReturn = {};
	var key = "Lease";
	allLeaseReturn[key] = [];
	var currDate = new Date();
	for(const element of groupNos){
		sql = "select * from rental where groupNo = '" + element.groupNo + "';" ;
		connection.query(sql, function (err, currLeaseInfo) {
			if (err) throw err;
			if(currLeaseInfo.length > 0){
				var endDate = new Date(currLeaseInfo[0].end_date);
				if(endDate > currDate){
					allLeaseReturn[key].push(currLeaseInfo[0]);
				}
			}
		});
	}
	await delayedLog();
	callback(null, allLeaseReturn);
}


function updateUserDetails(request, connection, callback){
	sql = "select * from userDetails where username = '" + request.body.username + "';" ;
	connection.query(sql, function (err, result) {
		if (err){
			throw err;
		}
		console.log(result[0]);
		if(result.length == 0){
			sql = "insert into userDetails values('" + request.body.username + "','" + request.body.first_name + "','" + request.body.last_name +"','" + request.body.gender + "');" ;
			connection.query(sql, function (err, result) {
				if (err){
					throw err;
				}
				else{
					callback(null, true);
				}
			});
		}
		else{
			sql = "update userDetails set first_name = '" + request.body.first_name + "', last_name = '" + request.body.last_name +"', gender = '" + request.body.gender + "' where username = '" + request.body.username + "';" ;
			connection.query(sql, function (err, result) {
				if (err){
					throw err;
				}
				else{
					callback(null, true);
				}
			});
		}
	});
}

module.exports = {
    getUserDetails: getUserDetails,
	getUserLease: getUserLease,
	updateUserDetails: updateUserDetails
};

