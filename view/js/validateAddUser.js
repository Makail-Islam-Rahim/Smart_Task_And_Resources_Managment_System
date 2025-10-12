window.onload = function() {
    var form = document.getElementById("addUserForm");

    form.onsubmit = function() {
        if(form.name.value.trim().length < 3){
            alert("Name must be at least 3 characters.");
            return false;
        }

        if(form.email.value.indexOf("@") === -1){
            alert("Please enter a valid email.");
            return false;
        }

        var email = form.email.value.trim();
        for(var i=0; i<existingEmails.length; i++){
            if(existingEmails[i].toLowerCase() === email.toLowerCase()){
                alert("This email is already registered.");
                return false;
            }
        }

        if(form.password.value.length < 6){
            alert("Password must be at least 6 characters.");
            return false;
        }

        var age = parseInt(form.age.value);
        if(isNaN(age) || age < 18 || age > 100){
            alert("Age must be between 18 and 100.");
            return false;
        }

        if(form.gender.value === ""){
            alert("Please select a gender.");
            return false;
        }

        return true;
    };
};
