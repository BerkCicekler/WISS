<?php
require_once "settings.php";
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
        /*
        ███████╗███████╗██████╗ ██╗   ██╗███████╗██████╗ ███████╗██╗██████╗ ███████╗
        ██╔════╝██╔════╝██╔══██╗██║   ██║██╔════╝██╔══██╗██╔════╝██║██╔══██╗██╔════╝
        ███████╗█████╗  ██████╔╝██║   ██║█████╗  ██████╔╝███████╗██║██║  ██║█████╗  
        ╚════██║██╔══╝  ██╔══██╗╚██╗ ██╔╝██╔══╝  ██╔══██╗╚════██║██║██║  ██║██╔══╝  
        ███████║███████╗██║  ██║ ╚████╔╝ ███████╗██║  ██║███████║██║██████╔╝███████╗
        ╚══════╝╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚══════╝╚═╝  ╚═╝╚══════╝╚═╝╚═════╝ ╚══════╝
        */
        if (isset($_POST['login'])) {
            if (cC($_POST['username']) && cC($_POST['password'])) {
            $result = $db->query("SELECT * FROM accounts WHERE username='".$_POST['username']."' AND password='".$_POST['password']."'")->fetchAll();
            if (count($result) > 0) {
                $_SESSION['account'] = $result[0];
                header("Refresh:0"); // refresh page for load the client language
            }else {
                CreateErrorMessage($lang['errorMessages']['incorrectEntry']);
            }
            }
        }

        if (isset($_POST['exit'])) {  // log out
            session_destroy(); 
            header("Refresh:0");
        }

        ////////////  ACCOUNT MYSQL querys
        /**/    //Create Account
        /**/if (isset($_POST['createAcc']) && $_SESSION['account']['authority'] > 0 && cC($_POST['Cname']) && cC($_POST['Cpassword']) && cC($_POST['CuserName']) && cC(json_encode($_POST['Cpositions'])) && cC($_POST['Cauthority'])) {
        /**/$nameControl= $db->query("SELECT COUNT(name) FROM accounts WHERE name = '".$_POST['name']."'")->fetch();
        /**/$userNameControl= $db->query("SELECT COUNT(username) FROM accounts WHERE username = '".$_POST['userName']."'")->fetch();
        /**/if (($nameControl[0] + $userNameControl[0]) > 0) {
        /**/    CreateErrorMessage($lang['errorMessages']['sameAccountNameError']);
        /**/}else{
        /**/    $result = $db->exec("INSERT INTO accounts (username, password, name, position, authority) VALUES ('".$_POST['userName']."', '".$_POST['password']."', '".$_POST['name']."', '".json_encode($_POST['positions'])."', ".$_POST['authority'].")");
        /**/    if ($result) {
        /**/        SuccessMessage();
        /**/    }
        /**/    else{
        /**/        UnexpectedErrorMessage();
        /**/    }
        /**/}
        /**/}
        /**/ 
        /**/    // Account Update   $_POST['updateAcc'] is the id of the updating account
        /**/if (isset($_POST['updateAcc']) && cC($_POST['updateAcc']) && $_SESSION['account']['authority'] > 0 && cC($_POST['name' . $_POST['updateAcc']]) && cC($_POST['password' . $_POST['updateAcc']]) && cC($_POST['userName' . $_POST['updateAcc']]) && cC($_POST['authority' . $_POST['updateAcc']]) && !str_contains(json_encode($_POST[$_POST['updateAcc'] . 'positions']), "'")) {
        /**/$nameControl= $db->query("SELECT COUNT(name) FROM accounts WHERE name = '".$_POST['name' . $_POST['updateAcc']]."' AND id!=".$_POST['updateAcc']."")->fetch();
        /**/$userNameControl= $db->query("SELECT COUNT(username) FROM accounts WHERE username = '".$_POST['userName' . $_POST['updateAcc']]."' AND id!=".$_POST['updateAcc']."")->fetch();
        /**/if (($nameControl[0] + $userNameControl[0]) > 0) {
        /**/    CreateErrorMessage($lang['errorMessages']['sameAccountNameError']);
        /**/}else{
        /**/    $result = $db->exec("UPDATE accounts SET username='".$_POST['userName' . $_POST['updateAcc']]."', password='".$_POST['password' . $_POST['updateAcc']]."', name='".$_POST['name' . $_POST['updateAcc']]."', position='".json_encode($_POST[$_POST['updateAcc'] . 'positions'])."', authority=".$_POST['authority' . $_POST['updateAcc']]." WHERE id=".$_POST['updateAcc']."");
        /**/    if ($result) {
        /**/        SuccessMessage();
        /**/    }
        /**/    else{
        /**/        UnexpectedErrorMessage();
        /**/    }
        /**/}
        /**/}
        /**/
        /**/    // Delete Account
        /**/if(isset($_POST['deleteAcc']) && cC($_POST['deleteAcc']) && $_SESSION['account']['authority'] > 0){
        /**/    if($db->exec("DELETE FROM accounts WHERE id=".$_POST['deleteAcc'])){
        /**/    SuccessMessage();
        /**/}else {
        /**/    UnexpectedErrorMessage();
        /**/}
        /**/}
        //////////////////////////////  ACCOUNT MYSQL querys

        // My account edit query
        
        if (isset($_POST['editMyAccount']) && cC($_POST['editMyAccount']) && cC($_POST['userName']) && cC($_POST['password']) && cC($_POST['language'])) {
            $userNameControl= $db->query("SELECT COUNT(name) FROM accounts WHERE name='".$_POST['userName']."' AND id!=".$_POST['editMyAccount'])->fetch();
            if ($userNameControl > 0) {
                if ($db->exec("UPDATE accounts SET username='".$_POST['userName']."', password='".$_POST['password']."', selectedLanguage='".$_POST['language']."' WHERE id=".$_POST['editMyAccount'])) {
                    SuccessMessage();
                    header("Refresh:1");
                }else {
                    UnexpectedErrorMessage();
                }
            }else {
            CreateErrorMessage($lang['errorMessages']['sameAccountNameError']);
            }
        }

        /*
        ███████╗███████╗██████╗ ██╗   ██╗███████╗██████╗ ███████╗██╗██████╗ ███████╗
        ██╔════╝██╔════╝██╔══██╗██║   ██║██╔════╝██╔══██╗██╔════╝██║██╔══██╗██╔════╝
        ███████╗█████╗  ██████╔╝██║   ██║█████╗  ██████╔╝███████╗██║██║  ██║█████╗  
        ╚════██║██╔══╝  ██╔══██╗╚██╗ ██╔╝██╔══╝  ██╔══██╗╚════██║██║██║  ██║██╔══╝  
        ███████║███████╗██║  ██║ ╚████╔╝ ███████╗██║  ██║███████║██║██████╔╝███████╗
        ╚══════╝╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚══════╝╚═╝  ╚═╝╚══════╝╚═╝╚═════╝ ╚══════╝
        */

        //

        /*
         ██████╗██╗     ██╗███████╗███╗   ██╗████████╗███████╗██╗██████╗ ███████╗
        ██╔════╝██║     ██║██╔════╝████╗  ██║╚══██╔══╝██╔════╝██║██╔══██╗██╔════╝
        ██║     ██║     ██║█████╗  ██╔██╗ ██║   ██║   ███████╗██║██║  ██║█████╗  
        ██║     ██║     ██║██╔══╝  ██║╚██╗██║   ██║   ╚════██║██║██║  ██║██╔══╝  
        ╚██████╗███████╗██║███████╗██║ ╚████║   ██║   ███████║██║██████╔╝███████╗
        ╚═════╝╚══════╝╚═╝╚══════╝╚═╝  ╚═══╝   ╚═╝   ╚══════╝╚═╝╚═════╝ ╚══════╝
        */

        if (isset($_SESSION['account'])) { // if user logged in
            if (isset($_POST['actions'])) {
                switch ($_POST['actions']) {
                    case 'accounts':
                        if ($_SESSION['account']['authority'] > 0) {
                            ?>
                            <form method="POST">
                            <table class="table table-bordered table-striped table-dark" style="width: 100%; margin-top: 3%; margin-bottom: 3%;">
                                <thead>
                                    <tr>
                                        <th><?php echo $lang['globals']['userName'];?></th>
                                        <th><?php echo $lang['globals']['password'];?></th>
                                        <th><?php echo $lang['globals']['name'];?></th>
                                        <th><?php echo $lang['globals']['position']?></th>
                                        <th><?php echo $lang['globals']['authority']?></th>
                                        <th><?php echo $lang['globals']['edit']?></th>
                                    </tr>
                                </thead>
                            <tbody>
                            <?php
                            $accounts = $db->query("SELECT * FROM accounts")->fetchAll();
                            foreach ($accounts as $k) {?>
                                    <tr>
                                        <td><input class="form-control"  type="text" name="userName<?=$k['id']?>" value="<?=$k['username']?>" required></td>
                                        <td><input class="form-control"  type="text" name="password<?=$k['id']?>" value="<?=$k['password']?>" required></td>
                                        <td><input class="form-control"  type="text" name="name<?=$k['id']?>" value="<?=$k['name']?>" required></td>
                                        <td><select name="<?=$k['id']?>positions[]" class="form-select" multiple required>
                                    <?php
                                $positions = $db->query("SELECT * FROM positions")->fetchAll();
                                foreach ($positions as $p) {
                                    if (in_array($p['id'], json_decode($k['position']))) {
                                    echo '<option selected value="'.$p['id'].'">'.$p['value'].'</option>';
                                    }else {
                                    echo '<option value="'.$p['id'].'">'.$p['value'].'</option>';
                                    }
                                }
                                ?>
                                </select></td>
                                <td><input class="form-control"  type="number" min="0" max="2" name="authority<?=$k['id']?>" value="<?=$k['authority']?>"></td>
                                <td><button class="btn btn-light" name="updateAcc" value="<?=$k['id']?>"><?=$lang['globals']['update']?></button> 
                                <button disabled class="btn btn-danger" name="deleteAcc" value="<?=$k['id']?>"><?=$lang['globals']['delete']?></button> 
                                <span style="display: flex;"><input type="checkbox" class="deleteConfirm form-check-input" id="deleteConfirm<?=$k['id']?>" >
                                <label class="form-check-label deleteConfirm" for="deleteConfirm<?=$k['id']?>" style="user-select: none; margin-left: 5px;" ><?=$lang['globals']['deleteConfirm']?></label>
                            </span></td></tr>
                            <?php } ?>
                            <tr>
                            <td><input class="form-control" type="text" name="CuserName"></td>
                            <td><input class="form-control" type="text" name="Cpassword"></td>
                            <td><input class="form-control" type="text" name="Cname"></td>
                            <td><select class="form-select" multiple name="Cpositions[]">
                                <?php
                            foreach ($positions as $p) {
                                echo '<option value="'.$p['id'].'">'.$p['value'].'</option>';
                            }
                            ?></select></td>
                            <td><input class="form-control" type="number" name="Cauthority" max="2" min="0" value="0"></td>
                            <td><button class="btn btn-light" name="createAcc" value="1"><?=$lang['globals']['create']?></button></td>
                            </tr></tbody></table></form>
                            <?php
                        }
                        break;
                    case 'others':
                        ?>
                        <form method="POST">
                            <?php
                            if ($_SESSION['account']['authority'] > 0) {?>
                            <button class="btn btn-light" name="actions" value="settings"><?=$lang['menusAndButtons']['mainSettings']?></button>
                            <?php
                            }?>
                            <a class="btn btn-light" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/employees.php"?>"><?=$lang['menusAndButtons']['employees']?></a> 
                            <a class="btn btn-light" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/fieldEquipments.php"?>"><?=$lang['menusAndButtons']['fieldEquipments']?></a> 
                            <?php
                            if ($_SESSION['account']['authority'] > 0) {?>
                            <button class="btn btn-light" name="actions" value="accounts"><?=$lang['menusAndButtons']['accounts']?></button> 
                            <?php
                            }?>
                            <button class="btn btn-light" name="actions" value="myAccount"><?=$lang['menusAndButtons']['myAccount']?></button>
                        </form>
                        <?php
                        break;
                    case 'myAccount':
                        ?>
                    <table class="table table-bordered table-striped table-dark" style="width: 50%; margin-top: 3%; margin-bottom: 3%;">
                        <thead>
                            <tr>
                                <th><?=$lang['globals']['userName']?></th>
                                <th><?=$lang['globals']['password']?></th>
                                <th><?=$lang['globals']['language']?></th>
                                <th><?=$lang['globals']['extras']?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <form method="POST">
                            <tr>
                                <td><input class="form-control" type="text" name="userName" value="<?=$_SESSION['account']['username']?>" required></td>
                                <td><input class="form-control" type="text" name="password" value="<?=$_SESSION['account']['password']?>" required></td>
                                <td>
                                    <select class="form-select" required name="language">
                                        <?php
                                            foreach ($langKeys as $key => $value) { // $langKeys is coming from setting.php its an arroy who storage the language names
                                                if ($value == $_SESSION['account']['selectedLanguage']) {
                                                    echo'<option selected value="'.$value.'">'.$value.'</option>';
                                                }else {
                                                    echo'<option value="'.$value.'">'.$value.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </td>
                                <td><button class="btn btn-light" name="editMyAccount" value="<?=$_SESSION['account']['id']?>"><?=$lang['globals']['save']?></button></td>
                            </tr>
                            </form>
                        </tbody>
                    </table>
                        <?php
                        break;
                    case 'settings':
                        ?>
                        <form method="POST">
                            <?php
                            if ($_SESSION['account']['authority'] > 0) {?>
                            <a class="btn btn-light" style="margin-left: 5px;" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/globalEditPage.php?langTable=globals&table=positions&valueName=position"?>" ><?=$lang['globals']['position']?></a> 
                            <?php
                            }?>
                        </form>
                        <?php
                        break;
                        break;
                    case 'logout':
                        session_destroy();
                        header("Refresh:0");
                        break;
                    default:
                        # code...
                        break;
                }
            }else {
                ?>
                    <form method="POST">
                        <a class="btn btn-light" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/computers.php"?>"><?=$lang['menusAndButtons']['computers']?></a>
                        <a class="btn btn-light" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/cellPhones.php"?>"><?=$lang['menusAndButtons']['cellPhones']?></a>
                        <a class="btn btn-light" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/networkDevices.php"?>"><?=$lang['menusAndButtons']['networks']?></a>
                        <button class="btn btn-light" name="actions" value="others"><?=$lang['globals']['other']?></button>
                        <button class="btn btn-danger" name="actions" value="logout"><?=$lang['menusAndButtons']['logout']?></button>
                    </form>
                <?php
            }
        }
        else {  // if user doesn't logged in
            ?>
            <form method="POST" style="display: flex; justify-content: center; flex-direction: column;">
            <img src="img/wiro.png" style="margin-bottom: 30px;">
            <h4 style="text-align:center;"><?php echo $lang['webAppName']; ?></h4>
            <h5><?php echo $lang['globals']['userName']; ?></h5 style="margin-bottom: 10px;">
            <input type="text" class="form-control" style="height: 30px;" name="username" required>
            <h5><?php echo $lang['globals']['password']; ?></h5 style="margin-bottom: 10px;">
            <input type="password" class="form-control" style="height: 30px; margin-bottom: 10px;" name="password" required>
            <button type="submit" class="btn btn-light" name="login" value="a"><?php echo $lang['globals']['loginBtn']; ?></button>
            </form>
            <?php
        }
        /*
         ██████╗██╗     ██╗███████╗███╗   ██╗████████╗███████╗██╗██████╗ ███████╗
        ██╔════╝██║     ██║██╔════╝████╗  ██║╚══██╔══╝██╔════╝██║██╔══██╗██╔════╝
        ██║     ██║     ██║█████╗  ██╔██╗ ██║   ██║   ███████╗██║██║  ██║█████╗  
        ██║     ██║     ██║██╔══╝  ██║╚██╗██║   ██║   ╚════██║██║██║  ██║██╔══╝  
        ╚██████╗███████╗██║███████╗██║ ╚████║   ██║   ███████║██║██████╔╝███████╗
        ╚═════╝╚══════╝╚═╝╚══════╝╚═╝  ╚═══╝   ╚═╝   ╚══════╝╚═╝╚═════╝ ╚══════╝
        */
    ?>
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
  $('.trhChk').click(function() {
    if (!$(this).is(':checked')) {
        $("input[name=tarih]").removeAttr("disabled")
    }else{
        $("input[name=tarih]").attr("disabled", true)
    }
    });
    $('#excel').click(function() {
        var table2excel = new Table2Excel();
        table2excel.export(document.getElementById("wiroTable"), "Rapor");
    });
    var TRange=null;
} );
</script>
</html>