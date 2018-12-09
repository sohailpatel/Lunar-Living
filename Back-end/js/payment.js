
var methods = {};
var mysql = require('mysql'); // MS Sql Server client
var emailFile = require("./sendmail.js");

function pay(request, connection, callback){
    var sendPaymentEmail = function sendPaymentEmail(err, result){
        if(result){
            emailFile.sendEmail(result, 4);
			callback (null, true);
        }
        else{
			callback (null, false);
		}
    }
    paymentHelper(request, connection, sendPaymentEmail);
}

function paymentHelper(request, connection, callback){
    sql = "select count(paymentID) as total from payments";
    connection.query(sql, function (err, countResult) {
        if (err) throw err;
        var paymentDate = new Date();
        var sqlPayementDate = paymentDate.getFullYear() + "-" + (paymentDate.getMonth() + 1) + "-" + paymentDate.getDate();
        var paymentID = request.body.aptID + paymentDate.getFullYear() + paymentDate.getMonth() + paymentDate.getDate() + countResult[0].total;
        sql = "insert into payments values('" + paymentID + "', '" + request.body.aptID + "','" + request.body.username + "'," + request.body.amount + ",'" + sqlPayementDate + "');";
        connection.query(sql, function (err, result) {
            if (err) throw err;
            var newEntry = {
                "paymentID" : paymentID,
                "aptID" : request.body.aptID,
                "username" : request.body.username,
                "amount" : request.body.amount,
                "paymentDate" : sqlPayementDate
            }
            callback (null, newEntry);
        });
    });
}

function paymentDue(request, connection, callback){
    var date = new Date();
    var currMonth = date.getMonth() + 1;
    var currYear = date.getFullYear();
    sql = "select * from rental where aptID = '" + request.headers.apt_name + "' and aptID not in (select aptID from payments where month(paidOn) = " + currMonth + " and year(paidOn) = " + currYear + ");";
    connection.query(sql, function (err, checkResult) {
        if (err) throw err;
        if(checkResult.length == 0){
            var paymnetInfo = {
                "amount" : 0
            }
            callback (null, paymnetInfo);
        }
        else{
            var totalDue = 0;
            sql = "select basicPay from apt where aptID = '" + request.headers.apt_name + "';";
            connection.query(sql, function (err, result) {
                var paymnetInfo = {
                    "amount" : result[0].basicPay
                }
                callback (null, paymnetInfo);
            });
        }
    });
}

function paymentHistory(request, connection, callback){
    sql = "select * from payments where aptID = '" + request.headers.apt_name + "';";
    connection.query(sql, function (err, checkResult) {
        if (err) throw err;
        callback(null, checkResult);
    });
}

function paymentYearStats(request, connection, callback){
    sql = "select sum(amount) as total from payments where year(paidOn) = " + request.headers.year + ";";
    connection.query(sql, function (err, checkResult) {
        if (err) throw err;
        callback(null, checkResult[0]);
    });
}

function paymentMonthStats(request, connection, callback){
    sql = "select sum(amount) as total from payments where month(paidOn) = " + request.headers.month + ";";
    connection.query(sql, function (err, checkResult) {
        if (err) throw err;
        callback(null, checkResult[0]);
    });
}

function paymentAllMonthStats(request, connection, callback){
    sql = "select sum(amount) as total, month(paidOn) as month from payments group by month(paidOn);";
    connection.query(sql, function (err, checkResult) {
        if (err) throw err;
        callback(null, checkResult);
    });
}

function addPromoCode(request, connection, callback){
    sql = "select count(*) as total from promocode where promoID = '" + request.body.promocode + "';";
    connection.query(sql, function (err, checkResult) {
        if (err) throw err;
        if(checkResult[0].total == 0){
            sql = "insert into promocode(promoID, maxuse, offBy, promoStatus) values('" + request.body.promocode + "', " + request.body.maxuse + ","+ request.body.offBy +", 1);";
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

function applyPromoCode(request, connection, callback){
    sql = "select * from promocode where promoID = '" + request.body.promocode + "';";
    connection.query(sql, function (err, checkResult) {
        if (err) throw err;
        if(checkResult.length == 0){
            callback(null, false);
        }
        else{
            var count = 0;
            if(checkResult[0].usedBy != null){
                var re = new RegExp(request.body.username,"g");
                count = (checkResult[0].usedBy.match(re) || []).length;
                console.log(count);
            }
            if(count >= checkResult[0].maxuse || checkResult[0].promoStatus == 0){
                callback(null, false);
            }
            else{
                var newVal = request.body.amount - ((checkResult[0].offBy * request.body.amount) / 100);
                var usedByUser = checkResult[0].usedBy + "~" + request.body.username;
                sql = "update promocode set usedBy = '" + usedByUser + "' where promoID = '" + request.body.promocode + "';";
                connection.query(sql, function (err, updatepromo) {
                    if (err) throw err;
                    var result = {
                        "amount" : newVal
                    }
                    callback(null, result);
                });
            }
        }
    });
}

function updatePromoCode(request, connection, callback){
    sql = "update promocode set promoStatus = " + request.body.status + " where promoID = '" + request.body.promocode + "';";
    connection.query(sql, function (err, checkResult) {
        if (err) throw err;
        callback(null, true);
    });
}

function getAllPromos(request, connection, callback){
    sql = "select * from promocode";
    connection.query(sql, function (err, checkResult) {
        if (err) throw err;
        callback(null, checkResult);
    });
}

module.exports = {
    pay: pay,
    paymentDue: paymentDue,
    paymentHistory: paymentHistory,
    paymentYearStats: paymentYearStats,
    paymentMonthStats: paymentMonthStats,
    paymentAllMonthStats: paymentAllMonthStats,
    addPromoCode: addPromoCode,
    applyPromoCode: applyPromoCode,
    updatePromoCode: updatePromoCode,
    getAllPromos: getAllPromos
};

