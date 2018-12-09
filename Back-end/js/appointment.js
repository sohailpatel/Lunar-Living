
var methods = {};
var mysql = require('mysql'); // MS Sql Server client
var emailFile = require("./sendmail.js");

function bookAppointment(request, connection, callback){
    var sendBookingEmail = function sendBookingEmail(err, result){
        if(result){
            emailFile.sendEmail(result, 3);
			callback (null, true);
        }
        else{
			callback (null, false);
		}
    }
    bookAppointmentHelper(request, connection, sendBookingEmail);
}

function bookAppointmentHelper(request, connection, callback){
    var appointmentDate = new Date(request.body.visit_date);
    var sqlAppointmentDate = appointmentDate.getFullYear() + "-" + (appointmentDate.getMonth() + 1) + "-" + appointmentDate.getDate();
    sql = "select count(appointmentID) as total from appointments where visitDate = '" + sqlAppointmentDate +"' and visitTime = '" + request.body.visit_time +"';";
    connection.query(sql, function (err, check) {
        if(check[0].total == 0){
            sql = "select count(appointmentID) as total from appointments;";
            connection.query(sql, function (err, result) {
                if (err) throw err;
                var appointmentID = "apt" + (result[0].total + 1) + appointmentDate.getMonth() + appointmentDate.getDate() + appointmentDate.getFullYear();
                var bookingDetails = {
                    "appointmentID": appointmentID,
                    "appointmentDate": appointmentDate.toString().substring(0, 15),
                    "appointmentTime":request.body.visit_time,
                    "userInfo": request.body.user_info
                };
                sql = "insert into appointments values('"+ appointmentID + "', '" + sqlAppointmentDate + "', '" + request.body.visit_time +"', 1, '" + request.body.user_info + "')";
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

function getAppointmentTimes(request, connection, callback){
    var appointmentDate = new Date(request.headers.visit_date);
    var sqlAppointmentDate = appointmentDate.getFullYear() + "-" + (appointmentDate.getMonth() + 1) + "-" + appointmentDate.getDate();
    sql = "select GROUP_CONCAT(visitTime) as timings from appointments where visitDate = '" + sqlAppointmentDate +"' and status = 1;";
    connection.query(sql, function (err, result) {
        if (err) throw err;
        callback (null, result[0]);
    });
}

function updateAppointment(request, connection, callback){
    sql = "update appointments set status = " + request.body.status + " where appointmentID = '" + request.body.appointmentID +"';";
    connection.query(sql, function (err, result) {
        if (err) throw err;
        var status = 'Reject';
        if(request.body.status == 1){
            status = 'Accepted';
        }
        var bookingDetails = {
            "appointmentID": request.body.appointmentID,
            "userInfo": request.body.userinfo,
            "status": status
        }
        emailFile.sendEmail(bookingDetails, 7);
        callback (null, true);
    });
}

function getAllAppointment(request, connection, callback){
    sql = "select * from appointments where visitDate >= CURDATE();";
    connection.query(sql, function (err, result) {
        if (err) throw err;
        callback (null, result);
    });
}

module.exports = {
    bookAppointment: bookAppointment,
    getAppointmentTimes: getAppointmentTimes,
    getAllAppointment: getAllAppointment,
    updateAppointment: updateAppointment
};

