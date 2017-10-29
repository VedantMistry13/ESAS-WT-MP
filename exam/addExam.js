function validateRegisterForm() {
    var flag = 0;
    var examForm = document.examForm;
    var course_id = examForm.course_id.value;
    var course_name = examForm.course_name.value;

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

    return true;
}