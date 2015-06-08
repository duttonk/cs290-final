/* Source: http://www.formget.com/form-validation-using-ajax/ */
/* Source: Piazza post @376 */
function checkForm() {
	var name = document.getElementById("user").value;
	var password = document.getElementById("password1").value;

	/* Source: http://stackoverflow.com/questions/9618504/
	get-radio-button-value-with-javascript */
	var types = document.getElementsByName("type");
	for (var i = 0, length = types.length; i < length; i++) {
		if (types[i].checked) {
			var type1 = types[i].value;
		}
	}

	/* No blank fields */
	if (name == '' || password == '') {
		alert("Oops! It looks like you missed a spot.\nPlease complete all fields.");
		return false;
	} 

	var xmlhttp = new XMLHttpRequest();

	if (!xmlhttp) {
		throw "Unable to create XML HTTP Request.";
	}

	xmlhttp.onreadystatechange = function() {
		if ((this.readyState === 4) && (this.status === 200)) {
			var data = this.responseText;
			if (data == "match") {
				location.href = "account.php";

			} else if (data == "Already logged in.") {
				alert ("You are already logged in.");
				location.href = "account.php";
			} else if (data == "Wrong user.") {
				alert ("Whoops! Someone else is already logged in.\nLog out existing user before proceding.");
				return false;
			} else if (data == "User name taken.") {
				alert("Sorry, that username is taken.\nPlease try again.");
				return false;
			} else if (data == "User name incorrect.") {
				alert("Username entered incorrectly.\nPlease try again.");
				return false;
			} else if (data == "No match") {
				alert("Password incorrect.\nPlease try again.");
				return false;
			} else {
				alert("Login failed.\nPlease try again.");
				return false;
			}
		}
	};

	var req = "type="+type1+"&username="+name+"&password="+password;

	xmlhttp.open("POST", "pass3.php?"+req, true);
	xmlhttp.send();

};

function logout() {
	window.location = "signin.php?action=logout";
};

function acctUpdate() {
	var name = document.getElementById("newName").value;
	var gender = document.getElementById("gender").value;
	var dob = document.getElementById("newDOB").value;
	var newLoc = document.getElementById("newLoc").value;
	var quote = document.getElementById("newQuote").value;

	var xmlhttp = new XMLHttpRequest();

	if (!xmlhttp) {
		throw "Unable to create XML HTTP Request.";
	}

	xmlhttp.onreadystatechange = function() {
		if ((this.readyState === 4) && (this.status === 200)) {
			var data = this.responseText;
			var test = data.indexOf("updated");
			if (test != -1) {
				alert("Information updated.");
				window.location.href = "account.php";
			} else {
				alert("Update failed.\nPlease try again.");
				return false;
			}
		}
	};

	var req = "name="+name+"&gender="+gender+"&dob="+dob+"&location="+newLoc+"&inspiration="+quote;

	xmlhttp.open("POST", "updateAcct.php?"+req, true);
	xmlhttp.send();

};

function workUpdate() {
	var date = document.getElementById("newWorkDate").value;
	var type = document.getElementById("activity").value;
	var cal = document.getElementById("cal").value;
	var hrs = document.getElementById("hrs").value;
	var min = document.getElementById("min").value;
	var notes = document.getElementById("notes").value;

	if (document.getElementById("hiding").value == "1") {
		var getWeather = document.getElementById("curWeather").value;
	} else {
		var getWeather = "";
	}

	/* Date cannot be empty */
	if (date == "") {
		alert("Error! A date is required.");
		return false;
	}

	/* Hours and minutes > 0, minutes <= 60 */
	if ((hrs == "") || (min == "")) {
		alert ("Hours and minutes must be positive integers.");
		return false;
	}

	if (hrs == 0 && min == 0) {
		alert("Either hours or minutes must be larger than zero.");
	}

	if(hrs < 0 || min < 0) {
		alert("Hours and minutes must be larger than zero.");
		return false;
	}

	if (min > 60) {
		alert ("Minutes should be less than 60.");
		return false;
	}

	/* Set time for MySQL time type insertion */
	var time = hrs+":"+min+":00";

	var xmlhttp = new XMLHttpRequest();

	if (!xmlhttp) {
		throw "Unable to create XML HTTP Request.";
	}

	xmlhttp.onreadystatechange = function() {
		if ((this.readyState === 4) && (this.status === 200)) {
			var data = this.responseText;
			var test = data.indexOf("newdate");
			var test2 = data.indexOf("update");
			if (test != -1) {
				alert("Workout added.");
				window.location.href = "workout.php";
			} else if (test == -1 && test2 != -1) {
				alert("Workout updated.");
				window.location.href = "workout.php";
			} else {
				alert("Error in update - check input");
				return false;
			}
		}
	};

	var req = "date="+date+"&type="+type+"&duration="+time+"&cal="+cal+"&notes="+notes+"&weather="+getWeather;

	xmlhttp.open("POST", "newWorkout.php?"+req, true);
	xmlhttp.send();
};

