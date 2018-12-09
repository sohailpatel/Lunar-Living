
var methods = {};
var mysql = require('mysql'); // MS Sql Server client
var emailFile = require("./sendmail.js");

function bookLaundry(request, connection, callback){
    var sendBookingEmail = function sendBookingEmail(err, result){
        if(result){
            emailFile.sendEmail(result, 5);
			callback (null, true);
        }
        else{
			callback (null, false);
		}
    }
    bookLaundryHelper(request, connection, sendBookingEmail);
}

function bookLaundryHelper(request, connection, callback){
    var appointmentDate = new Date();
    var sqlAppointmentDate = appointmentDate.getFullYear() + "-" + (appointmentDate.getMonth() + 1) + "-" + appointmentDate.getDate();
    sql = "select count(appointmentID) as total from laundry where visitDate = '" + sqlAppointmentDate +"' and visitTime = '" + request.body.visit_time +"' and machineID = " + request.body.machine_id + ";";
    connection.query(sql, function (err, check) {
        if(check[0].total == 0){
            sql = "select count(appointmentID) as total from laundry;";
            connection.query(sql, function (err, result) {
                if (err) throw err;
                var appointmentID = "apt" + (result[0].total + 1) + appointmentDate.getMonth() + appointmentDate.getDate() + appointmentDate.getFullYear();
                var bookingDetails = {
                    "appointmentID": appointmentID,
                    "appointmentDate": appointmentDate.toString().substring(0, 15),
                    "appointmentTime":request.body.visit_time,
                    "userInfo": request.body.user_info,
                    "machineNo": request.body.machine_id
                };
                sql = "insert into laundry values('"+ appointmentID + "', '" + sqlAppointmentDate + "', '" + request.body.visit_time +"', 1, '" + request.body.user_info + "', " + request.body.machine_id + ")";
                connection.query(sql, function (err, result) {
                    if (err) throw err;
                    callback (null, bookingDetails);
                });
            });
        }
        else{
            callback (null, false);
        }
    });
    
}

function getLaundryTimes(request, connection, callback){
    var appointmentDate = new Date();
    var sqlAppointmentDate = appointmentDate.getFullYear() + "-" + (appointmentDate.getMonth() + 1) + "-" + appointmentDate.getDate();
    sql = "select GROUP_CONCAT(visitTime) as timings from laundry where visitDate = '" + sqlAppointmentDate +"' and machineID =" + request.headers.machine_id + ";";
    connection.query(sql, function (err, result) {
        callback (null, result[0]);
    });
}

function getAllLaundryTimes(request, connection, callback){
    var appointmentDate = new Date();
    var sqlAppointmentDate = appointmentDate.getFullYear() + "-" + (appointmentDate.getMonth() + 1) + "-" + appointmentDate.getDate();
    sql = "select GROUP_CONCAT(visitTime) as timings, machineID from laundry where visitDate = '" + sqlAppointmentDate + "' group by machineID;";
    connection.query(sql, function (err, result) {
        callback (null, result);
    });
}

module.exports = {
    bookLaundry: bookLaundry,
    getLaundryTimes: getLaundryTimes,
    getAllLaundryTimes: getAllLaundryTimes
};

