$(document).ready(function() {
    $('.add').on('click', addChoice);
    $('.remove').on('click', removeChoice);
    setupValidation();

});


/*create new input to add new option*/
function addChoice(event) {
    event.preventDefault();
    const choicesContainer = $('.choices');
    const choiceCount = choicesContainer.children('.choice-input').length + 1; // Get the count of existing choices
    const newInput = $('<input type="text" name="choice[]"  autocomplete="off"/>');
    const newErrorSpan = $('<span class="error"></span>');
    const newChoiceInput = $('<div class="choice-input"></div>').append('<span class="choice-number">' + choiceCount + '.</span>', newInput, newErrorSpan); // Add the numbering
    choicesContainer.append(newChoiceInput);
    newInput.on('blur input', function() {
        updateInputValidation(this, this.value.trim() !== "", "Choice is required");
        setupValidation();
    });
}

/*remove input and chick number of input at least two*/
function removeChoice(event) {
    event.preventDefault();
    const choicesContainer = $('.choices');
    const choiceInputs = choicesContainer.find('.choice-input');
    if (choiceInputs.length > 2) {
        choiceInputs.last().remove();

        // Update the numbering of remaining choices
        choiceInputs.each(function(index) {
            $(this).find('.choice-number').text((index + 1) + '.');
        });
    } else {
        alert("You need at least two choices");
    }
}

/*update color border green is valid and red invalid*/
function updateInputValidation(inputElement, isValid, errorMessage) {
    const messageElement = $(inputElement).next();
    if (isValid) {
        $(inputElement).css('border', '2px solid green');
        messageElement.text('');
    } else {
        $(inputElement).css('border', '2px solid red');
        messageElement.text(errorMessage);
    }
}

/*chick if input is not empty*/
function validateInput(inputElement, errorMessage) {
    const isValid = inputElement.value.trim() !== "";
    updateInputValidation(inputElement, isValid, errorMessage);
    return isValid;
}

/*make validation when join  input and out ,without fill input show error message */
function setupValidation() {
    const question = $("#question");
    const correctAnswer = $("input[name='correctAnswer']");


    const fieldSelect = $("#fieldSelect");
    const choiceInputs = $(".choices input[type='text']");

    question.on("blur input", function() {
        updateInputValidation(this, this.value.trim() !== "", "Question is required");
    });

    correctAnswer.on("blur input", function() {
        updateInputValidation(this, this.value.trim() !== "", "Correct Answer is required");
    });

    fieldSelect.on("change input", function() {
        updateInputValidation(this, this.value !== "", "Please choose a field");
    });

    choiceInputs.on("blur input", function() {
        updateInputValidation(this, this.value.trim() !== "", "Choice is required");

        // Check for duplicate choices
        const choiceValues = choiceInputs.map(function() {
            return $(this).val().trim();
        }).get();

        let duplicateChoices = false;

        for (let i = 0; i < choiceValues.length; i++) {
            if (choiceValues.indexOf(choiceValues[i]) !== i) {
                duplicateChoices = true;
                break;
            }
        }

        const isDuplicate = duplicateChoices && choiceValues.indexOf($(this).val().trim()) !== choiceValues.lastIndexOf($(this).val().trim());
        const errorMessage = isDuplicate ? "Duplicate choice" : "Choice is required";
        updateInputValidation(this, this.value.trim() !== "" && !isDuplicate, errorMessage);
    });
}

/*make validation when submit form and each input not fill show error message*/
//using in index page
function validateForm() {
    const question = $("#question");
    const correctAnswer = $("#correctAnswer");
    const fieldSelect = $("#fieldSelect");
    const choiceInputs = $(".choices input[type='text']");

    const questionIsValid = validateInput(question[0], "Question is required");
    const correctAnswerIsValid = validateInput(correctAnswer[0], "Correct Answer is required");
    const fieldIsValid = fieldSelect.val() !== "";

    updateInputValidation(fieldSelect[0], fieldIsValid, "Please choose a field");

    const choiceValues = choiceInputs.map(function() {
        return $(this).val().trim();
    }).get();

    let duplicateChoices = false;

    for (let i = 0; i < choiceValues.length; i++) {
        if (choiceValues.indexOf(choiceValues[i]) !== i) {
            duplicateChoices = true;
            break;
        }
    }

    choiceInputs.each(function() {
        const isValid = $(this).val().trim() !== "";
        const isDuplicate = duplicateChoices && choiceValues.indexOf($(this).val().trim()) !== choiceValues.lastIndexOf($(this).val().trim());
        const errorMessage = isDuplicate ? "Duplicate choice" : "Choice is required";
        updateInputValidation(this, isValid && !isDuplicate, errorMessage);
    });

    const validChoiceInputs = choiceInputs.filter(':not(.error)');
    const atLeastTwoChoices = validChoiceInputs.length >= 2;

    if (!atLeastTwoChoices) {
        alert("You need at least two choices");
    }

    return questionIsValid && correctAnswerIsValid && fieldIsValid && atLeastTwoChoices && !duplicateChoices;
}

// Add this function to handle the delete action
function deleteQuestion(questionID,questions) {
    console.log(questionID);
    console.log(questions);
    const confirmationDialog = $('<div title="Confirm Delete">Are you sure you want to delete this question?</div>').dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            Confirm: function() {
                $.ajax({
                    type: "POST",
                    url: "/Internship/test/app/Controllers/cont_delete_question.php\n", // Replace with the actual PHP file to delete the question
                    data: { questionID: questionID,
                        questions : questions},
                    success: function(response) {
                        // Reload the tab content after successful deletion
                        $("#questionRow_" + questionID).remove();
                        alert("Question removed successfully");
                        location.reload();
                        },
                    error: function(xhr, status, error) {
                        console.log("Error deleting question:", error);
                        alert("An error occurred while deleting the question. Please try again.");
                    }
                });
                $(this).dialog("close");
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });

    confirmationDialog.dialog("open");
}

function updateForm() {
    setupValidation();
    const formData = $("#updateQuestionForm").serialize();

    const choiceIDs = [];
    const newChoiceIDs = [];

    $("input[name^='choice']").each(function() {
        const choiceID = $(this).attr("id");
        const choiceValue = $(this).val();

        if (choiceID) {
            choiceIDs.push({ key: choiceID, value: choiceValue });
        } else {
            newChoiceIDs.push({ value: choiceValue });
        }
    });
    console.log("Choice IDs:", choiceIDs);
    console.log("New Choice IDs:", newChoiceIDs);


    const Data = {
        choiceIDs: choiceIDs
    };
    if (newChoiceIDs.length > 0) {
        Data.newChoiceIDs = newChoiceIDs;
    }
    const hiddenData = document.getElementById("hiddenData");
    hiddenData.setAttribute("value",  JSON.stringify(Data));
}

function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
}