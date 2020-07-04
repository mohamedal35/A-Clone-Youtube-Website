<?php 
    require_once("includes/tpl/header.php");
    require_once("includes/classes/videoDetailsFormProvider.php");
?>
                <div class='column'>
                    <?php 
                        $formProvider = new videoDetailsFormProvider($dbcon);
                        echo $formProvider->createUploadForm();
                    ?>
                </div>
                <script>
                    $("form").submit(() => {
                        $("#loadingSpin").modal("show");
                    });
                </script>
                <!-- Modal -->
                <div class="modal fade" id="loadingSpin" tabindex="-1" role="dialog" aria-labelledby="loadingSpin" aria-hidden="true" data-backdrop='static' data-keyboard="false">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-body">
                        <img src="assets/images/icons/loadingSpinner.gif" alt="">
                    </div>
                    </div>
                </div>
                </div>

