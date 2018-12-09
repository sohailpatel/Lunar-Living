var cool = require('cool-ascii-faces');
var express = require('express');
var app = express();
var myParser = require('body-parser');
var mysql = require('mysql'); // MS Sql Server client
var databaseConnectionNameFile = require("./js/database_connection.js");
var loginFile = require("./js/login.js");
var leaseFile = require("./js/lease.js");
var signUpFile = require("./js/signup.js");
var passwordFile = require("./js/password.js");
var userDetailsFile = require("./js/userDetails.js");
var ticketFile = require("./js/ticket.js");
var appointmentFile = require("./js/appointment.js");
var reviewFile = require("./js/review.js");
var paymentFile = require("./js/payment.js");
var laundryFile = require("./js/laundry.js");
var chatFile = require("./js/chat.js");
var oxygenFile = require("./js/oxygen.js");
var eventFile = require("./js/events.js");

app.set('port', (process.env.PORT || 5000));
app.use(express.static(__dirname + '/public'));
app.use(myParser.urlencoded({extended : false}));
app.use(myParser.json())

// views is directory for all template files
app.set('views', __dirname + '/views');
app.set('view engine', 'ejs');

app.get('/', function(request, response) {
  response.render('pages/index')
});

app.get('/cool', function(request, response) {
  response.send(cool());
});

app.listen(app.get('port'), function() {
  console.log('Node app is running on port', app.get('port'));
});

function databaseConnectionResult(err, getConnection){
	console.log(getConnection);
	connection = getConnection;
}
databaseConnectionNameFile.data.databaseConnection(databaseConnectionResult);

app.get('/login', function(request, response) {
	function authenticateUser(err, checkIfAuthenticate){	
		if(checkIfAuthenticate){
			if(checkIfAuthenticate.newuser == 0 || checkIfAuthenticate.userstatus == 0){
				response.send(false);	
			}
			else{
				response.send(checkIfAuthenticate);
			}
		}
		else{
			response.send(checkIfAuthenticate);
		}
	}
	loginFile.checkAuthenticateUser(request, connection, authenticateUser);
});

app.get('/allLogins', function(request, response) {
	function getLoginUsers(err, loginUsers){	
		response.send(loginUsers);
	}
	loginFile.allLogins(request, connection, getLoginUsers);
});

app.post('/enableUser', function(request, response) {
	function getEnableUser(err, loginUsers){	
		response.send(loginUsers);
	}
	loginFile.enableUser(request, connection, getEnableUser);
});

app.post('/createNewUser', function(request, response) {
	function getloginInfo(err, loginUsers){	
		response.send(loginUsers);
	}
	loginFile.createNewUser(request, connection, getloginInfo);
});

app.post('/disableUser', function(request, response) {
	function getDisableUser(err, loginUsers){	
		response.send(loginUsers);
	}
	loginFile.disableUser(request, connection, getDisableUser);
});

app.get('/signup', function(request, response) {
	function authenticateUser(err, checkIfAuthenticate){	
		response.send(checkIfAuthenticate);
	}
	signUpFile.signUpUser(request, connection, authenticateUser);
});

app.post('/signupDetails', function(request, response) {
	function authenticateUser(err, checkIfAuthenticate){	
		response.send(checkIfAuthenticate);
	}
	signUpFile.signUpDetails(request, connection, authenticateUser);
});

app.get('/updateNewUser', function(request, response) {
	function updateNewUserValue(err, updateUserResult){	
		response.send(updateUserResult);
	}
	signUpFile.updateNewUser(request, connection, updateNewUserValue);
});

app.get('/otpVerification', function(request, response) {
	function authenticateDuo(err, checkIfAuthenticate){	
		response.send(checkIfAuthenticate);
	}
	loginFile.checkAuthenticateOTP(request, connection, authenticateDuo);
});

app.get('/forgotPassword', function(request, response) {
	function authenticateUser(err, checkIfAuthenticate){	
		response.send(checkIfAuthenticate);
	}
	passwordFile.forgotPassword(request, connection, authenticateUser);
});

app.post('/updatePassword', function(request, response) {
	function updateNewPassword(err, updatedResult){	
		response.send(updatedResult);
	}
	passwordFile.updatePassword(request, connection, updateNewPassword);
});

app.post('/resetPassword', function(request, response) {
	function resetNewPassword(err, updatedResult){	
		response.send(updatedResult);
	}
	passwordFile.resetPassword(request, connection, resetNewPassword);
});

