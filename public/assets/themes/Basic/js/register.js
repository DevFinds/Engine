document.addEventListener("DOMContentLoaded", function() {
    const step1 = document.querySelector(".register-step-1");
    const step2 = document.querySelector(".register-step-2");
    const nextBtn = document.getElementById("nextBtn");
    const backBtn = document.getElementById("backBtn");
    const submitBtn = document.getElementById("submitBtn");
  
    nextBtn.addEventListener("click", function() {
      // Проверка на заполненность полей перед переходом
      if (validateStep(step1)) {
        step1.style.display = "none";
        step2.style.display = "flex";
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
      }
      return true;
    }
  });
