$(document).ready(function() {
    const display = $('.calculator_display');
    let equation = '';
    let currentInput = '';
    let prevInput = '';
    let operator = null;

    const divisionErrorDialog = $('<div title="Error">Division by zero is not allowed.</div>').dialog({
            autoOpen: false,
            modal: true,
            buttons: {
                OK: function() {
                    $(this).dialog("close");
                }
            }
        });

    const enterNumberDialog = $('<div title="Error">Please enter the next number.</div>').dialog({
            autoOpen: false,
            modal: true,
            buttons: {
                OK: function() {
                    $(this).dialog("close");
                }
            }
        });

    function handleButtonClick(event) {
        const button = $(event.target);
        const action = button.data('action');
        const buttonValue = button.text();

        if (!action) {
            currentInput += buttonValue;
            equation += buttonValue;
        } else if (action === 'decimal') {
            if (!currentInput.includes('.')) {
                currentInput += '.';
                equation += '.';
            }
        } else if (action === 'clear') {
            currentInput = '';
            prevInput = '';
            operator = null;
            equation = '';
        } else if (action === 'add' || action === 'subtract' || action === 'multiply' || action === 'divide') {
            if (equation !== '') {
                equation += ' ' + buttonValue + ' ';
            }
            prevInput = currentInput;
            currentInput = '';
            operator = action;
        } else if (action === 'calculate') {
            if (operator && prevInput !== '') {
                const prevNum = parseFloat(prevInput);
                let currentNum;
                if(currentInput!==''){
                    currentNum = parseFloat(currentInput);
                    let result;

                    switch (operator) {
                        case 'add':
                            result = prevNum + currentNum;
                            break;
                        case 'subtract':
                            result = prevNum - currentNum;
                            break;
                        case 'multiply':
                            result = prevNum * currentNum;
                            break;
                        case 'divide':
                            if (currentNum === 0) {
                                divisionErrorDialog.dialog("open");
                                return;
                            }
                            result = prevNum / currentNum;
                            break;
                        default:
                            result = 0;
                    }

                    equation =  result;
                    currentInput = result.toString();
                    prevInput = '';
                    operator = null;
                }
                else{
                    enterNumberDialog.dialog("open");
                }
            }
        }
        display.text(equation);
    }

    const buttons = $('.calculator__keys button');
    buttons.click(handleButtonClick);
});