function addActivity() {
	var activity = document.getElementById("activity").value;

	/* Must not be empty */
	if (activity == "") {
		alert("New activity name must be entered.");
		return false;
	}

	var xmlhttp = new XMLHttpRequest();

	if (!xmlhttp) {
		throw "Unable to create XML HTTP Request.";
	}

	xmlhttp.onreadystatechange = function() {
		if ((this.readyState === 4) && (this.status === 200)) {
			var data = this.responseText;
			if (data == "added") {
				alert("Activity added.");
				window.location.href = "updateWork.php";
			} else if (data == "exists") {
				alert("Error - activity already exists.");
				return false;
			}
		}
	};

	var req = "activity="+activity;
	xmlhttp.open("POST", "addActivity.php?"+req, true);
	xmlhttp.send();

};

function getWeather() {
	var zip = document.getElementById("newzip").value;

	/* Zip code cannot be empty */
	if (zip == "") {
		alert("Zip code must be filled in to get weather.")
	}

	var req = new XMLHttpRequest();
	if(!req) {
		throw 'Unable to create HttpRequest.';
	}

	var url = 'http://api.openweathermap.org/data/2.5/weather?zip='+zip+",us";

	req.onreadystatechange = function() {
		if(this.readyState===4) {
			var response = JSON.parse(this.responseText);

			/* Source: http://adripofjavascript.com/blog/drips/finding-an-objects-size-in-javascript.html */
			var length = Object.keys(response).length;

			if (length > 3) {
				var main = response.weather[0].main;
			} else {
				alert("Error - invalid US zip code entered.\nRefresh the page and try again, or leave blank.");
				return false;
			}
			
			document.getElementById("curWeather").value = main;
			document.getElementById("hiding").value = "1";
		}
	};

	req.open('GET', url);
	req.send();
};

function updateFriend1() {
	var position = 1;
	var newFriend = document.getElementById("replace1").value;

	if (newFriend == "NULL") {
		newFriend = "";
	}

	var xmlhttp = new XMLHttpRequest();

	if (!xmlhttp) {
		throw "Unable to create XML HTTP Request.";
	}

	xmlhttp.onreadystatechange = function() {
		if ((this.readyState === 4) && (this.status === 200)) {
			var data = this.responseText;
			var test = data.indexOf("updated");
			if (test != -1) {
				alert("Inner Circle Updated!");
				window.location.href = "updateFriends.php";
			} else {
				alert("Update failed.\nPlease try again.");
				return false;
			}
		}
	};

	var req = "pos="+position+"&friend="+newFriend;

	xmlhttp.open("POST", "friendSearch.php?"+req, true);
	xmlhttp.send();
};

function updateFriend2() {
	var position = 2;
	var newFriend = document.getElementById("replace2").value;

	if (newFriend == "NULL") {
		newFriend = "";
	}

	var xmlhttp = new XMLHttpRequest();

	if (!xmlhttp) {
		throw "Unable to create XML HTTP Request.";
	}

	xmlhttp.onreadystatechange = function() {
		if ((this.readyState === 4) && (this.status === 200)) {
			var data = this.responseText;
			var test = data.indexOf("updated");
			if (test != -1) {
				alert("Inner Circle Updated!");
				window.location.href = "updateFriends.php";
			} else {
				alert("Update failed.\nPlease try again.");
				return false;
			}
		}
	};

	var req = "pos="+position+"&friend="+newFriend;

	xmlhttp.open("POST", "friendSearch.php?"+req, true);
	xmlhttp.send();
};

function updateFriend3() {
	var position = 3;
	var newFriend = document.getElementById("replace3").value;

	if (newFriend == "NULL") {
		newFriend = "";
	}

	var xmlhttp = new XMLHttpRequest();

	if (!xmlhttp) {
		throw "Unable to create XML HTTP Request.";
	}

	xmlhttp.onreadystatechange = function() {
		if ((this.readyState === 4) && (this.status === 200)) {
			var data = this.responseText;
			var test = data.indexOf("updated");
			if (test != -1) {
				alert("Inner Circle Updated!");
				window.location.href = "updateFriends.php";
			} else {
				alert("Update failed.\nPlease try again.");
				return false;
			}
		}
	};

	var req = "pos="+position+"&friend="+newFriend;

	xmlhttp.open("POST", "friendSearch.php?"+req, true);
	xmlhttp.send();
};

function backtoaccount() {
	window.location.href = "account.php";
};

function uploadPhotoW() {
	$target_dir = "uploads/";
	$target_file = $target_dir + document.getElementById("fileToUpload").value;
}