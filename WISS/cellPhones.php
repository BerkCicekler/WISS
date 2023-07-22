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

        ////////////  CellPhones MYSQL querys
        /**/    //Create cellPhone
        /**/if (isset($_POST['createCellPhone']) && $_SESSION['account']['authority'] > 0 && cC($_POST['brand']) && cC($_POST['position']) && cC($_POST['model']) && cC($_POST['serialNumber']) && cC($_POST['IMEI']) && cC($_POST['wifiMac']) && cC($_POST['extensionNumber']) && cC($_POST['adapter']) && cC($_POST['PDate'])) {
        /**/$IMEIControl= $db->query("SELECT COUNT(IMEI) FROM cellphones WHERE IMEI='".$_POST['IMEI']."'")->fetch();
        /**/if ($IMEIControl[0] > 0) {
        /**/    CreateErrorMessage($lang['errorMessages']['sameIMEIError']);
        /**/}else{
        /**/    $values = "'".$_POST['brand']."', '".$_POST['model']."', '".$_POST['position']."' '".$_POST['serialNumber']."', '".$_POST['IMEI']."', '".$_POST['wifiMac']."', '".$_POST['adapter']."', '".$_POST['PDate']."'";
        /**/    $result = $db->exec("INSERT INTO cellphones (brand, model, position, serialNumber, IMEI, wifiMac, adapter, purchaseDate) VALUES ($values)");
        /**/    if ($result) {
        /**/        SuccessMessage();
        /**/    }
        /**/    else{
        /**/        UnexpectedErrorMessage();
        /**/    }
        /**/}
        /**/}
        /**/ //  Edit CellPhone
        /**/if (isset($_POST['editCellPhone']) && $_SESSION['account']['authority'] > 0 && cC($_POST['position']) && cC($_POST['brand']) && cC($_POST['editCellPhone']) && cC($_POST['model']) && cC($_POST['serialNumber']) && cC($_POST['IMEI']) && cC($_POST['wifiMac']) && cC($_POST['adapter']) && cC($_POST['PDate'])) {
        /**/$IMEIControl= $db->query("SELECT COUNT(IMEI) FROM cellphones WHERE IMEI='".$_POST['IMEI']."' AND id !=". $_POST['editCellPhone'])->fetch();
        /**/if ($IMEIControl[0] > 0) {
        /**/    CreateErrorMessage($lang['errorMessages']['sameSerialError']);
        /**/}else{
        /**/    $values = "brand = '" . $_POST['brand'] . "', model = '".$_POST['model']."', position = '".$_POST['position']."', serialNumber = '".$_POST['serialNumber']."', IMEI = '".$_POST['IMEI']."', wifiMac = '".$_POST['wifiMac']."', adapter = '".$_POST['adapter']."', purchaseDate = '".$_POST['PDate']."'";
        /**/    $result = $db->exec("UPDATE cellphones SET $values WHERE id=" . $_POST['editCellPhone']);
        /**/    if ($result) {
        /**/        SuccessMessage();
        /**/    }
        /**/    else{
        /**/        UnexpectedErrorMessage();
        /**/    }
        /**/}
        /**/}
        /**/  // Delete cellphone
        /**/if (isset($_POST['deleteCellPhone']) && cC($_POST['deleteCellPhone']) && $_SESSION['account']['authority'] > 0) {
        /**/    if($db->exec("UPDATE cellphones SET isTrash=1 WHERE id=".$_POST['deleteCellPhone'])){
        /**/    SuccessMessage();
        /**/}else {
        /**/    UnexpectedErrorMessage();
        /**/}
        /**/}
        /**/if (isset($_POST['bringBackCellPhone']) && cC($_POST['bringBackCellPhone']) && $_SESSION['account']['authority'] > 0) {
        /**/    if($db->exec("UPDATE cellphones SET isTrash=0 WHERE id=".$_POST['bringBackCellPhone'])){
        /**/    SuccessMessage();
        /**/}else {
        /**/    UnexpectedErrorMessage();
        /**/}
        /**/}
        ////////////  CEL PHONES MYSQL querys

        if (isset($_POST['createDebit']) && $_SESSION['account']['authority'] > 0 && cC($_POST['position']) && cC($_POST['name']) && cC($_POST['cellPhone']) && cC($_POST['extensionNumber']) && cC($_POST['DED']) && cC($_POST['DSD'])) {
                $fullName = explode(' ',trim($_POST['name']));
                $employee = $db->query("SELECT * FROM employees WHERE position ='" . $_POST['position'] . "' AND name = '". $fullName[0] . "' AND surname = '". $fullName[1] . "'")->fetchAll();
                if (!$employee) {
                    UnexpectedErrorMessage();
                }else {
                    if ($db->query("SELECT COUNT(id) FROM cellphonedebits WHERE debitEndDate IS NULL AND cellPhoneId=" . $_POST['cellPhone'])->fetch()[0] < 1 && count($employee) > 0) {
                        $values = "'".$_POST['cellPhone']."', '".$employee[0]['id']."', '".$_POST['DSD']."', '".$_POST['DED']."', '".$_POST['extensionNumber']."'";
                        if ($db->exec("INSERT INTO cellphonedebits (cellPhoneId, employeeId, debitStartDate, debitEndDate, extensionNumber) VALUES ($values)")) {
                            SuccessMessage();
                        }else {
                            UnexpectedErrorMessage();
                        }
                    }else {
                        CreateErrorMessage($lang['errorMessages']['sameComputer2Debits']);
                    }
                }
        }

        if (isset($_POST['editDebit']) && cC($_POST['editDebit']) && $_SESSION['account']['authority'] > 0 && cC($_POST['position']) && cC($_POST['name']) && cC($_POST['cellPhone']) && cC($_POST['extensionNumber']) && cC($_POST['DED']) && cC($_POST['DSD'])) {
            $fullName = explode(' ',trim($_POST['name']));
            $employee = $db->query("SELECT * FROM employees WHERE position ='" . $_POST['position'] . "' AND name = '". $fullName[0] . "' AND surname = '". $fullName[1] . "'")->fetchAll();
            if (!$employee) {
                UnexpectedErrorMessage();
            }else {
                $values = "cellPhoneId = '".$_POST['cellPhone']."', employeeId='".$employee[0]['id']."', debitStartDate='".$_POST['DSD']."', debitEndDate='".$_POST['DED']."', extensionNumber='".$_POST['extensionNumber']."'";
                if ($db->query("SELECT COUNT(id) FROM cellPhoneDebits WHERE debitEndDate IS NULL OR debitEndDate='0000-00-00' AND id != " . $_POST['editDebit'] ." AND cellPhoneId = " . $_POST['cellPhone'])->fetch()[0] < 1) {
                    if ($db->exec("UPDATE cellPhoneDebits SET " . $values . " WHERE id = " . $_POST['editDebit'])) {
                        SuccessMessage();
                    }else {
                        UnexpectedErrorMessage();
                    }
                }else {
                    CreateErrorMessage($lang['errorMessages']['sameComputer2Debits']);
                }
            }
        }

        if (isset($_POST['deleteDebit']) && cC($_POST['deleteDebit'])) {
            if ($db->exec("DELETE FROM cellphonedebits WHERE id=".$_POST['deleteDebit'])) {
                SuccessMessage();
            }else {
                UnexpectedErrorMessage();
            }
        }

        $brands = $db->query("SELECT * FROM cellphonebrands")->fetchAll();
        $positions = $db->query("SELECT * FROM positions")->fetchAll();

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
                    case 'cellPhones':
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
                        ReturnCellPhoneFormHTML();
                    ?>
                        <div>
                            <span style="height: 68%;display: flex; justify-content: center; align-items:center;">
                                <button type="submit" name="createCellPhone" value="1" class="btn btn-light"><?=$lang['globals']['create']?></button> 
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
                            <th><?=$lang['globals']['brand']?></th>
                            <th><?=$lang['globals']['model']?></th>
                            <th><?=$lang['globals']['position']?></th>
                            <th><?=$lang['globals']['serialN']?></th>
                            <th><?=$lang['cellPhone']['IMEI']?></th>
                            <th><?=$lang['cellPhone']['wifiMac']?></th>
                            <th><?=$lang['cellPhone']['adapter']?></th>
                            <th><?=$lang['globals']['purchaseDate']?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // List all phones
                            $cellPhones = $db->query("SELECT * FROM cellphones WHERE isTrash=0")->fetchAll();
                            foreach ($cellPhones as $k) {
                                ?>
                                    <tr>
                                    <?php
                                        if ($_SESSION['account']['authority'] > 0) {?>
                                        <td>
                                            <form method="POST">
                                            <button type="submit" class="btn btn-light" name="actions" value="cellPhoneEditScreen"><?=$lang['globals']['edit']?></button>
                                            <input type="hidden" name="id" value="<?=$k['id']?>">
                                            <button type="submit" class="btn btn-danger" name="deleteCellPhone" disabled value="<?=$k['id']?>"><?=$lang['globals']['delete']?></button>
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
                                            if ($db->query("SELECT COUNT(id) FROM cellphonedebits WHERE cellphoneId=" . $k['id'])->fetch()[0] >= 0) {
                                                if ($db->query("SELECT COUNT(id) FROM cellphonedebits WHERE cellphoneId=" . $k['id'] . " AND debitEndDate IS NULL OR cellphoneId=" . $k['id'] . " AND debitEndDate='0000-00-00'")->fetch()[0] > 0) {
                                                    echo "<td>".$lang['globals']['inDebit']. "</td>";
                                                }else {
                                                    echo "<td>".$lang['globals']['notDebit'];
                                                    ?>
                                                    <form method="POST"><input type="hidden" name="actions" value="debits"><button type="submit" class="btn btn-light" name="cId" value="<?=$k['id']?>"><?=$lang['globals']['debitIt']?></button></form></td>
                                                    <?php
                                                }
                                                
                                            }
                                        ?>
                                        <td><?=indexToText($brands, $k['brand'])?></td>
                                        <td><?=$k['model']?></td>
                                        <td><?=indexToText($positions, $k['position'])?></td>
                                        <td><?=$k['serialNumber']?></td>
                                        <td><?=$k['IMEI']?></td>
                                        <td><?=$k['wifiMac']?></td>
                                        <td><?=$k['adapter']?></td>
                                        <td><?=$k['purchaseDate']?></td>
                                    </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                    </table>
                        <?php
                        break;
                    case 'cellPhoneEditScreen':
                        if (cC($_POST['id']) && $_SESSION['account']['authority'] > 0) {
                            $cellPhone = $db->query("SELECT * FROM cellphones WHERE id=" . $_POST['id'])->fetchAll()[0];
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
                        ReturnCellPhoneFormHTML();
                        ?>
                                <div>
                                    <span style="display:flex; height: 72%; justify-content: center; align-items: center;">
                                        <button type="submit" name="editCellPhone" value="<?=$_POST['id']?>" class="btn btn-light"><?=$lang['globals']['edit']?></button> 
                                    </span>
                                    <span style="display:flex; height: 27%; justify-content: center; align-items: center;">
                                        <button type="submit" name="actions" value="cellPhones" class="btn btn-danger"><?=$lang['globals']['cancel']?></button> 
                                    </span>
                                </div>
                            </div>
                        </form>
                        <script>
                                $("input[name=model]").val("<?=$cellPhone['model']?>");
                                $("input[name=serialNumber]").val("<?=$cellPhone['serialNumber']?>");
                                $("input[name=IMEI]").val("<?=$cellPhone['IMEI']?>");
                                $("input[name=wifiMac]").val("<?=$cellPhone['wifiMac']?>");
                                $("input[name=adapter]").val("<?=$cellPhone['adapter']?>");
                                $("input[name=PDate]").val("<?=$cellPhone['purchaseDate']?>");
                                $("select[name=brand]").val("<?=$cellPhone['brand']?>");
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
                    ReturnCellPhoneDebitFormHTML();
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
                                <?php
                                if ($_SESSION['account']['authority'] > 0) {?>
                                <th><?=$lang['globals']['extras']?></th>
                                <?php
                                }?>
                                <th><?=$lang['globals']['employee']?></th>
                                <th><?=$lang['cellPhone']['cellPhone']?></th>
                                <th><?=$lang['globals']['debitStartDate']?></th>
                                <th><?=$lang['globals']['debitEndDate']?></th>
                                <th><?=$lang['cellPhone']['extensionNumber']?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // List all cellphones
                                $debits = $db->query("SELECT * FROM cellphonedebits")->fetchAll();
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
                                            <?php
                                                if ($_SESSION['account']['authority'] > 0) {?>
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
                                            <?php
                                                }?>
                                            <td><a target="_blank" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/bigInfo.php?employee=" . $k['employeeId'] . '&actions=employee"'?>"><?= $employee ?></a></td>
                                            <td><?=$k['cellPhoneId']?></td>
                                            <td><?=$k['debitStartDate']?></td>
                                            <td><?=$k['debitEndDate']?></td>
                                            <td><?=$k['extensionNumber']?></td>
                                        </tr>
                                    <?php
                                }
                                if (isset($_POST['cId'])) {
                                    echo '<script>$("input[name=cellPhone]").val("'.$_POST['cId'].'");</script>';
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
                                ReturnCellPhoneDebitFormHTML();
                                $k = $db->query("SELECT * FROM cellPhoneDebits WHERE id = ". $_POST['id'])->fetchAll()[0];
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
                                    $("input[name=cellPhone]").val("<?=$k['cellPhoneId']?>");
                                    $("input[name=extensionNumber]").val("<?=$k['extensionNumber']?>");
                                    $("input[name=DED]").val("<?=$k['debitEndDate']?>");
                                    $("input[name=DSD]").val("<?=$k['debitStartDate']?>");
                                    $("select[name=position]").val("<?=$position?>");
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
                            <th><?=$lang['globals']['brand']?></th>
                            <th><?=$lang['globals']['model']?></th>
                            <th><?=$lang['globals']['serialN']?></th>
                            <th><?=$lang['cellPhone']['IMEI']?></th>
                            <th><?=$lang['cellPhone']['wifiMac']?></th>
                            <th><?=$lang['cellPhone']['extensionNumber']?></th>
                            <th><?=$lang['cellPhone']['adapter']?></th>
                            <th><?=$lang['globals']['purchaseDate']?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // List all phones
                            $cellPhones = $db->query("SELECT * FROM cellphones WHERE isTrash=1")->fetchAll();
                            foreach ($cellPhones as $k) {
                                ?>
                                    <tr>
                                    <?php
                                        if ($_SESSION['account']['authority'] > 0) {?>
                                        <td>
                                            <form method="POST">
                                            <button type="submit" class="btn btn-light" name="bringBackCellPhone" value="<?=$k['id']?>"><?=$lang['globals']['bringBack']?></button>
                                            </form>
                                        </td>
                                        <?php
                                        }?>
                                        <td><?=$k['id']?></td>
                                        <td><?=indexToText($brands, $k['brand'])?></td>
                                        <td><?=$k['model']?></td>
                                        <td><?=$k['serialNumber']?></td>
                                        <td><?=$k['IMEI']?></td>
                                        <td><?=$k['wifiMac']?></td>
                                        <td><?=$k['extensionNumber']?></td>
                                        <td><?=$k['adapter']?></td>
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
                            <a class="btn btn-light" style="margin-left: 5px;" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/globalEditPage.php?langTable=cellPhone&table=cellphonebrands&valueName=brand"?>" ><?=$lang['globals']['brand']?></a> 
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
                        <button class="btn btn-light" name="actions" value="cellPhones"><?=$lang['cellPhone']['cellPhone']?></button>
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