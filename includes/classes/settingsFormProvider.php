<?php 
class settingsFormProvider {

    public function createUserDetailsForm($firstName, $lastName, $email) {
        $firstNameInput         = $this->createFirstNameInput($firstName);
        $lastNameInput          = $this->createLastNameInput($lastName);
        $emailInput             = $this->createEmailInput($email);
        $saveBtn                = $this->createSaveDetailsBtn();
        return "<form action='" . $_SERVER['PHP_SELF'] . "' enctype='multipart/form-data' method='POST'>
                    <span class='title'>User Details</span>
                    $firstNameInput
                    $lastNameInput
                    $emailInput
                    $saveBtn

                </form>";
    }
    public function createPasswordForm() {
        $oldPasswordInput         = $this->createPasswordInput("Old Password…", "oldPassword");
        $newPasswordInput         = $this->createPasswordInput("New Password…", "newPassword");
        $confirmPasswordInput     = $this->createPasswordInput("Confrim Password…", "confirmPassword");
        $saveBtn                = $this->createSavePasswordBtn();
        return "<form action='" . $_SERVER['PHP_SELF'] . "' enctype='multipart/form-data' method='POST'>
                    <span class='title'>Update Password</span>
                        $oldPasswordInput
                        $newPasswordInput
                        $confirmPasswordInput
                        $saveBtn
                </form>";
    }
    private function createPasswordInput($placeHolder, $name) {
        return "<div class='form-group'>
                    <input class=\"form-control\" type=\"password\" placeholder=\"$placeHolder\" name='$name' required>
                </div>";
    }
    private function createFirstNameInput($value) {
        if ($value == NULL) $value = "";
        return "<div class='form-group'>
                    <input class=\"form-control\" type=\"text\" placeholder=\"FirstName...\" value='$value' name='firstName' required>
                </div>";
    }
    private function createLastNameInput($value) {
        if ($value == NULL) $value = "";
        return "<div class='form-group'>
                    <input class=\"form-control\" type=\"text\" placeholder=\"lastName...\" value='$value' name='lastName' required>
                </div>";
    }
    private function createEmailInput($value) {
        if ($value == NULL) $value = "";
        return "<div class='form-group'>
                    <input class=\"form-control\" type=\"email\" placeholder=\"Email...\" value='$value' name='email' required>
                </div>";
    }
    private function createSaveDetailsBtn() {
        return "<button type=\"submit\" class=\"btn btn-primary\" name='saveDetailsBtn'>Save</button>";
    }
    private function createSavePasswordBtn() {
        return "<button type=\"submit\" class=\"btn btn-primary\" name='savePasswordBtn'>Save</button>";
    }
}
?>