app.post('/signLease', function (request, response){
	function signLease(err, signLeaseResult){
		response.send(signLeaseResult);
	}
	leaseFile.signNewLease(request, connection, signLease);
});

app.get('/getAllLease', function (request, response){
	function signLease(err, signLeaseResult){
		response.send(signLeaseResult);
	}
	leaseFile.getAllLease(request, connection, signLease);
});

app.get('/getUserDetails', function(request, response) {
	function getUserInfo(err, userDetails){	
		response.send(userDetails);
	}
	userDetailsFile.getUserDetails(request, connection, getUserInfo);
});

app.post('/updateUserDetails', function(request, response) {
	function updateUser(err, result){	
		response.send(result);
	}
	userDetailsFile.updateUserDetails(request, connection, updateUser);
});

app.get('/getUserLease', function(request, response) {
	function getUserInfo(err, userDetails){
		response.send(userDetails);
	}
	userDetailsFile.getUserLease(request, connection, getUserInfo);
});

app.get('/getAvailableApts', function(request, response) {
	function getAllApts(err, allApt){
		response.send(allApt);
	}
	leaseFile.getAvailableApts(request, connection, getAllApts);
});

app.get('/getMembers', function(request, response) {
	function getAllMembers(err, allMembers){
		response.send(allMembers);
	}
	leaseFile.getMembers(request, connection, getAllMembers);
});

app.post('/createTicket', function(request, response) {
	function createNewTicket(err, ticketInfo){
		response.send(ticketInfo);
	}
	ticketFile.createTicket(request, connection, createNewTicket);
});

app.post('/getTicketFilter', function(request, response) {
	function filterTicket(err, ticketInfo){
		response.send(ticketInfo);
	}
	ticketFile.getTicketFilter(request, connection, filterTicket);
});

app.post('/getUserTicketFilter', function(request, response) {
	function filterTicket(err, ticketInfo){
		response.send(ticketInfo);
	}
	ticketFile.getUserTicketFilter(request, connection, filterTicket);
});

app.post('/updateTicket', function(request, response) {
	function updateTicketStatus(err, ticketInfo){
		response.send(ticketInfo);
	}
	ticketFile.updateTicket(request, connection, updateTicketStatus);
});

app.get('/getAllTickets', function(request, response) {
	function getTicketInfo(err, ticketInfo){
		response.send(ticketInfo);
	}
	ticketFile.getAllTickets(request, connection, getTicketInfo);
});

app.get('/hitQuery', function(request, response) {
	function getTicketInfo(err, ticketInfo){
		response.send(ticketInfo);
	}
	ticketFile.hitQuery(request, connection, getTicketInfo);
});

app.post('/bookAppointment', function(request, response) {
	function getBookingInfo(err, bookingInfo){
		response.send(bookingInfo);
	}
	appointmentFile.bookAppointment(request, connection, getBookingInfo);
});

app.get('/getAppointmentTimes', function(request, response) {
	function getBookingInfo(err, bookingInfo){
		response.send(bookingInfo);
	}
	appointmentFile.getAppointmentTimes(request, connection, getBookingInfo);
});

app.get('/getAllAppointment', function(request, response) {
	function getBookingInfo(err, bookingInfo){
		response.send(bookingInfo);
	}
	appointmentFile.getAllAppointment(request, connection, getBookingInfo);
});

app.post('/updateAppointment', function(request, response) {
	function getBookingInfo(err, bookingInfo){
		response.send(bookingInfo);
	}
	appointmentFile.updateAppointment(request, connection, getBookingInfo);
});

app.post('/submitReview', function(request, response) {
	function getReviewInfo(err, reviewInfo){
		response.send(reviewInfo);
	}
	reviewFile.submitReview(request, connection, getReviewInfo);
});

app.get('/getReviews', function(request, response) {
	function getReviewInfo(err, reviewInfo){
		response.send(reviewInfo);
	}
	reviewFile.getReviews(request, connection, getReviewInfo);
});

app.get('/getTicketCount', function(request, response) {
	function getTicketInfo(err, ticketInfo){
		response.send(ticketInfo);
	}
	ticketFile.getTicketCount(request, connection, getTicketInfo);
});

app.get('/getTicketAreaStats', function(request, response) {
	function getTicketInfo(err, ticketInfo){
		response.send(ticketInfo);
	}
	ticketFile.getTicketAreaStats(request, connection, getTicketInfo);
});

