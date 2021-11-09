function allValidate() {
    checkBlank();
    checkUsernameReqs();
    checkPasswordReqs();
    checkPasswordMatch();
}

function validateLogin() {
    checkBlank();
}

function validateResetPass() {
    checkPassBlank();
    checkPasswordReqs();
    checkPasswordMatch();
}

function checkPassBlank() {
    if(document.getElementById('password').value == "" || document.getElementById('password').value == null) {
        alert("Password cannot be left empty");
        return false;
       }
       if(document.getElementById('confirmpass').value == "" || document.getElementById('confirmpass').value == null) {
        alert("Please confirm password");
        return false;
       }
}

function checkBlank(){
   if (document.getElementById('username').value == "" || document.getElementById('username').value == null) {
    alert("Username cannot be left empty");
    return false;
   }
   checkPassBlank();
}

function checkUsernameReqs() {
    var regex = /^[a-zA-Z0-9_-]{5,16}$/;
    if(regex.test(document.getElementById('username').value) == false) {
      alert("Username must: be more than 5 characters and less than 16 characters, and only include _ and - for special characters");
      document.getElementById('username').focus();
return false;
}
}

function checkPasswordReqs() {
    var regex = /^[a-zA-Z0-9_-]{5,16}$/;
    if(regex.test(document.getElementById('password').value) == false) {
      alert("Password must: be more than 5 characters and less than 16 characters, and only include _ and - for special characters");
      document.getElementById('password').focus();
return false;
}
}

function checkPasswordMatch() {
 var password = document.getElementById('password').value;
 var confirmPassword = document.getElementById('confirmpass').value;

 if (password != confirmPassword) {
     alert("Passwords don't match");
     return false;
 }
}

function showPicture() {
    var picSource = "https://i.pinimg.com/564x/c6/5c/a9/c65ca9209f15e1ca2a24350e9d49ad7d.jpg";
    var img = document.getElementById('motivation')
    img.src = picSource.replace('90x90', '225x225');
    img.style.display = "block";
  } 