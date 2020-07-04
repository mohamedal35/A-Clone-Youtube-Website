<?php 
    class videoDetailsFormProvider {
        private $dbcon;

        public function __construct($dbcon) {
            $this->dbcon = $dbcon;
        }

        public function createUploadForm() {
            $fileInput          = $this->createFileInput();
            $titleInput         = $this->createTitleInput(NULL);
            $descriptionInput   = $this->createDescriptionInput(NULL);
            $privacyInputs      = $this->createPrivacyInputs(NULL);
            $categoryInputs     = $this->createCategoryInputs(NULL);
            $submitInput        = $this->createUploadButton();
            return "<form action='processing.php' enctype='multipart/form-data' method='POST'>
                        $fileInput
                        $titleInput
                        $descriptionInput
                        $privacyInputs
                        $categoryInputs
                        $submitInput
                    </form>";
        }
        public function createEditForm($video) {
            $titleInput         = $this->createTitleInput($video->getTitle());
            $descriptionInput   = $this->createDescriptionInput($video->getDesc());
            $privacyInputs      = $this->createPrivacyInputs($video->getPrivacy());
            $categoryInputs     = $this->createCategoryInputs($video->getCategory());
            $saveInput        = $this->createSaveButton();
            return "<form method='POST'>
                        $titleInput
                        $descriptionInput
                        $privacyInputs
                        $categoryInputs
                        $saveInput
                    </form>";
        }
        private function createFileInput() {
            return "<div class=\"form-group\">
                     <label for=\"exampleFormControlFile1\">Upload Your Video</label>
                     <input type=\"file\" class=\"form-control-file\" id=\"exampleFormControlFile1\" name='fileInput'>
                   </div>";
        }
        private function createTitleInput($videoData) {
            $videoData  = ($videoData == NULL) ? "" : $videoData;
            return "<div class='form-group'>
                        <input class=\"form-control\" type=\"text\" placeholder=\"Title...\" value='$videoData'  name='title'>
                    </div>";
        }
        private function createDescriptionInput($videoData) {
            $videoData  = ($videoData == NULL) ? "" : $videoData;
            return "<div class=\"form-group\">
                        <textarea class=\"form-control\" id=\"exampleFormControlTextarea1\"   rows=\"3\" placeholder='Description...' name='description'>$videoData</textarea>
                    </div>";
        }
        private function createPrivacyInputs($videoData) {
            $privateSelection   = ($videoData == 0) ? "selected" : "";
            $publicSelection   = ($videoData == 1) ? "selected" : "";
            return "<select class=\"custom-select my-1 mr-sm-2\" id=\"inlineFormCustomSelectPref\" name='privacyInput'>
                        <option  $privateSelection value=\"0\">Private</option>
                        <option  $publicSelection value=\"1\">Public</option>
                    </select>";
        }
        private function createCategoryInputs($videoData) {
            
            $stmt   = $this->dbcon->prepare("SELECT * FROM `categories`");
            $stmt->execute();
            $dataArr= $stmt->fetchAll();
            $options= "";
            foreach($dataArr as $value) {
                $selected   = ($videoData == $value['id']) ? "selected" : "";
                $options .= "<option $selected value='" . $value['id'] . "'>" . $value['name'] . "</option>";
            }
            return "<select class=\"custom-select my-1 mr-sm-2\" id=\"inlineFormCustomSelectPref\" name='categoryInput'>
                        $options
                    </select>";
        }
        private function createUploadButton() {
            return "<button type=\"submit\" class=\"btn btn-primary\" name='uploadButton' data-toggle=\"modal\" data-target=\"loadingSpin\">Upload</button>";
        }
        private function createSaveButton() {
            return "<button type=\"submit\" class=\"btn btn-primary\" name='saveBtn'>Save</button>";
        }
    }
?>