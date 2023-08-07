document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector(".quiz");

    form.addEventListener("submit", function(event) {
        event.preventDefault();

        const questions = form.getElementsByTagName("section");

        let isFormValid = true;

        for (let i = 0; i < questions.length; i++) {
            const radios = questions[i].querySelectorAll('input[type="radio"]');
            let isChecked = false;

            for (let j = 0; j < radios.length; j++) {
                if (radios[j].checked) {
                    isChecked = true;
                    break;
                }
            }

            if (!isChecked) {
                questions[i].style.border="2px solid red";
                questions[i].querySelector(".error").textContent = "Please select answer.";
                isFormValid = false;
            } else {
                questions[i].style.border = "";
                questions[i].querySelector(".error").textContent = "";
            }
        }
        if (!isFormValid) {
            $( function() {
                $( "#dialog" ).dialog();
            } );
        }else{
            alert("submit success.");
        }
    });
});