
//check if user entered valid password for the first box
//alert and return false otherwise
function checkPassword(){
 
    var password1 = document.getElementById("newpassword1").value;
    var password2 = document.getElementById("newpassword2").value;
    var pos = password1.search(/^[0-9a-zA-Z_]+$/);
    var returnVal = true;
    
    //if this password is empty
    //alert the user and return false
    if((password1.length < 10 || password1.length > 25) === true)
    {
        alert("Password is between 10 and 25 characters.\nEnter again.");
        returnVal = false;
    }

    //password can only contain numbers, letters and '_'
    //otherwise alert user and return false
    if((pos != 0) === true)
    {
        alert("Password can only contain numbers, letters and underscores.\nEnter again");
        returnVal = false;

    }

    //check if user entered two identical passwords
    //alert and return false otherwise
    if(password1 != password2)
    {
        alert("The two password are not the same.");
        returnVal = false;
    }

    return returnVal;
}





//check if all the details are valid
function checkSubmit(){
    var returnVal = checkPassword();
	if((returnVal === false) === true)
	{	
		
		window.location.replace("changePasswordFailed.php");
	}
    return returnVal;
}