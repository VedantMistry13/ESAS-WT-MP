function validateRegisterForm() {
    var flag = 0;
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
    var registerForm = document.registerForm;
    var firstname = registerForm.first_name.value;
    var lastname = registerForm.last_name.value;
    var password = registerForm.password.value;
    var cpassword = registerForm.cpassword.value;

    var trimFname = firstname.trim();
    var trimLname = lastname.trim();

    // test for firstname
    if (trimFname === "") {
        flag = 1;
        alert("Please enter a valid firstname");
        return false;
    }

    // test for lastname
    if (trimLname === "") {
        flag = 1;
        alert("Please enter a valid lastname");
        return false;
    }

    // test for email
    if (!registerForm.email.value.match(mailformat)) {  
        flag = 3;
        alert("You have entered an invalid email address!");
        return false;
    }

    // test for password
    if (password.length < 6
        || password !== cpassword) {
        flag = 4;
        alert("The passwords you have entered do not match or does not have a necessary length of 6 characters!");
        return false;
    }

    return true;
}