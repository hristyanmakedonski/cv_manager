<?php 
/**
 * Description of upload
 *
 * Here we choose file and we make submit
 *
 * @author Hristiyan
 */
require_once './includes/header.php';?>
<a href="./index.php">Back</a>
<form action="./lib/UploadCv.php" method="post" enctype="multipart/form-data">
    Select file to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload File" name="submit">
</form>
<?php require_once './includes/footer.php';?>