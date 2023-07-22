<?php
require_once "settings.php";
require_once "htmlFunctions.php";
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

        if ($_SESSION['account']['authority'] < 1) {
            header("Location:" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/". basename(getcwd()) . "/index.php");
        }

        ////////////  EMPLOYEES MYSQL querys
        /**/    //Create Employe
        /**/if (isset($_POST['createEmp']) && $_SESSION['account']['authority'] > 0 && cC($_POST['name']) && cC($_POST['surName']) && cC($_POST['BDate']) && cC($_POST['SIN']) && cC($_POST['workGroup']) && cC($_POST['homeAddress']) && cC($_POST['phoneNumber']) && cC($_POST['email']) && cC($_POST['SWDate']) && cC($_POST['DDate'])) {
        /**/$sINControl= $db->query("SELECT COUNT(socialIdentityNumber) FROM employees WHERE socialIdentityNumber = '".$_POST['SIN']."'")->fetch();
        /**/if ($sINControl[0] > 0) {
        /**/    CreateErrorMessage($lang['errorMessages']['sameSINError']);
        /**/}else{
        /**/    $values = "'".$_POST['name']."', '".$_POST['surName']."', '".$_POST['BDate']."', '".$_POST['SIN']."', '".$_POST['workGroup']."', '".$_POST['homeAddress']."', '".$_POST['phoneNumber']."', '".$_POST['email']."', '".$_POST['SWDate']."', '".$_POST['DDate']."'";
        /**/    $result = $db->exec("INSERT INTO employees (name, surname, birthDate, socialIdentityNumber, workGroup, homeAddress, phoneNumber, email, startWorkDate, dismissalDate) VALUES ($values)");
        /**/    if ($result) {
        /**/        SuccessMessage();
        /**/    }
        /**/    else{
        /**/        UnexpectedErrorMessage();
        /**/    }
        /**/}
        /**/}
        /**/ //  Edit Employee
        /**/if (isset($_POST['editEmp']) && cC($_POST['editEmp']) && $_SESSION['account']['authority'] > 0 && cC($_POST['name']) && cC($_POST['surName']) && cC($_POST['BDate']) && cC($_POST['SIN']) && cC($_POST['workGroup']) && cC($_POST['homeAddress']) && cC($_POST['phoneNumber']) && cC($_POST['email']) && cC($_POST['SWDate']) && cC($_POST['DDate'])) {
        /**/$sINControl= $db->query("SELECT COUNT(socialIdentityNumber) FROM employees WHERE socialIdentityNumber = '".$_POST['SIN']."' AND id != " . $_POST['editEmp'])->fetch();
        /**/if ($sINControl[0] > 0) {
        /**/    CreateErrorMessage($lang['errorMessages']['sameSINError']);
        /**/}else{
        /**/    $values = "name='".$_POST['name']."', surname='".$_POST['surName']."', birthDate='".$_POST['BDate']."', socialIdentityNumber='".$_POST['SIN']."', workGroup='".$_POST['workGroup']."', homeAddress='".$_POST['homeAddress']."', phoneNumber='".$_POST['phoneNumber']."', email='".$_POST['email']."', startWorkDate='".$_POST['SWDate']."', dismissalDate='".$_POST['DDate']."'";
        /**/    $result = $db->exec("UPDATE employees SET $values WHERE id=" . $_POST['editEmp']);
        /**/    if ($result) {
        /**/        SuccessMessage();
        /**/    }
        /**/    else{
        /**/        UnexpectedErrorMessage();
        /**/    }
        /**/}
        /**/}
        /**/  // Delete employee
        /**/if (isset($_POST['deleteEmp']) && cC($_POST['deleteEmp']) && $_SESSION['account']['authority'] > 0) {
        /**/    if($db->exec("DELETE FROM employees WHERE id=".$_POST['deleteEmp'])){
        /**/    SuccessMessage();
        /**/}else {
        /**/    UnexpectedErrorMessage();
        /**/}
        /**/}
        ////////////  EMPLOYEES MYSQL querys

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
        $positions = $db->query("SELECT * FROM positions")->fetchAll();

        if (isset($_SESSION['account'])) { // if user logged in
            if (isset($_POST['actions'])) {
                switch ($_POST['actions']) {
                    case 'employees':
                        ?>
                        <style>
                        body {
                            justify-content: flex-start !important;

                            flex-direction: column;
                        }
                        #inputHolder > div {
                            margin-left: 20px;
                        }
                    </style>
                    <?php
                    ReturnEmployeesFormHTML();?>
                        <div>
                            <span style="height: 68%;display: flex; justify-content: center; align-items:center;">
                                <button type="submit" name="createEmp" value="1" class="btn btn-light"><?=$lang['globals']['create']?></button> 
                            </span>
                        </div>
                    </div>
                </form>
                    <div style="width: 100%; display:flex; justify-content:center;">
                    <table id="wiroTable" style="width:80%;" class="table table-bordered table-striped table-dark">
                    <thead>
                        <tr style="text-align: center; text-transform: uppercase;">
                            <th><?=$lang['globals']['extras']?></th>
                            <th><?=$lang['globals']['name']?></th>
                            <th><?=$lang['globals']['surname']?></th>
                            <th><?=$lang['globals']['position']?></th>
                            <th><?=$lang['globals']['phoneNumber']?></th>
                            <th><?=$lang['globals']['workGroup']?></th>
                            <th><?=$lang['globals']['citizenId']?></th>
                            <th><?=$lang['globals']['email']?></th>
                            <th><?=$lang['globals']['homeAddress']?></th>
                            <th><?=$lang['globals']['birthDate']?></th>
                            <th><?=$lang['globals']['startWorkDate']?></th>
                            <th><?=$lang['globals']['dismissalDate']?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // List all employees
                            $employees = $db->query("SELECT * FROM employees WHERE dismissalDate = '0000-00-00'")->fetchAll();
                            foreach ($employees as $k) {
                                ?>
                                    <tr>
                                        <td>
                                            <form method="POST">
                                            <button type="submit" class="btn btn-light" name="actions" value="empEditScreen"><?=$lang['globals']['edit']?></button>
                                            <input type="hidden" name="id" value="<?=$k['id']?>">
                                            <button type="submit" class="btn btn-danger" name="deleteEmp" disabled value="<?=$k['id']?>"><?=$lang['globals']['delete']?></button>
                                            <span style="display: block;">
                                                <input type="checkbox" class="deleteConfirm form-check-input" id="deleteConfirm<?=$k['id']?>" >
                                                <label class="form-check-label deleteConfirm" for="deleteConfirm<?=$k['id']?>" style="user-select: none;" ><?=$lang['globals']['deleteConfirm']?></label>
                                            </span>
                                            </form>
                                        </td>
                                        <td><?=$k['name']?></td>
                                        <td><?=$k['surname']?></td>
                                        <td><?=indexToText($positions, $k['position'])?></td>
                                        <td><?=$k['phoneNumber']?></td>
                                        <td><?=$k['workGroup']?></td>
                                        <td><?=$k['socialIdentityNumber']?></td>
                                        <td><?=$k['email']?></td>
                                        <td><?=$k['homeAddress']?></td>
                                        <td><?=$k['birthDate']?></td>
                                        <td><?=$k['startWorkDate']?></td>
                                        <td><?=$k['dismissalDate']?></td>
                                    </tr>
                                <?php
                            }
                        ?>
                        </tbody>
                    </table>
                        <?php
                        break;
                    case 'empEditScreen':
                        $employe = $db->query("SELECT * FROM employees where id = ".$_POST['id'])->fetchAll()[0];
                        ?>
                        <style>
                        body {
                            justify-content: flex-start !important;
                            align-items: flex-start !important;
                            flex-direction: column;
                        }
                        #inputHolder > div {
                            margin-left: 20px;
                        }
                    </style>
                    <?php
                    ReturnEmployeesFormHTML();?>
                        <div>
                            <span style="display:flex; height: 67%; justify-content: center; align-items: center;">
                                <button type="submit" name="editEmp" value="<?=$_POST['id']?>" class="btn btn-light"><?=$lang['globals']['edit']?></button> 
                            </span>
                            <span style="display:flex; height: 27%; justify-content: center; align-items: center;">
                                <button type="submit" name="actions" value="employees" class="btn btn-danger"><?=$lang['globals']['cancel']?></button> 
                            </span>
                        </div>
                    </div>
                </form>
                <?php
                        break;
                    case 'allDebits':
                        //
                        break;
                    default:
                        # code...
                        break;
                }
            }else {
                ?>
                    
                    <form method="POST">
                        <?php if ($_SESSION['account']['authority'] > 0) {?>
                        <button class="btn btn-light" name="actions" value="employees"><?=$lang['menusAndButtons']['employees']?></button>
                        <button class="btn btn-light" name="actions" value="allDebits"><?=$lang['menusAndButtons']['allDebits']?></button>
                        <?php
                        }?>
                        <a class="btn btn-danger" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/". basename(getcwd()) . "/index.php"?>"><?=$lang['menusAndButtons']['mainMenu']?></a>
                    </form>
                <?php
            }}
        
        else {  // if user doesn't logged in
            header('Location: ' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/index.php");
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
    
    $('select').on('change', function() {
        if($(this).val() == "diger") {
            $(this).replaceWith('<input class="form-control" type="text" name="'+$(this).attr("name")+'">')
        }
    });

    $('.deleteConfirm').click(function() {
    if (!$(this).is(':checked')) {
        $(this).parent().prev().attr("disabled", true);
    }else{
        $(this).parent().prev().removeAttr("disabled");
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