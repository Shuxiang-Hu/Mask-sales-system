//check if user entered valid password for the first box
//alert and return false otherwise
function checkPassword(){
 
    var password1 = document.getElementById("password").value;
    var password2 = document.getElementById("password2").value;
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
        alert("The two passwords are not the same.");
        returnVal = false;
    }


    return returnVal;
}


//check if user entered valid real name
//alert and return false otherwise
function checkName(){
    var realName = document.getElementById("realname").value;
    var pos = realName.search(/^[A-Z][a-z]+\s[A-Z][a-z]+$/);
    var returnVal = true;

    if((pos != 0) === true)
    {
        alert("The name is not in correct form.\n"+
              "The correct form is: \"Lastname Firstname\"\n");
        returnVal = false;
    }

    return returnVal;
}

function checkEmail(){
    var email = document.getElementById("e-mail").value;
    var pos = email.search(/^.+@.+$/);
    var returnVal = true;

    if((pos != 0) === true)
    {
        alert("The e-mail address is in invalid form.\n"+
              "The correct form is: username@suffix");
	returnVal = false;
    }

    return returnVal;
}


function checkTelephoneNumber(){
    var tel = document.getElementById("tel").value;
    var pos = tel.search(/^[0-9]+$/);
    var returnVal = true;

    if(pos != 0)
    {
        alert("Wrong telephone number.\nTelephone number should be a string of numbers.");
        returnVal = false;
    }

    return returnVal;
}

function checkPassportID(){
    var passportID = document.getElementById("passportID").value;
    var pos = passportID.search(/^[0-9a-zA-Z]+$/);
    var returnVal = true;
    if(pos != 0)
    {
        alert("Wrong ID format.\nPassport ID should be a string of letters and numbers.");
        returnVal = false;
    }

    return returnVal;
}

//check if all the details are valid for a customer
function checkRegister1(){
    var returnVal = true;

    
    returnVal = checkPassword()? returnVal:false;
    returnVal = checkName()? returnVal:false;
    returnVal = checkTelephoneNumber()? returnVal:false;
    returnVal = checkEmail()? returnVal:false;
    returnVal = checkPassportID()? returnVal:false;
        if(returnVal === false)
         {
	window.location.replace("registerationfailed.php");
         }
        return returnVal;

    
}

//check if all the details are valid for  a representative
function checkRegister2(){
    var returnVal = true;

   
    returnVal = checkPassword()? returnVal:false;
    returnVal = checkName()? returnVal:false;
    returnVal = checkTelephoneNumber()? returnVal:false;
    returnVal = checkEmail()? returnVal:false;
    if(returnVal === false)
    {
	window.location.replace("registerationfailed.php");
    }

    return returnVal;
}