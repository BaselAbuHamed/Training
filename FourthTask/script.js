document.addEventListener('DOMContentLoaded', function() {
    const display = document.querySelector('.calculator_display');
    let currentInput = '';
    let prevInput = '';
    let operator = null;


    function handleButtonClick(event) {
        const button = event.target;
        const action = button.dataset.action;
        const buttonValue = button.textContent;
        if (!action) {
            currentInput += buttonValue;
        } else if (action === 'decimal') {
            if (!currentInput.includes('.')) {
                currentInput += '.';
            }
        } else if (action === 'clear') {
            currentInput = '';
            prevInput = '';
            operator = null;
        } else if (action === 'add' || action === 'subtract' || action === 'multiply' || action === 'divide') {
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
                                alert("Error: Division by zero");
                                return;
                            }
                            result = prevNum / currentNum;
                            break;
                        default:
                            result = 0;
                    }

                    currentInput = result.toString();
                    prevInput = '';
                    operator = null;
                }
                else{
                    alert("enter next number");
                }
            }
        }
        display.textContent = currentInput;
    }

    const buttons = document.querySelectorAll('.calculator__keys button');
    buttons.forEach(button => {
        button.addEventListener('click', handleButtonClick);
    });
});