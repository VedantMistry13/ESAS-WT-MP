function validateRegisterForm() {
    var flag = 0;
    var examForm = document.examForm;
    var course_id = examForm.course_id.value;
    var course_name = examForm.course_name.value;
    var held_on = examForm.held_on;
    var start_time = examForm.start_time.value;
    var end_time = examForm.end_time.value;

    var trimCourseId = course_id.trim();
    var trimCourseName = course_name.trim();

    // test for course id
    if (trimCourseId === "") {
        flag = 1;
        alert("Please enter a valid course id.");
        return false;
    }

    // test for course name
    if (trimCourseName === "") {
        flag = 1;
        alert("Please enter a valid course name.");
        return false;
    }

    // test for course id length
    if (trimCourseId.length != 5) {
        flag = 4;
        alert("Please enter a course id of 5 character length.");
        return false;
    }

    // validate date
    var isValidDate = validateDate(held_on);
    if (!isValidDate) {
        return false;
    }

    // validate start time
    var isValidStartTime = validateTime(start_time, "start");
    if (!isValidStartTime) {
        return false;
    }
    
    // validate end time
    var isValidEndTime = validateTime(end_time, "end");
    if (!isValidEndTime) {
        return false;
    }

    return true;
}

function validateDate(inputText) {  
  var dateformat = /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/;
  if (inputText.value.match(dateformat)) {  
      var opera1 = inputText.value.split('/');  
      var opera2 = inputText.value.split('-');  
      lopera1 = opera1.length;  
      lopera2 = opera2.length;  

      if (lopera1 > 1) {  
        var pdate = inputText.value.split('/');  
      } else if (lopera2 > 1) {  
        var pdate = inputText.value.split('-');  
      }  
      var dd = parseInt(pdate[2]);  
      var mm  = parseInt(pdate[1]);  
      var yy = parseInt(pdate[0]);  
      
      var ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];  
      if (mm == 1 || mm > 2) {  
          if (dd>ListofDays[mm-1]) {  
              alert('Invalid date format!');  
              return false;  
          }  
      }  
      if (mm == 2) {  
          var lyear = false;  
          if ( (!(yy % 4) && yy % 100) || !(yy % 400)) {  
            lyear = true;  
          }  
          if ((lyear==false) && (dd>=29)) {  
              alert('Invalid date format!');  
              return false;  
          }  
          if ((lyear==true) && (dd>29)) {  
              alert('Invalid date format!');  
              return false;  
          }  
      }
      return true;
  } else {  
      alert("Please enter a proper date!");  
      return false;  
  }  
}

function validateTime(inputText, inputName) {
    var regex = /^([0-1][0-9]|2[0-3]):([0-5][0-9])$/;
    var isValid = regex.test(inputText);
    if (!isValid) {
        alert('Invalid ' + inputName + ' time!');
        return false;
    } else {
        return true;
    }
}