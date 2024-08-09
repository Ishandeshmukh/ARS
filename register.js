function check() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;
    
    if (password == confirmPassword) {
        return true;
    } else {
        alert("Please confirm the password again");
        return false;
      
    }
  }