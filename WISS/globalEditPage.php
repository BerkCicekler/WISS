<?php
require_once "settings.php";
// MUST GO FASTER
// This page is for make user can edit selectable variables
// If you ask why there is a page for this | Its for make website faster

$whiteListedTables = array(
    "computerAntiVirus",
    "computerBrands",
    "computerKinds",
    "computerOfficePrograms",
    "computerOS",
    "computerRAM",
    "cellphonebrands",
    "networkDKinds",
    "networkDBrands",
    "fieldEquipmentTypes",
    "positions"
);

if ($_SESSION['account']['authority'] < 1) {
    header("Location:" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/". basename(getcwd()) . "/index.php");
}

if ($_SESSION['account']['authority'] > 0 && isset($_POST['edit']) && cC($_POST['table']) && cC($_POST['text'])) {
    // update
    if($db->exec("UPDATE " . $_POST['table'] . " SET value='" . $_POST['text'] . "' WHERE id=" . $_POST['id'])){
        SuccessMessage();
    }
    else{
        UnexpectedErrorMessage();
    }
}

if($_SESSION['account']['authority'] > 0 && isset($_POST['create']) && cC($_POST['text']) && cC($_POST['table']) && cC($_POST['variableName'])){
    if ($db->exec("INSERT INTO " . $_POST['table'] . " (value) VALUES('".$_POST['text']."')") ) {
        SuccessMessage();
    }else {
        UnexpectedErrorMessage();
    }
}

if($_SESSION['account']['authority'] > 0 && isset($_POST['delete']) ){
    if ($db->exec("DELETE FROM " . $_POST['table'] . " WHERE id=" . $_POST['id']) ) {
        SuccessMessage();
    }else {
        UnexpectedErrorMessage();
    }
}


?>
<!DOCTYPE html>
<html lang="<?=$cLang?>">
<head>
    <meta charset="utf-8">
    <script type="text/javascript" src="frameworks/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" media="all" type="text/css" href="style/bootstrap.min.css">
    <link rel="stylesheet" media="all" type="text/css" href="style/style.css">
    <script src="frameworks/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
</head>
<body>
    <?php 
    mainMenuBtn();
if (in_array($_GET['table'], $whiteListedTables)) {
?>
<table class="table table-bordered table-striped table-dark" style="width: 70%; margin-top: 3%; margin-bottom: 3%;">
        <thead>
            <tr>
                <th><?=$lang[$_GET['langTable']][$_GET['valueName']]?></th>
                <th><?=$lang['globals']['extras']?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $array = $db->query("SELECT * FROM " . $_GET['table'])->fetchAll();
                foreach ($array as $k) {
                    ?>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?=$k['id']?>">
                        <input type="hidden" name="table" value="<?=$_GET['table']?>">
                        <tr>
                            <td>
                                <input type="text" name="text" value="<?=$k['value']?>" class="form-control" required>
                            </td>
                            <td>
                            <button type="submit" class="btn btn-light" name="edit" value="1"><?=$lang['globals']['edit']?></button>
                            <button type="submit" class="btn btn-danger" name="delete" disabled value="1"><?=$lang['globals']['delete']?></button>
                                <span style="display: block;">
                                    <input type="checkbox" class="deleteConfirm form-check-input" id="deleteConfirm<?=$k['id']?>" >
                                    <label class="form-check-label deleteConfirm" for="deleteConfirm<?=$k['id']?>" style="user-select: none;" ><?=$lang['globals']['deleteConfirm']?></label>
                                </span>
                            </td>
                        </tr>
                    </form>
                    <?php
                }
                ?>
                    <form method="POST">
                        <input type="hidden" name="table" value="<?=$_GET['table']?>">
                        <tr>
                            <td>
                                <input type="text" name="text" class="form-control" required>
                            </td>
                            <td>
                            <button type="submit" class="btn btn-light" name="create" value="1"><?=$lang['globals']['create']?></button>
                            </td>
                        </tr>
                    </form>
                <?php
            }
                else {  // probly hacker
                    Error2FuckingHacker();
                }
            ?>
        </tbody>
    </table>
</body>
<script>
$(document).ready(function() {
	
    if ( window.history.replaceState ) { // Yeniden form gönderme işlemini kapatır
        window.history.replaceState( null, null, window.location.href );
    }

    $('.deleteConfirm').click(function() {
    if (!$(this).is(':checked')) {
        $(this).parent().prev().attr("disabled", true);
    }else{
        $(this).parent().prev().removeAttr("disabled");
    }
  });
} );
</script>
</html>