app.get('/getTicketStatusStats', function(request, response) {
	function getTicketInfo(err, ticketInfo){
		response.send(ticketInfo);
	}
	ticketFile.getTicketStatusStats(request, connection, getTicketInfo);
});

app.get('/getTicketAvgStats', function(request, response) {
	function getTicketInfo(err, ticketInfo){
		response.send(ticketInfo);
	}
	ticketFile.getTicketAvgStats(request, connection, getTicketInfo);
});

app.post('/pay', function(request, response) {
	function getPaymentInfo(err, paymentInfo){
		response.send(paymentInfo);
	}
	paymentFile.pay(request, connection, getPaymentInfo);
});

app.post('/addPromoCode', function(request, response) {
	function getPaymentInfo(err, paymentInfo){
		response.send(paymentInfo);
	}
	paymentFile.addPromoCode(request, connection, getPaymentInfo);
});

app.post('/applyPromoCode', function(request, response) {
	function getPaymentInfo(err, paymentInfo){
		response.send(paymentInfo);
	}
	paymentFile.applyPromoCode(request, connection, getPaymentInfo);
});

app.post('/updatePromoCode', function(request, response) {
	function getPaymentInfo(err, paymentInfo){
		response.send(paymentInfo);
	}
	paymentFile.updatePromoCode(request, connection, getPaymentInfo);
});

app.get('/getAllPromos', function(request, response) {
	function getPaymentInfo(err, paymentInfo){
		response.send(paymentInfo);
	}
	paymentFile.getAllPromos(request, connection, getPaymentInfo);
});

app.get('/paymentDue', function(request, response) {
	function getPaymentInfo(err, paymentInfo){
		response.send(paymentInfo);
	}
	paymentFile.paymentDue(request, connection, getPaymentInfo);
});

app.get('/paymentHistory', function(request, response) {
	function getPaymentInfo(err, paymentInfo){
		response.send(paymentInfo);
	}
	paymentFile.paymentHistory(request, connection, getPaymentInfo);
});

app.get('/paymentYearStats', function(request, response) {
	function getPaymentInfo(err, paymentInfo){
		response.send(paymentInfo);
	}
	paymentFile.paymentYearStats(request, connection, getPaymentInfo);
});

app.get('/paymentMonthStats', function(request, response) {
	function getPaymentInfo(err, paymentInfo){
		response.send(paymentInfo);
	}
	paymentFile.paymentMonthStats(request, connection, getPaymentInfo);
});

app.get('/paymentAllMonthStats', function(request, response) {
	function getPaymentInfo(err, paymentInfo){
		response.send(paymentInfo);
	}
	paymentFile.paymentAllMonthStats(request, connection, getPaymentInfo);
});

app.post('/bookLaundry', function(request, response) {
	function getBookingInfo(err, bookingInfo){
		response.send(bookingInfo);
	}
	laundryFile.bookLaundry(request, connection, getBookingInfo);
});

app.get('/getLaundryTimes', function(request, response) {
	function getBookingInfo(err, bookingInfo){
		response.send(bookingInfo);
	}
	laundryFile.getLaundryTimes(request, connection, getBookingInfo);
});

app.get('/getAllLaundryTimes', function(request, response) {
	function getBookingInfo(err, bookingInfo){
		response.send(bookingInfo);
	}
	laundryFile.getAllLaundryTimes(request, connection, getBookingInfo);
});

app.post('/sendMsg', function(request, response) {
	function getMessageInfo(err, messageInfo){
		response.send(messageInfo);
	}
	chatFile.sendMsg(request, connection, getMessageInfo);
});

app.get('/fetchUserMsg', function(request, response) {
	function getMessageInfo(err, messageInfo){
		response.send(messageInfo);
	}
	chatFile.fetchUserMsg(request, connection, getMessageInfo);
});

app.get('/fetchReadMsg', function(request, response) {
	function getMessageInfo(err, messageInfo){
		response.send(messageInfo);
	}
	chatFile.fetchReadMsg(request, connection, getMessageInfo);
});

app.post('/sendAdminMsg', function(request, response) {
	function getMessageInfo(err, messageInfo){
		response.send(messageInfo);
	}
	chatFile.sendAdminMsg(request, connection, getMessageInfo);
});

app.get('/fetchAdminMsg', function(request, response) {
	function getMessageInfo(err, messageInfo){
		response.send(messageInfo);
	}
	chatFile.fetchAdminMsg(request, connection, getMessageInfo);
});

