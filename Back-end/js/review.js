
var methods = {};
var mysql = require('mysql'); // MS Sql Server client
var emailFile = require("./sendmail.js");

function submitReview(request, connection, callback){
    sql = "select rating from reviews where username = '" + request.body.username +"';";
    connection.query(sql, function (err, check) {
        if(check.length == 0){
            sql = "insert into reviews values('" + request.body.username + "', " + request.body.rating + ");";
            connection.query(sql, function (err, result) {
                if (err) throw err;
            });
        }
        else{
            sql = "update reviews set rating = " + request.body.rating + " where username = '" + request.body.username + "';";
            connection.query(sql, function (err, result) {
                if (err) throw err;
            });
        }
    });
    callback(null, true);
}

function getReviews(request, connection, callback){
    sql = "select count(rating) as total from reviews where rating = " + request.headers.rating +";";
    connection.query(sql, function (err, result) {
        callback(null, result[0]); 
    });
}

module.exports = {
    submitReview: submitReview,
    getReviews: getReviews
};

