function checkLogin(){
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var returnVal = true;

    //if the user name is empty
    //then alert user and return false
    if((username.value === "") === true)
    {
        alert("Please enter user name.");
        returnVal = false;
    }

    //if the password is empty
    //then alert user and return false
    if((password.value === "") === true)
    {
        alert("Please enter password.")
        returnVal = false;
    }

    return returnVal;
}