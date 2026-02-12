    
    
//reset button for radio buttons
    function resetBtn() {
        const radios = document.querySelectorAll("input[type='radio']");
        radios.forEach(radio => {
            radio.checked = false
        });
    };