
var methods = {};
var nodeMailer = require('nodemailer');

function sendEmail(newEntry, type){
	var transporter = nodeMailer.createTransport({
		service: 'gmail',
		auth: {
			user: 'email-address',
			pass: 'password'
		}
	});
	var mailOptions;
	//OTP Email
	if(type == 1){
		mailOptions = {
			from: 'username',
			to: newEntry.username,
			subject: 'OTP from Lunar Living',
			text: 'Hi,\r\n This is your one time password - ' + newEntry.otp
		};
	}
	//Ticket Email
	else if(type == 2){
		mailOptions = {
			from: 'username',
			to: newEntry.username,
			subject: 'Ticket Created for ' + newEntry.aptID,
			text: 'Hi,\r\n Your ticket has been created and your ticketID is - ' + newEntry.ticketID
		};
	}
	//Appointment Email
	else if(type == 3){
		mailOptions = {
			from: 'username',
			to: newEntry.userInfo,
			subject: 'Visit confirmed to Lunar Living',
			text: 'Hi,\r\n Your visit has been confirmed and your appointmentID is - ' + newEntry.appointmentID + '\r\nAppointment Date - ' + newEntry.appointmentDate + '\r\nAppointment Time - ' + newEntry.appointmentTime
		};
	}
	//Payment Email
	else if(type == 4){
		mailOptions = {
			from: 'username',
			to: newEntry.username,
			subject: 'Payment received to Lunar Living',
			text: 'Hi,\r\n Your payment has been received and your PaymentID is - ' + newEntry.paymentID + '\r\nApartment Name - ' + newEntry.aptID + '\r\nAmount - ' + newEntry.amount
		};
	}
	//Laundry Email
	else if(type == 5){
		mailOptions = {
			from: 'username',
			to: newEntry.userInfo,
			subject: 'Laundry Service booked',
			text: 'Hi,\r\n Your laundry service has been confirmed and your appointmentID is - ' + newEntry.appointmentID + '\r\nAppointment Date - ' + newEntry.appointmentDate + '\r\nAppointment Time - ' + newEntry.appointmentTime + '\r\nMachine Id - ' + newEntry.machineNo
		};
	}
	//Event Email
	else if(type == 6){
		mailOptions = {
			from: 'username',
			to: newEntry.username,
			subject: 'Event ' + newEntry.title + ' is Live',
			text: 'Hi,\r\n Your Event has been created and your evenID is - ' + newEntry.eventID
		};
	}
	//Appointment Update Email
	else if(type == 7){
		mailOptions = {
			from: 'username',
			to: newEntry.userInfo,
			subject: 'Change in your Appointment',
			text: 'Hi,\r\n Your appointment with ID - ' + newEntry.appointmentID + ' status just got changed to - ' + newEntry.status
		};
	}
	//delete event
	else if(type == 8){
		var usernames = newEntry.usernames.split("~");
		usernames.forEach(function(value){
			if(value != 'null'){
				mailOptions = {
					from: 'username',
					to: value,
					subject: 'Event ' + newEntry.title + ' got cancelled',
					text: 'Hi,\r\n The Event with evenID - ' + newEntry.eventId + ' just got cancelled'
				};
				transporter.sendMail(mailOptions, function(error, info){
					if (error) {
						console.log(error);
					} else {
						console.log('Email sent: ' + info.response);
					}
				});	
			}
		});
	}
	//Appointment Update Email
	else if(type == 9){
		mailOptions = {
			from: 'username',
			to: newEntry.userInfo,
			subject: 'Lunar Living - Signup now',
			text: 'Hi,\r\n Your email was added by admin for signup. Please signup to get access.'
		};
	}
	if(type != 8){
		transporter.sendMail(mailOptions, function(error, info){
			if (error) {
				console.log(error);
			} else {
				console.log('Email sent: ' + info.response);
			}
		});
	}
}


module.exports = {
	sendEmail: sendEmail
};

