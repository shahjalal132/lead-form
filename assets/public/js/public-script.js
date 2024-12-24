(function ($) {
  $(document).ready(function () {
    const toggleButton = document.getElementById("toggleInputButton");
    const phoneInputSection = document.getElementById("phoneInputSection");
    const emailInputSection = document.getElementById("emailInputSection");
    const continueToStep2Button = document.getElementById("continueToStep2");
    const continueToStep3Button = document.getElementById("continueToStep3");
    const continueToStep4Button = document.getElementById("continueToStep4");
    const submitButton = document.getElementById("submitForm");
    const step1 = document.getElementById("step1");
    const step2 = document.getElementById("step2");
    const step3 = document.getElementById("step3");
    const step4 = document.getElementById("step4");
    const thankYouPage = document.getElementById("thankYouPage");
    const registeredInfo = document.getElementById("registeredInfo");
    const pinInput = document.getElementById("pinInput");
    const dots = [
      document.getElementById("dot1"),
      document.getElementById("dot2"),
      document.getElementById("dot3"),
      document.getElementById("dot4"),
    ];

    toggleButton.addEventListener("click", () => {
      if (phoneInputSection.style.display === "none") {
        phoneInputSection.style.display = "block";
        emailInputSection.style.display = "none";
        toggleButton.textContent = "Use Email";
      } else {
        phoneInputSection.style.display = "none";
        emailInputSection.style.display = "block";
        toggleButton.textContent = "Use Phone";
      }
    });

    continueToStep2Button.addEventListener("click", () => {
      const phoneNumber = document.getElementById("mobileNumber").value;
      const email = document.getElementById("email").value;

      if (phoneInputSection.style.display !== "none" && phoneNumber) {
        registeredInfo.textContent = phoneNumber;
      } else if (emailInputSection.style.display !== "none" && email) {
        registeredInfo.textContent = email;
      } else {
        alert("Please enter a valid phone number or email.");
        return;
      }

      step1.style.display = "none";
      step2.style.display = "block";
    });

    continueToStep3Button.addEventListener("click", () => {
      step2.style.display = "none";
      step3.style.display = "block";
    });

    continueToStep4Button.addEventListener("click", () => {
      step3.style.display = "none";
      step4.style.display = "block";
    });

    submitButton.addEventListener("click", () => {
      step4.style.display = "none";
      thankYouPage.style.display = "block";
    });

    pinInput.addEventListener("input", () => {
      const pinValue = pinInput.value;
      dots.forEach((dot, index) => {
        dot.classList.toggle("active", index < pinValue.length);
      });
    });
  });
})(jQuery);