app.get('/fetchAdminReadMsg', function(request, response) {
	function getMessageInfo(err, messageInfo){
		response.send(messageInfo);
	}
	chatFile.fetchAdminReadMsg(request, connection, getMessageInfo);
});

app.get('/fetchAllAdminMsg', function(request, response) {
	function getMessageInfo(err, messageInfo){
		response.send(messageInfo);
	}
	chatFile.fetchAllAdminMsg(request, connection, getMessageInfo);
});

app.get('/checkUserStatus', function(request, response) {
	function getMessageInfo(err, messageInfo){
		response.send(messageInfo);
	}
	chatFile.checkUserStatus(request, connection, getMessageInfo);
});

app.get('/checkAdminStatus', function(request, response) {
	function getMessageInfo(err, messageInfo){
		response.send(messageInfo);
	}
	chatFile.checkAdminStatus(request, connection, getMessageInfo);
});

app.get('/getAllOxygenLevels', function(request, response) {
	function getOxygenInfo(err, oxygenInfo){
		response.send(oxygenInfo);
	}
	oxygenFile.getAllOxygenLevels(request, connection, getOxygenInfo);
});

app.get('/getOxygenLevels', function(request, response) {
	function getOxygenInfo(err, oxygenInfo){
		response.send(oxygenInfo);
	}
	oxygenFile.getOxygenLevels(request, connection, getOxygenInfo);
});

app.post('/stopOxygenSuply', function(request, response) {
	function getOxygenInfo(err, oxygenInfo){
		response.send(oxygenInfo);
	}
	oxygenFile.stopOxygenSuply(request, connection, getOxygenInfo);
});

app.post('/cancelAllRequest', function(request, response) {
	function getOxygenInfo(err, oxygenInfo){
		response.send(oxygenInfo);
	}
	oxygenFile.cancelAllRequest(request, connection, getOxygenInfo);
});

app.post('/updateEvent', function(request, response) {
	function getEventInfo(err, eventInfo){
		response.send(eventInfo);
	}
	eventFile.updateEvent(request, connection, getEventInfo);
});

app.get('/deleteEvent', function(request, response) {
	function getEventInfo(err, eventInfo){
		response.send(eventInfo);
	}
	eventFile.deleteEvent(request, connection, getEventInfo);
});

app.post('/updateIntrested', function(request, response) {
	function getEventInfo(err, eventInfo){
		response.send(eventInfo);
	}
	eventFile.updateIntrested(request, connection, getEventInfo);
});

app.post('/updateNotIntrested', function(request, response) {
	function getEventInfo(err, eventInfo){
		response.send(eventInfo);
	}
	eventFile.updateNotIntrested(request, connection, getEventInfo);
});

app.post('/updateMaybe', function(request, response) {
	function getEventInfo(err, eventInfo){
		response.send(eventInfo);
	}
	eventFile.updateMaybe(request, connection, getEventInfo);
});

app.post('/createEvent', function(request, response) {
	function getEventInfo(err, eventInfo){
		response.send(eventInfo);
	}
	eventFile.createEvent(request, connection, getEventInfo);
});

app.get('/getAllEvents', function(request, response) {
	function getEventInfo(err, eventInfo){
		response.send(eventInfo);
	}
	eventFile.getAllEvents(request, connection, getEventInfo);
});

app.get('/getEventInfo', function(request, response) {
	function getEventInfo(err, eventInfo){
		response.send(eventInfo);
	}
	eventFile.getEventInfo(request, connection, getEventInfo);
});

app.get('/cancelEvent', function(request, response) {
	function getEventInfo(err, eventInfo){
		response.send(eventInfo);
	}
	eventFile.cancelEvent(request, connection, getEventInfo);
});

app.get('/getUserReply', function(request, response) {
	function getEventInfo(err, eventInfo){
		response.send(eventInfo);
	}
	eventFile.getUserReply(request, connection, getEventInfo);
});

app.get('/getUserApt', function(request, response) {
	function getLeaseInfo(err, leaseInfo){
		response.send(leaseInfo);
	}
	leaseFile.getUserApt(request, connection, getLeaseInfo);
});

app.get('/getUserTickets', function(request, response) {
	function getTicketInfo(err, ticketInfo){
		response.send(ticketInfo);
	}
	ticketFile.getUserTickets(request, connection, getTicketInfo);
});

app.get('/getTicketInfo', function(request, response) {
	function getTicketInfo(err, ticketInfo){
		response.send(ticketInfo);
	}
	ticketFile.getTicketInfo(request, connection, getTicketInfo);
});