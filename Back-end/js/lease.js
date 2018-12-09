var methods = {};
var mysql = require('mysql'); // MS Sql Server client

function delay(){
	return new Promise(resolve => setTimeout(resolve, 100));
}

async function delayedLog(){
	await delay();
}

function signNewLease(request, connection, callback){
    var newLease = function newLease(err, result){
        if(result){
			sql = "select max(groupNo) as currNo from members;" ;
			connection.query(sql, function (err, result) {
                if (err) throw err;
                if(result[0].currNo == null){
                    newGroupHelper(request, connection, 1);
                    newRentalHelper(request, connection, 1);
                    createLoginHelper(request, connection);
                }
                else{
                    newGroupHelper(request, connection, result[0].currNo + 1);
                    newRentalHelper(request, connection, result[0].currNo + 1);
                    createLoginHelper(request, connection);
                }
                callback (null, true);
            });
        }
        else{
			callback (null, false);
		}
    }
    signNewLeaseHelper(request, connection, newLease);
}

function signNewLeaseHelper(request, connection, callback){
    sql = "select * from rental where aptId = '" + request.body.apt_ID + "';" ;
	connection.query(sql, function (err, result) {
        if (err) throw err;
		if(result.length == 0){
			callback(null, true);
        }
        else{
            var startDate = new Date(request.body.start_date);
            var endDate = result[0].end_date;
            if(endDate < startDate){
                sql = "delete from members where groupNo = '" + result[0].groupNo + "';" ;
                connection.query(sql, function (err, result) {
                    if (err) throw err;
                });            
                sql = "delete from rental where aptID = '" + request.body.apt_ID + "';" ;
                connection.query(sql, function (err, result) {
                    if (err) throw err;
                });            
                callback(null, true);
            }
            else{
                callback(null, false);
            }
		}
	});
}

function newGroupHelper(request, connection, currGroupNo){
    var newEmails = request.body.email_ID;
    newEmails.forEach(element => {
        sql = "insert into members values (" + currGroupNo + ", '" + element +"');" ;
        connection.query(sql, function (err, result) {
            if (err) throw err;
        }); 
    });
}

function newRentalHelper(request, connection, currGroupNo){
    var startDate = new Date(request.body.start_date);
    var endDate = new Date(request.body.end_date);
    var sqlStartDate = startDate.getFullYear() + "-" + (startDate.getMonth() + 1) + "-" + startDate.getDate();
    var sqlEndDate = endDate.getFullYear() + "-" + (endDate.getMonth() + 1) + "-" + endDate.getDate();
    sql = "insert into rental values ('" + request.body.apt_ID + "', " + currGroupNo + ",'" + sqlStartDate + "','" + sqlEndDate + "');" ;
    connection.query(sql, function (err, result) {
        if (err) throw err;
    }); 
}

function createLoginHelper(request, connection, currGroupNo){
    var newEmails = request.body.email_ID;
    newEmails.forEach(element => {
        sql = "SELECT SUBSTRING(MD5(RAND()) FROM 1 FOR 6) as password;";
        connection.query(sql, function (err, result) {
            if (err) throw err;
            sql = "select username from login where username = '" + element +"';";
            connection.query(sql, function (err, entryPresent) {
                if (err) throw err; 
                if(entryPresent.length == 0){
                    sql = "insert into login values ('" + element + "', '" + result[0].password +"', 1, 0, 1);" ;
                    connection.query(sql, function (err, result) {
                        if (err) throw err;
                    });
                }
            });
        });
    });
}

function getAvailableApts(request, connection, callback){
    var getApt = function newLease(err, rentedApt){
        var notInAptId = rentedApt.length ? ( "'" + rentedApt.join("', '") + "'" ) : '';
        sql = "select aptID from apt where aptID not in (" + notInAptId + ");" ;
        connection.query(sql, function (err, availableApt) {
            if (err) throw err;
            callback (null, availableApt);
        });
    }
    sql = "select * from rental;" ;
    connection.query(sql, function (err, rentedApts) {
        if (err) throw err;
        getRentedApts(rentedApts, getApt);
    });
}

async function getRentedApts(rentedApts, callback){
    var currDate = new Date();
    var rentedApt = [];
    for(const apt of rentedApts){
        var endDate = new Date(apt.end_date);
		if(endDate > currDate){
            rentedApt.push(apt.aptID);
        }
    }
    await delayedLog();
    callback(null, rentedApt);
}

function getMembers(request, connection, callback){
    sql = "select username from members where groupNo = " + request.headers.group_number + ";" ;
    connection.query(sql, function (err, members) {
        if (err) throw err;
        if(members.length == 0){
            callback (null, false);
        }
        else{
            callback (null, members);
        }
    });
}

function getAllLease(request, connection, callback){
    sql = "select r.aptID, group_concat(username) as usernames, r.start_date, r.end_date from rental r natural join members m group by aptID;" ;
    connection.query(sql, function (err, result) {
        if (err) throw err;
        callback (null, result);
    });
}

function getUserApt(request, connection, callback){
    sql = "select distinct r.aptID from rental r natural join members m where m.username='" + request.headers.username + "';";
    connection.query(sql, function (err, result) {
        if (err) throw err;
        callback (null, result);
    });
}

module.exports = {
    signNewLease: signNewLease,
    getAvailableApts: getAvailableApts,
    getMembers: getMembers,
    getAllLease: getAllLease,
    getUserApt: getUserApt
};

