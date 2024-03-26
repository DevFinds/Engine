document.addEventListener("DOMContentLoaded", function() {
    const step1 = document.querySelector(".register-step-1");
    const step2 = document.querySelector(".register-step-2");
    const nextBtn = document.getElementById("nextBtn");
    const backBtn = document.getElementById("backBtn");
    const submitBtn = document.getElementById("submitBtn");
  
    nextBtn.addEventListener("click", function() {
      // Проверка на заполненность полей перед переходом
      if (validateStep(step1) && document.getElementById("privacy-policy").checked) {
        step1.style.display = "none";
        step2.style.display = "flex";
      }
      
      if(!document.getElementById("privacy-policy").checked){
        highlight_warning("privacy-policy");
      }
    });
  
    backBtn.addEventListener("click", function() {
      step2.style.display = "none";
      step1.style.display = "flex";
    });
  
    submitBtn.addEventListener("click", function(event) {
      // Проверка на заполненность полей перед отправкой формы
      if (!validateStep(step2)) {
        event.preventDefault(); // Прекратить стандартное действие
        alert("Please fill in all fields.");
      }
    });
  
    function validateStep(step) {
      const inputs = step.querySelectorAll("input");
      for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value.trim() === "") {
          return false;
        }
        else if (inputs[i].id === "privacy-policy" && !inputs[i].checked) {
          highlight_warning("privacy-policy");
          return false;
        }
      }
      return true;
    }
  });

  //Hightlight warning

  function highlight_warning(field_id) {
    const field = document.getElementById(field_id);
    field.classList.add("warning-input");
  }

  // Highlight error
  function highlight_error(field_id) {
    const field = document.getElementById(field_id);
    field.classList.add("error-input");
    // sleep 2 seconds
    setTimeout(function() {
      field.classList.remove("warning-input");
    } , 2);
  }