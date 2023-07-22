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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/datatables.min.css"/>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/datatables.min.js"></script>
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

        ////////////  NETWORK DEVICES MYSQL querys
        /**/    //Create NETWORK DEVICES
        /**/if (isset($_POST['createNetworkDevice']) && $_SESSION['account']['authority'] > 0 && cC($_POST['brand']) && cC($_POST['kind']) && cC($_POST['model']) && cC($_POST['serialNumber']) && cC($_POST['PDate'])) {
        /**/$IMEIControl = $db->query("SELECT COUNT(serialNumber) FROM networkDevices WHERE serialNumber='".$_POST['serialNumber']."'")->fetch();
        /**/if ($IMEIControl[0] > 0) {
        /**/    CreateErrorMessage($lang['errorMessages']['sameSerialError']);
        /**/}else{
        /**/    $values = "'".$_POST['kind']."', '".$_POST['brand']."', '".$_POST['model']."', '".$_POST['serialNumber']."', '".$_POST['PDate']."'";
        /**/    $result = $db->exec("INSERT INTO networkDevices (kind, brand, model, serialNumber, purchaseDate) VALUES ($values)");
        /**/    if ($result) {
        /**/        SuccessMessage();
        /**/    }
        /**/    else{
        /**/        UnexpectedErrorMessage();
        /**/    }
        /**/}
        /**/}
        /**/ //  Edit NETWORK DEVICES
        /**/if (isset($_POST['editNetworkDevice']) && $_SESSION['account']['authority'] > 0 && cC($_POST['brand']) && cC($_POST['kind']) && cC($_POST['model']) && cC($_POST['serialNumber']) && cC($_POST['PDate'])) {
        /**/$IMEIControl= $db->query("SELECT COUNT(serialNumber) FROM networkDevices WHERE serialNumber='".$_POST['serialNumber']."' AND id !=". $_POST['editNetworkDevice'])->fetch();
        /**/if ($IMEIControl[0] > 0) {
        /**/    CreateErrorMessage($lang['errorMessages']['sameSerialError']);
        /**/}else{
        /**/    $values = "kind = '" . $_POST['kind'] . "', brand = '" . $_POST['brand'] . "', model = '" . $_POST['model'] . "', serialNumber = '" . $_POST['serialNumber'] . "', purchaseDate = '" . $_POST['PDate'] . "'";
        /**/    $result = $db->exec("UPDATE networkDevices SET $values WHERE id=" . $_POST['editNetworkDevice']);
        /**/    if ($result) {
        /**/        SuccessMessage();
        /**/    }
        /**/    else{
        /**/        UnexpectedErrorMessage();
        /**/    }
        /**/}
        /**/}
        /**/  // Delete NETWORK DEVICES
        /**/if (isset($_POST['deleteNetworkDevice']) && cC($_POST['deleteNetworkDevice']) && $_SESSION['account']['authority'] > 0) {
        /**/    if($db->exec("UPDATE networkDevices SET isTrash=1 WHERE id=".$_POST['deleteNetworkDevice'])){
        /**/    SuccessMessage();
        /**/}else {
        /**/    UnexpectedErrorMessage();
        /**/}
        /**/}
        /**/if (isset($_POST['bringBackNetworkDevice']) && cC($_POST['bringBackNetworkDevice']) && $_SESSION['account']['authority'] > 0) {
        /**/    if($db->exec("UPDATE networkDevices SET isTrash=0 WHERE id=".$_POST['bringBackNetworkDevice'])){
        /**/    SuccessMessage();
        /**/}else {
        /**/    UnexpectedErrorMessage();
        /**/}
        /**/}
        ////////////  NETWORK DEVICES MYSQL querys

        if (isset($_POST['createDebit']) && $_SESSION['account']['authority'] > 0 && cC($_POST['position']) && cC($_POST['name']) && cC($_POST['network']) && cC($_POST['DED']) && cC($_POST['DSD'])) {
                $fullName = explode(' ',trim($_POST['name']));
                $employee = $db->query("SELECT * FROM employees WHERE position ='" . $_POST['position'] . "' AND name = '". $fullName[0] . "' AND surname = '". $fullName[1] . "'")->fetchAll();
                if (!$employee) {
                    UnexpectedErrorMessage();
                }else {
                    if ($db->query("SELECT COUNT(id) FROM networkDeviceDebits WHERE debitEndDate IS NULL OR debitEndDate='0000-00-00' AND networkDeviceId=" . $_POST['network'])->fetch()[0] < 1 && count($employee) > 0) {
                        $values = "'".$_POST['network']."', '".$employee[0]['id']."', '".$_POST['DSD']."', '".$_POST['DED']."'";
                        if ($db->exec("INSERT INTO networkDeviceDebits (networkDeviceId, employeeId, debitStartDate, debitEndDate) VALUES ($values)")) {
                            SuccessMessage();
                        }else {
                            UnexpectedErrorMessage();
                        }
                    }else {
                        CreateErrorMessage($lang['errorMessages']['sameNetwork2Debits']);
                    }
                }
        }

        if (isset($_POST['editDebit']) && cC($_POST['editDebit']) && $_SESSION['account']['authority'] > 0 && cC($_POST['position']) && cC($_POST['name']) && cC($_POST['network']) && cC($_POST['DED']) && cC($_POST['DSD'])) {
            $fullName = explode(' ',trim($_POST['name']));
            $employee = $db->query("SELECT * FROM employees WHERE position ='" . $_POST['position'] . "' AND name = '". $fullName[0] . "' AND surname = '". $fullName[1] . "'")->fetchAll();
            if (!$employee) {
                UnexpectedErrorMessage();
            }
            
            $values = "networkDeviceId = '".$_POST['network']."', employeeId = '".$employee[0]['id']."', debitStartDate = '".$_POST['DSD']."', debitEndDate = '".$_POST['DED']."'";
            if ($db->query("SELECT COUNT(id) FROM networkDeviceDebits WHERE debitEndDate IS NULL OR debitEndDate='0000-00-00' AND id != " . $_POST['editDebit'] ." AND networkDeviceId = " . $_POST['network'])->fetch()[0] < 1) {
                if ($db->exec("UPDATE networkDeviceDebits SET " . $values . " WHERE id = " . $_POST['editDebit'])) {
                    SuccessMessage();
                }else {
                    UnexpectedErrorMessage();
                }
            }else {
                CreateErrorMessage($lang['errorMessages']['sameComputer2Debits']);
            }
        }

        if (isset($_POST['deleteDebit']) && cC($_POST['deleteDebit'])) {
            if ($db->exec("DELETE FROM networkDeviceDebits WHERE id=".$_POST['deleteDebit'])) {
                SuccessMessage();
            }else {
                UnexpectedErrorMessage();
            }
        }

        $kinds = $db->query("SELECT * FROM networkDKinds")->fetchAll();
        $brands = $db->query("SELECT * FROM networkDKinds")->fetchAll();

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
                    case 'networkDevices':
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
                    if ($_SESSION['account']['authority'] > 0) {
                        ReturnNetworkDeviceFormHTML();
                    ?>
                        <div>
                            <span style="height: 68%;display: flex; justify-content: center; align-items:center;">
                                <button type="submit" name="createNetworkDevice" value="1" class="btn btn-light"><?=$lang['globals']['create']?></button> 
                            </span>
                        </div>
                    </div>
                </form>
                <?php
                    }?>
                <!-- form end -->
                    <div style="width: 100%; display:flex; justify-content:center;">
                    <table id="reportTable" style="width:80%;" class="table table-bordered table-striped table-dark">
                    <thead>
                        <tr style="text-align: center; text-transform: uppercase;">
                        <?php
                            if ($_SESSION['account']['authority'] > 0) {?>
                            <th><?=$lang['globals']['extras']?></th>
                            <?php
                            }?>
                            <th><?=$lang['globals']['id']?></th>
                            <th><?=$lang['globals']['debitStatus']?></th>
                            <th><?=$lang['globals']['kind']?></th>
                            <th><?=$lang['globals']['brand']?></th>
                            <th><?=$lang['globals']['model']?></th>
                            <th><?=$lang['globals']['serialN']?></th>
                            <th><?=$lang['globals']['purchaseDate']?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // List all network Devices
                            $networkDevices = $db->query("SELECT * FROM networkDevices WHERE isTrash=0")->fetchAll();
                            foreach ($networkDevices as $k) {
                                ?>
                                    <tr>
                                    <?php
                                        if ($_SESSION['account']['authority'] > 0) {?>
                                        <td>
                                            <form method="POST">
                                            <button type="submit" class="btn btn-light" name="actions" value="networkDevicesEditScreen"><?=$lang['globals']['edit']?></button>
                                            <input type="hidden" name="id" value="<?=$k['id']?>">
                                            <button type="submit" class="btn btn-danger" name="deleteNetworkDevice" disabled value="<?=$k['id']?>"><?=$lang['globals']['delete']?></button>
                                            <span style="display: block;">
                                                <input type="checkbox" class="deleteConfirm form-check-input" id="deleteConfirm<?=$k['id']?>" >
                                                <label class="form-check-label deleteConfirm" for="deleteConfirm<?=$k['id']?>" style="user-select: none;" ><?=$lang['globals']['deleteConfirm']?></label>
                                            </span>
                                            </form>
                                        </td>
                                        <?php
                                        }?>
                                        <td><?=$k['id']?></td>
                                        <?php
                                            if ($db->query("SELECT COUNT(id) FROM networkdevicedebits WHERE networkdeviceId=" . $k['id'])->fetch()[0] >= 0) {
                                                if ($db->query("SELECT COUNT(id) FROM networkdevicedebits WHERE networkdeviceId=" . $k['id'] . " AND debitEndDate IS NULL OR networkdeviceId=" . $k['id'] . " AND debitEndDate='0000-00-00'")->fetch()[0] > 0) {
                                                    echo "<td>".$lang['globals']['inDebit']. "</td>";
                                                }else {
                                                    echo "<td>".$lang['globals']['notDebit'];
                                                    ?>
                                                    <form method="POST"><input type="hidden" name="actions" value="debits"><button type="submit" class="btn btn-light" name="cId" value="<?=$k['id']?>"><?=$lang['globals']['debitIt']?></button></form></td>
                                                    <?php
                                                }
                                                
                                            }
                                        ?>
                                        <td><?=indexToText($kinds, $k['kind'])?></td>
                                        <td><?=indexToText($brands, $k['brand'])?></td>
                                        <td><?=$k['model']?></td>
                                        <td><?=$k['serialNumber']?></td>
                                        <td><?=$k['purchaseDate']?></td>
                                    </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                    </table>
                        <?php
                        break;
                    case 'networkDevicesEditScreen':
                        if (cC($_POST['id']) && $_SESSION['account']['authority'] > 0) {
                            $networkDevice = $db->query("SELECT * FROM networkDevices WHERE id=" . $_POST['id'])->fetchAll()[0];
                        ?>
                        <style>
                        body {
                            justify-content: flex-start !important;

                            flex-direction: column;
                        }
                        #inputHolder > div {
                            margin-left: 20px;
                        }
                        </style><?php
                        ReturnNetworkDeviceFormHTML();
                        ?>
                                <div>
                                    <span style="display:flex; height: 72%; justify-content: center; align-items: center;">
                                        <button type="submit" name="editNetworkDevice" value="<?=$_POST['id']?>" class="btn btn-light"><?=$lang['globals']['edit']?></button> 
                                    </span>
                                    <span style="display:flex; height: 27%; justify-content: center; align-items: center;">
                                        <button type="submit" name="actions" value="networkDevices" class="btn btn-danger"><?=$lang['globals']['cancel']?></button> 
                                    </span>
                                </div>
                            </div>
                        </form>
                        <script>
                                $("input[name=model]").val("<?=$networkDevice['model']?>");
                                $("input[name=serialNumber]").val("<?=$networkDevice['serialNumber']?>");
                                $("input[name=PDate]").val("<?=$networkDevice['purchaseDate']?>");
                                $("select[name=kind]").val("<?=$networkDevice['kind']?>");
                                $("select[name=brand]").val("<?=$networkDevice['brand']?>");
                        </script>
                        <?php
                        }
                    break;
                    case 'debits':
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
                    $positions = $db->query("SELECT * FROM positions")->fetchAll();
                    $employees = $db->query("SELECT * FROM employees")->fetchAll();
                    if ($_SESSION['account']['authority'] > 0) {
                    ReturnNetworkDeviceDebitFormHTML();
                    ?>
                    <div>
                    <span>
                        <button class="btn btn-light" name="createDebit" value="e" style="margin-top: 31px;"><?=$lang['globals']['save']?></button>
                    </span>
                </div>
                <?php
                    }?>
            </div>
            <!-- complates the debit form -->
                    <div style="width: 100%; display:flex; justify-content:center;">
                        <table id="reportTable" style="width:80%;" class="table table-bordered table-striped table-dark">
                        <thead>
                            <tr style="text-align: center; text-transform: uppercase;">
                                <th><?=$lang['globals']['extras']?></th>
                                <th><?=$lang['globals']['id']?></th>
                                <th><?=$lang['globals']['employee']?></th>
                                <th><?=$lang['menusAndButtons']['network']?></th>
                                <th><?=$lang['globals']['debitStartDate']?></th>
                                <th><?=$lang['globals']['debitEndDate']?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // List all computers
                                $debits = $db->query("SELECT * FROM networkDeviceDebits")->fetchAll();
                                $employees = $db->query("SELECT * FROM employees")->fetchAll();
                                $employee = NULL;
                                foreach ($debits as $k) {
                                    foreach ($employees as $d) {
                                        if ($d['id'] == $k['employeeId']) {
                                            $employee = $d['name'] . " " . $d['surname'];
                                            break;
                                        }
                                    }
                                    ?>
                                        <tr>
                                            <td>
                                            <form method="POST">
                                            <button type="submit" class="btn btn-light" name="actions" value="debitsEditScreen"><?=$lang['globals']['edit']?></button>
                                            <input type="hidden" name="id" value="<?=$k['id']?>">
                                            <button type="submit" class="btn btn-danger" name="deleteDebit" disabled value="<?=$k['id']?>"><?=$lang['globals']['delete']?></button>
                                            <span style="display: block;">
                                                <input type="checkbox" class="deleteConfirm form-check-input" id="deleteConfirm<?=$k['id']?>" >
                                                <label class="form-check-label deleteConfirm" for="deleteConfirm<?=$k['id']?>" style="user-select: none;" ><?=$lang['globals']['deleteConfirm']?></label>
                                            </span>
                                            </form>
                                            </td>
                                            <td><?=$k['id']?></td>
                                            <td><a target="_blank" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/bigInfo.php?employee=" . $k['employeeId'] . '&actions=employee"'?>"><?=$employee?></a></td>
                                            <td><?=$k['networkDeviceId']?></td>
                                            <td><?=$k['debitStartDate']?></td>
                                            <td><?=$k['debitEndDate']?></td>
                                        </tr>
                                    <?php
                                }
                                if (isset($_POST['cId'])) {
                                    echo '<script>$("input[name=network]").val("'.$_POST['cId'].'");</script>';
                                }
                            ?>
                        </tbody>
                        </table>
                    
                        <?php
                        break;
                        case 'debitsEditScreen':
                            if ($_SESSION['account']['authority'] > 0 && cC($_POST['id'])) {
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
                                $positions = $db->query("SELECT * FROM positions")->fetchAll();
                                $employees = $db->query("SELECT * FROM employees")->fetchAll();
                                ReturnNetworkDeviceDebitFormHTML();
                                $k = $db->query("SELECT * FROM networkDeviceDebits WHERE id = ". $_POST['id'])->fetchAll()[0];
                            }
                            ?>
                                <div>
                            <span>
                                <button class="btn btn-light" name="editDebit" value="<?=$k['id']?>" style="margin-top: 31px;"><?=$lang['globals']['edit']?></button>
                                </span>
                            </div>
                        </div>
                        <?php // get name by employee id
                        foreach ($employees as $d) {
                            if ($k['employeeId'] == $d['id']) {
                                $fullName = $d['name'] . " " . $d['surname'];
                                $position = $d['position'];
                            }
                        }
                        
                        ?>
                            <script>
                                    $("input[name=name]").val("<?=$fullName?>");
                                    $("input[name=network]").val("<?=$k['networkDeviceId']?>");
                                    $("select[name=position]").val("<?=$position?>");
                                    $("input[name=DSD]").val("<?=$k['debitStartDate']?>");
                                    $("input[name=DED]").val("<?=$k['debitEndDate']?>");                                
                            </script>
                            <?php
                        break;
                        case 'trash':
                            ?>
                    <div style="width: 100%; display:flex; justify-content:center;">
                    <table id="reportTable" style="width:80%;" class="table table-bordered table-striped table-dark">
                    <thead>
                        <tr style="text-align: center; text-transform: uppercase;">
                        <?php
                            if ($_SESSION['account']['authority'] > 0) {?>
                            <th><?=$lang['globals']['extras']?></th>
                            <?php
                            }?>
                            <th><?=$lang['globals']['id']?></th>
                            <th><?=$lang['globals']['kind']?></th>
                            <th><?=$lang['globals']['brand']?></th>
                            <th><?=$lang['globals']['model']?></th>
                            <th><?=$lang['globals']['serialN']?></th>
                            <th><?=$lang['globals']['purchaseDate']?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // List all phones
                            $cellPhones = $db->query("SELECT * FROM networkDevices WHERE isTrash=1")->fetchAll();
                            foreach ($cellPhones as $k) {
                                ?>
                                    <tr>
                                    <?php
                                        if ($_SESSION['account']['authority'] > 0) {?>
                                        <td>
                                            <form method="POST">
                                            <button type="submit" class="btn btn-light" name="bringBackNetworkDevice" value="<?=$k['id']?>"><?=$lang['globals']['bringBack']?></button>
                                            </form>
                                        </td>
                                        <?php
                                        }?>
                                        <td><?=$k['id']?></td>
                                        <td><?=indexToText($kinds, $k['kind'])?></td>
                                        <td><?=indexToText($brands, $k['brand'])?></td>
                                        <td><?=$k['model']?></td>
                                        <td><?=$k['serialNumber']?></td>
                                        <td><?=$k['purchaseDate']?></td>
                                    </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                    </table>
                            <?php
                            break;
                    case 'settings':
                        if ($_SESSION['account']['authority'] > 0) {
                            ?>
                            <a class="btn btn-light" style="margin-left: 5px;" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/globalEditPage.php?langTable=globals&table=networkDKinds&valueName=brand"?>" ><?=$lang['globals']['kind']?></a> 
                            <a class="btn btn-light" style="margin-left: 5px;" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/globalEditPage.php?langTable=globals&table=networkDBrands&valueName=kind"?>" ><?=$lang['globals']['brand']?></a> 
                            <?php
                            }
                        break;
                    default:
                        # code...
                        break;
                }
            }else {
                ?>
                    <form method="POST">
                        <button class="btn btn-light" name="actions" value="networkDevices"><?=$lang['menusAndButtons']['networks']?></button>
                        <button class="btn btn-light" name="actions" value="debits"><?=$lang['menusAndButtons']['debits']?></button>
                        <?php if ($_SESSION['account']['authority'] > 0) {?>
                        <button class="btn btn-light" name="actions" value="trash"><?=$lang['globals']['trash']?></button>
                        <button class="btn btn-light" name="actions" value="settings"><?=$lang['menusAndButtons']['settings']?></button>
                        <?php
                        }?>
                        <a class="btn btn-danger" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/". basename(getcwd()) . "/index.php"?>"><?=$lang['menusAndButtons']['mainMenu']?></a>
                    </form>
                <?php
            }
        }
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

    $('#reportTable').DataTable( {
		//scrollY: 600,
        //paging: false,
        dom: 'Bfrtip',
		"pageLength": 100,
        buttons: ['copy','excelHtml5', 'csvHtml5', 'print']
		
    } );
	
    if ( window.history.replaceState ) { // Yeniden form gönderme işlemini kapatır
        window.history.replaceState( null, null, window.location.href );
    }

    /* Doesn't matter somethink old
    $('select').on('change', function() {
        if($(this).val() == "diger") {
            $(this).replaceWith('<input class="form-control" type="text" name="'+$(this).attr("name")+'">')
        }
    });
    */
    $('.deleteConfirm').click(function() {
    if (!$(this).is(':checked')) {
        $(this).parent().prev().attr("disabled", true);
    }else{
        $(this).parent().prev().removeAttr("disabled");
    }
  });

  $('#position').on('change', function() {
    suggestions = [];
    arrays[this.value].forEach(function(par) {
        suggestions.push(par["name"]);
    });
    });
});
<?php
    if (isset($_POST['actions']) && $_POST['actions'] == "debits" || $_POST['actions'] == "debitsEditScreen") {
        ?>
        let arrays = {
    <?php
        foreach ($positions as $k) {
            echo "'".$k['id']."': [";
            foreach ($employees as $e) {
                if ($k['id'] == $e['position']) {
                    echo "{ id: '".$e['id']."', name: '".$e['name']. " " . $e['surname'] ."'},";
                }
            }
            echo "],";
        }
    ?>
};

let suggestions = [
    ""
]

// getting all required elements
const searchWrapper = document.querySelector(".search-input");
const inputBox = searchWrapper.querySelector("input");
const suggBox = searchWrapper.querySelector(".autocom-box");
let linkTag = searchWrapper.querySelector("a");
let webLink;

// if user press any key and release 
inputBox.onkeyup = (e)=>{
    let userData = e.target.value; //user enetered data
    let emptyArray = [];
    if(userData){
        emptyArray = suggestions.filter((data)=>{
            //filtering array value and user characters to lowercase and return only those words which are start with user enetered chars
            return data.toLocaleLowerCase().startsWith(userData.toLocaleLowerCase());
        });
        emptyArray = emptyArray.map((data)=>{
            // passing return data inside li tag
            return data = `<li>${data}</li>`;
        });
        searchWrapper.classList.add("active"); //show autocomplete box
        showSuggestions(emptyArray);
        let allList = suggBox.querySelectorAll("li");
        for (let i = 0; i < allList.length; i++) {
            //adding onclick attribute in all li tag
            allList[i].setAttribute("onclick", "select(this)");
            allList[i].setAttribute("class", "wiroDrag");
        }
    }else{
        searchWrapper.classList.remove("active"); //hide autocomplete box
    }
}

function select(element){
    let selectData = element.textContent;
    inputBox.value = selectData;
    searchWrapper.classList.remove("active");
    suggBox.innerHTML = "";
}

function showSuggestions(list){
    let listData;
    if(!list.length){
        userValue = inputBox.value;
        listData = `<li>${userValue}</li>`;
    }else{
      listData = list.join('');
    }
    suggBox.innerHTML = listData;
}

suggestions = [];
    arrays[$("#position").val()].forEach(function(par) {
        suggestions.push(par["name"]);
    });
    <?php
    }
?>
</script>
</html>