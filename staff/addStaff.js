function validateRegisterForm() {
    var flag = 0;
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
    var staffForm = document.staffForm;
    var firstname = staffForm.firstname.value;
    var lastname = staffForm.lastname.value;

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
    if (!staffForm.email.value.match(mailformat)) {  
        flag = 3;
        alert("You have entered an invalid email address!");
        return false;
    }

    return true;
}