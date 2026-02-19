    
    
//reset button for radio buttons
    function resetBtn() {
        const radios = document.querySelectorAll("input[type='radio']");
        radios.forEach(radio => {
            radio.checked = false
        });
    };

//collecting name of radio button 

    


     function getSize() {
         const sizeform = document.getElementById("size_form"); 
         const selectedradioinput = sizeform.querySelector("input[type='radio']:checked");    

         if (selectedradioinput) {
             const selectedClass = selectedradioinput.className;
             document.getElementById("selected_size").value = selectedClass;
         }
    };