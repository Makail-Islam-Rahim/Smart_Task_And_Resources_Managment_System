function validateForm() {
    let userName = document.getElementById("name");
    let email = document.getElementById("email");
    let password = document.getElementById("password");
    let age = document.getElementById("age");
    let maleRB = document.getElementById("male");
    let femaleRB = document.getElementById("female");
    let role = document.getElementById("roleId");

    let nameErr = document.getElementById("nameErr");
    let emailErr = document.getElementById("emailErr");
    let passErr = document.getElementById("passErr");
    let ageErr = document.getElementById("ageErr");
    let genderErr = document.getElementById("genderErr");
    let roleErr = document.getElementById("roleErr");

    let nameRegex = /^[A-Za-z\s]{3,}$/;
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let passRegex = /^.{6,}$/;
    let ageRegex = /^(1[89]|[2-9][0-9]|100)$/;

    let isValidated = true;

    nameErr.innerHTML = "";
    emailErr.innerHTML = "";
    passErr.innerHTML = "";
    ageErr.innerHTML = "";
    genderErr.innerHTML = "";
    roleErr.innerHTML = "";

    if (!nameRegex.test(userName.value.trim())) {
        nameErr.innerHTML = "Please provide a valid name (letters only, at least 3 characters)";
        nameErr.style.color = "red";
        isValidated = false;
    }

    if (!emailRegex.test(email.value.trim())) {
        emailErr.innerHTML = "Please enter a valid email address";
        emailErr.style.color = "red";
        isValidated = false;
    }

    if (!passRegex.test(password.value.trim())) {
        passErr.innerHTML = "Password must be at least 6 characters";
        passErr.style.color = "red";
        isValidated = false;
    }

    if (!ageRegex.test(age.value.trim())) {
        ageErr.innerHTML = "Please enter a valid age (18–100)";
        ageErr.style.color = "red";
        isValidated = false;
    }

    if (!maleRB.checked && !femaleRB.checked) {
        genderErr.innerHTML = "Please select gender";
        genderErr.style.color = "red";
        isValidated = false;
    }

    if (role.value === "") {
        roleErr.innerHTML = "Please select a role";
        roleErr.style.color = "red";
        isValidated = false;
    }

    return isValidated;
}
