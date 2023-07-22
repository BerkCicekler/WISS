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

        ////////////  COMPUTERS MYSQL querys
        /**/    //Create Computer
        /**/if (isset($_POST['createComputer']) && $_SESSION['account']['authority'] > 0 && cC($_POST['kind']) && cC($_POST['brand']) && cC($_POST['model']) && cC($_POST['serialNumber']) && cC($_POST['CPU']) && cC($_POST['RAM']) && cC($_POST['disk']) && cC($_POST['PDate']) && cC($_POST['wifiMac']) && cC($_POST['ethMac']) && cC($_POST['OS']) && cC($_POST['officePrograms']) && cC($_POST['antiVirus'])) {
        /**/$SNControl= $db->query("SELECT COUNT(serialNumber) FROM computers WHERE serialNumber='".$_POST['serialNumber']."'")->fetch();
        /**/if ($SNControl[0] > 0) {
        /**/    CreateErrorMessage($lang['errorMessages']['sameSerialError']);
        /**/}else{
        /**/    $values = "'".$_POST['kind']."','".$_POST['brand']."','".$_POST['model']."', '".$_POST['position']."', '".$_POST['serialNumber']."','".$_POST['CPU']."','".$_POST['RAM']."','".$_POST['disk']."','".$_POST['PDate']."','".$_POST['wifiMac']."','".$_POST['ethMac']."','".$_POST['OS']."','".$_POST['officePrograms']."','".$_POST['antiVirus']."'";
        /**/    $result = $db->exec("INSERT INTO computers (kind, brand, model, position, serialNumber, CPU, RAM, disk, dateOfPurchase, wifiMac, ethMac, OS, officePrograms, antiVirus) VALUES ($values)");
        /**/    if ($result) {
        /**/        SuccessMessage();
        /**/    }
        /**/    else{
        /**/        UnexpectedErrorMessage();
        /**/    }
        /**/}
        /**/}
        /**/ //  Edit Computer
        /**/if (isset($_POST['editComputer']) && cC($_POST['editComputer']) && $_SESSION['account']['authority'] > 0 && cC($_POST['kind']) && cC($_POST['brand']) && cC($_POST['model']) && cC($_POST['serialNumber']) && cC($_POST['CPU']) && cC($_POST['RAM']) && cC($_POST['disk']) && cC($_POST['PDate']) && cC($_POST['wifiMac']) && cC($_POST['ethMac']) && cC($_POST['OS']) && cC($_POST['officePrograms']) && cC($_POST['antiVirus'])) {
        /**/$sINControl= $db->query("SELECT COUNT(serialNumber) FROM computers WHERE serialNumber = '".$_POST['serialNumber']."' AND id != " . $_POST['editComputer'])->fetch();
        /**/if ($sINControl[0] > 0) {
        /**/    CreateErrorMessage($lang['errorMessages']['sameSerialError']);
        /**/}else{
        /**/    $values = "kind='".$_POST['kind']."', brand='".$_POST['brand']."', model='".$_POST['model']."', position='".$_POST['position']."', serialNumber='".$_POST['serialNumber']."', CPU='".$_POST['CPU']."', RAM='".$_POST['RAM']."', disk='".$_POST['disk']."', dateOfPurchase='".$_POST['PDate']."', wifiMac='".$_POST['wifiMac']."', ethMac='".$_POST['ethMac']."', OS='".$_POST['OS']."', officePrograms='".$_POST['officePrograms']."', antiVirus='".$_POST['antiVirus']."'";
        /**/    $result = $db->exec("UPDATE computers SET $values WHERE id=" . $_POST['editComputer']);
        /**/    if ($result) {
        /**/        SuccessMessage();
        /**/    }
        /**/    else{
        /**/        UnexpectedErrorMessage();
        /**/    }
        /**/}
        /**/}
        /**/  // Delete Computer
        /**/if (isset($_POST['deleteComputer']) && cC($_POST['deleteComputer']) && $_SESSION['account']['authority'] > 0) {
        /**/    if($db->exec("UPDATE computers SET isTrash=1 WHERE id=".$_POST['deleteComputer'])){
        /**/    SuccessMessage();
        /**/}else {
        /**/    UnexpectedErrorMessage();
        /**/}
        /**/}
        /**/if (isset($_POST['bringBack']) && cC($_POST['bringBack']) && $_SESSION['account']['authority'] > 0) {
        /**/    if($db->exec("UPDATE computers SET isTrash=0 WHERE id=".$_POST['bringBack'])){
        /**/    SuccessMessage();
        /**/}else {
        /**/    UnexpectedErrorMessage();
        /**/}
        /**/}
        ////////////  COMPUTERS MYSQL querys

        if (isset($_POST['createDebit']) && $_SESSION['account']['authority'] > 0 && cC($_POST['computerId']) && cC($_POST['name']) && cC($_POST['position']) && cC($_POST['DSD']) && cC($_POST['mouse']) && cC($_POST['adapter']) && cC($_POST['bag']) && cC($_POST['keyboard']) && cC($_POST['monitor'])) {
                $fullName = explode(' ',trim($_POST['name']));
                $employee = $db->query("SELECT * FROM employees WHERE position ='" . $_POST['position'] . "' AND name = '". $fullName[0] . "' AND surname = '". $fullName[1] . "'")->fetchAll();
                if (!$employee) {
                    UnexpectedErrorMessage();
                }
            if ($db->query("SELECT COUNT(id) FROM computerdebits WHERE debitEndDate IS NULL AND computerId=" . $_POST['computerId'])->fetch()[0] < 1 && count($employee) > 0) {
                $values = "'".$_POST['computerId']."', '".$employee[0]['id']."', '".$_POST['DSD']."', '".$_POST['mouse']."', '".$_POST['adapter']."', '".$_POST['bag']."', '".$_POST['keyboard']."', '".$_POST['monitor']."'";
                if ($db->exec("INSERT INTO computerdebits (computerId, employeeId, debitStartDate, mouse, adapter, bag, keyboard, monitor) VALUES ($values)")) {
                    SuccessMessage();
                }else {
                    UnexpectedErrorMessage();
                }
            }else {
                CreateErrorMessage($lang['errorMessages']['sameComputer2Debits']);
            }
        }

        if (isset($_POST['editDebit']) && cC($_POST['editDebit']) && $_SESSION['account']['authority'] > 0 && cC($_POST['computerId']) && cC($_POST['name']) && cC($_POST['position']) && cC($_POST['DED']) && cC($_POST['DSD']) && cC($_POST['mouse']) && cC($_POST['adapter']) && cC($_POST['bag']) && cC($_POST['keyboard']) && cC($_POST['monitor'])) {
            $fullName = explode(' ',trim($_POST['name']));
            $employee = $db->query("SELECT * FROM employees WHERE position ='" . $_POST['position'] . "' AND name = '". $fullName[0] . "' AND surname = '". $fullName[1] . "'")->fetchAll();
            if (!$employee) {
                UnexpectedErrorMessage();
            }
            
            $values = "computerId = '".$_POST['computerId']."', employeeId = '".$employee[0]['id']."', debitStartDate = '".$_POST['DSD']."', debitEndDate = '".$_POST['DED']."', mouse = '".$_POST['mouse']."', adapter = '".$_POST['adapter']."', bag = '".$_POST['bag']."', keyboard = '".$_POST['keyboard']."', monitor = '".$_POST['monitor']."'";
            if ($db->query("SELECT COUNT(id) FROM computerdebits WHERE debitEndDate IS NULL AND id != " . $_POST['editDebit'] ." AND computerId = " . $_POST['computerId'])->fetch()[0] < 1) {
                if ($db->exec("UPDATE computerdebits SET " . $values . " WHERE id = " . $_POST['editDebit'])) {
                    SuccessMessage();
                }else {
                    UnexpectedErrorMessage();
                }
            }else {
                CreateErrorMessage($lang['errorMessages']['sameComputer2Debits']);
            }
        }

        if (isset($_POST['deleteDebit']) && cC($_POST['deleteDebit'])) {
            if ($db->exec("DELETE FROM computerDebits WHERE id=". $_POST['deleteDebit'])) {
                SuccessMessage();
            }else {
                UnexpectedErrorMessage();
            }
        }

        $kinds = $db->query("SELECT * FROM computerKinds")->fetchAll();
        $brands = $db->query("SELECT * FROM computerBrands")->fetchAll();
        $RAMS = $db->query("SELECT * FROM computerRAM")->fetchAll();
        $antiVirus = $db->query("SELECT * FROM computerAntiVirus")->fetchAll();
        $OS = $db->query("SELECT * FROM computerOS")->fetchAll();
        $officePrograms = $db->query("SELECT * FROM computerOfficePrograms")->fetchAll();
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
                    case 'computers':
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
                        ReturnComputerFormHTML();
                ?>
                        <div>
                            <span style="height: 68%;display: flex; justify-content: center; align-items:center;">
                                <button type="submit" name="createComputer" value="1" class="btn btn-light"><?=$lang['globals']['create']?></button> 
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
                            <th><?=$lang['globals']['position']?></th>
                            <th><?=$lang['globals']['serialN']?></th>
                            <th><?=$lang['computer']['CPU']?></th>
                            <th><?=$lang['computer']['RAM']?></th>
                            <th><?=$lang['computer']['disk']?></th>
                            <th><?=$lang['computer']['wifiMac']?></th>
                            <th><?=$lang['computer']['ethMac']?></th>
                            <th><?=$lang['computer']['OS']?></th>
                            <th><?=$lang['computer']['officePrograms']?></th>
                            <th><?=$lang['computer']['antiVirus']?></th>
                            <th><?=$lang['computer']['PDate']?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // List all computers
                            $first = true;
                            $custom = "";
                            if ($_SESSION['account']['authority'] < 2) {
                                foreach (json_decode($_SESSION['account']['position']) as $key => $value) {
                                    if ($first) {
                                        $custom = $custom . " AND position='".$value."'";
                                        $first=false;
                                    }else {
                                    $custom = $custom . " OR position='".$value."'";
                                    }
                                }
                            }
                            $computers = $db->query("SELECT * FROM computers WHERE isTrash=0" . $custom)->fetchAll();
                            foreach ($computers as $k) {
                                ?>
                                    <tr>
                                    <?php
                                        if ($_SESSION['account']['authority'] > 0) {?>
                                        <td>
                                            <form method="POST">
                                            <button type="submit" class="btn btn-light" name="actions" value="computerEditScreen"><?=$lang['globals']['edit']?></button>
                                            <input type="hidden" name="id" value="<?=$k['id']?>">
                                            <button type="submit" class="btn btn-danger" name="deleteComputer" disabled value="<?=$k['id']?>"><?=$lang['globals']['delete']?></button>
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
                                            if ($db->query("SELECT COUNT(id) FROM computerdebits WHERE computerId=" . $k['id'])->fetch()[0] >= 0) {
                                                if ($db->query("SELECT COUNT(id) FROM computerdebits WHERE computerId=" . $k['id'] . " AND debitEndDate IS NULL OR computerId=" . $k['id'] . " AND debitEndDate='0000-00-00'")->fetch()[0] > 0) {
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
                                        <td><?=indexToText($positions, $k['position'])?></td>
                                        <td><?=$k['serialNumber']?></td>
                                        <td><?=$k['CPU']?></td>
                                        <td><?=indexToText($RAMS, $k['RAM'])?></td>
                                        <td><?=$k['disk']?></td>
                                        <td><?=$k['wifiMac']?></td>
                                        <td><?=$k['ethMac']?></td>
                                        <td><?=indexToText($OS, $k['OS'])?></td>
                                        <td><?=indexToText($officePrograms, $k['officePrograms'])?></td>
                                        <td><?=indexToText($antiVirus, $k['antiVirus'])?></td>
                                        <td><?=$k['dateOfPurchase']?></td>
                                    </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                    </table>
                        <?php
                        break;
                    case 'computerEditScreen':
                        if (cC($_POST['id']) && $_SESSION['account']['authority'] > 0) {
                            $computer = $db->query("SELECT * FROM computers WHERE id=" . $_POST['id'])->fetchAll()[0];
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
                        ReturnComputerFormHTML();
                        ?>
                                <div>
                                    <span style="display:flex; height: 72%; justify-content: center; align-items: center;">
                                        <button type="submit" name="editComputer" value="<?=$_POST['id']?>" class="btn btn-light"><?=$lang['globals']['edit']?></button> 
                                    </span>
                                    <span style="display:flex; height: 27%; justify-content: center; align-items: center;">
                                        <button type="submit" name="actions" value="computers" class="btn btn-danger"><?=$lang['globals']['cancel']?></button> 
                                    </span>
                                </div>
                            </div>
                        </form>
                        <script>
                                    $("input[name=model]").val("<?=$computer['model']?>");
                                    $("input[name=serialNumber]").val("<?=$computer['serialNumber']?>");
                                    $("input[name=CPU]").val("<?=$computer['CPU']?>");
                                    $("input[name=disk]").val("<?=$computer['disk']?>");
                                    $("input[name=wifiMac]").val("<?=$computer['wifiMac']?>");
                                    $("input[name=ethMac]").val("<?=$computer['ethMac']?>");
                                    $("input[name=PDate]").val("<?=$computer['dateOfPurchase']?>");
                                    $("select[name=kind]").val("<?=$computer['kind']?>");
                                    $("select[name=brand]").val("<?=$computer['brand']?>");
                                    $("select[name=RAM]").val("<?=$computer['RAM']?>");
                                    $("select[name=OS]").val("<?=$computer['OS']?>");
                                    $("select[name=officePrograms]").val("<?=$computer['officePrograms']?>");
                                    $("select[name=antiVirus]").val("<?=$computer['antiVirus']?>");
                        </script>
                        <?php
                        }
                    break;
                    case 'computerList':
                        ?>
                        <div style="width: 100%; display:flex; justify-content:center; align-items: center; margin-top: 100px;">
                        <table id="reportTable" style="width:80%;" class="table table-bordered table-striped table-dark">
                        <thead>
                            <tr style="text-align: center; text-transform: uppercase;">
                                <th><?=$lang['globals']['kind']?></th>
                                <th><?=$lang['globals']['brand']?></th>
                                <th><?=$lang['globals']['model']?></th>
                                <th><?=$lang['globals']['position']?></th>
                                <th><?=$lang['globals']['serialN']?></th>
                                <th><?=$lang['computer']['CPU']?></th>
                                <th><?=$lang['computer']['RAM']?></th>
                                <th><?=$lang['computer']['disk']?></th>
                                <th><?=$lang['computer']['wifiMac']?></th>
                                <th><?=$lang['computer']['ethMac']?></th>
                                <th><?=$lang['computer']['OS']?></th>
                                <th><?=$lang['computer']['officePrograms']?></th>
                                <th><?=$lang['computer']['antiVirus']?></th>
                                <th><?=$lang['computer']['PDate']?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // List all computers
                                $computers = $db->query("SELECT * FROM computers WHERE isTrash=0")->fetchAll();
                                foreach ($computers as $k) {
                                    ?>
                                        <tr>
                                            <td><?=indexToText($kinds, $k['kind'])?></td>
                                            <td><?=indexToText($brands, $k['brand'])?></td>
                                            <td><?=$k['model']?></td>
                                            <td><?=indexToText($positions, $k['position'])?></td>
                                            <td><?=$k['serialNumber']?></td>
                                            <td><?=$k['CPU']?></td>
                                            <td><?=indexToText($RAMS, $k['RAM'])?></td>
                                            <td><?=$k['disk']?></td>
                                            <td><?=$k['wifiMac']?></td>
                                            <td><?=$k['ethMac']?></td>
                                            <td><?=indexToText($OS, $k['OS'])?></td>
                                            <td><?=indexToText($officePrograms, $k['officePrograms'])?></td>
                                            <td><?=indexToText($antiVirus, $k['antiVirus'])?></td>
                                            <td><?=$k['dateOfPurchase']?></td>
                                        </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                        </table>
                            <?php
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
                    returnDebitFormHTML();
                    ?>
                    <div>
                    <span>
                        <button class="btn btn-light" name="createDebit" value="e" style="margin-top: 31px;"><?=$lang['globals']['save']?></button>
                    </span>
                    <?php
                    }?>
                </div>
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
                                <th><?=$lang['globals']['employee'] . " " . $lang['globals']['position']?></th>
                                <th><?=$lang['computer']['computer']?></th>
                                <th><?=$lang['globals']['debitStartDate']?></th>
                                <th><?=$lang['globals']['debitEndDate']?></th>
                                <th><?=$lang['computer']['mouse']?></th>
                                <th><?=$lang['computer']['keyboard']?></th>
                                <th><?=$lang['computer']['monitor']?></th>
                                <th><?=$lang['computer']['adapter']?></th>
                                <th><?=$lang['computer']['bag']?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // List all computers
                                $debits = $db->query("SELECT * FROM computerDebits")->fetchAll();
                                $employees = $db->query("SELECT * FROM employees")->fetchAll();
                                foreach ($debits as $k) {
                                    ?>
                                        <tr>
                                        <?php
                                        $fullName = $lang['globals']['emptyVal'];
                                        $employePosition = "";
                                        foreach ($employees as $d) {
                                            if ($d['id'] == $k['employeeId']) {
                                                $fullName = $d['name'] . " " . $d['surname'];
                                                $employePosition = $d['position'];
                                                break;
                                            }
                                        }
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
                                            <td><a target="_blank" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/bigInfo.php?employee=" . $k['employeeId'] . '&actions=employee"'?>"><?=$fullName?></a></td>
                                            <td><?=IndexToText($positions, $employePosition)?></td>
                                            <td><?=$k['computerId']?></td>
                                            <td><?=$k['debitStartDate']?></td>
                                            <td><?=$k['debitEndDate']?></td>
                                            <td><?=$k['mouse']?></td>
                                            <td><?=$k['keyboard']?></td>
                                            <td><?=$k['monitor']?></td>
                                            <td><?=$k['adapter']?></td>
                                            <td><?=$k['bag']?></td>
                                        </tr>
                                    <?php
                                }
                                if (isset($_POST['cId'])) {
                                    echo '<script>$("input[name=computerId]").val("'.$_POST['cId'].'");</script>';
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
                                returnDebitFormHTML();
                                $k = $db->query("SELECT * FROM computerdebits WHERE id = ". $_POST['id'])->fetchAll()[0];
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
                                    $("input[name=computerId]").val("<?=$k['computerId']?>");
                                    $("select[name=bag]").val("<?=$k['bag']?>");
                                    $("select[name=mouse]").val("<?=$k['mouse']?>");
                                    $("select[name=adapter]").val("<?=$k['adapter']?>");
                                    $("select[name=keyboard]").val("<?=$k['keyboard']?>");
                                    $("select[name=monitor]").val("<?=$k['monitor']?>");
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
                            <th><?=$lang['globals']['extras']?></th>
                            <th><?=$lang['globals']['id']?></th>
                            <th><?=$lang['globals']['kind']?></th>
                            <th><?=$lang['globals']['brand']?></th>
                            <th><?=$lang['globals']['model']?></th>
                            <th><?=$lang['globals']['serialN']?></th>
                            <th><?=$lang['computer']['CPU']?></th>
                            <th><?=$lang['computer']['RAM']?></th>
                            <th><?=$lang['computer']['disk']?></th>
                            <th><?=$lang['computer']['wifiMac']?></th>
                            <th><?=$lang['computer']['ethMac']?></th>
                            <th><?=$lang['computer']['OS']?></th>
                            <th><?=$lang['computer']['officePrograms']?></th>
                            <th><?=$lang['computer']['antiVirus']?></th>
                            <th><?=$lang['computer']['PDate']?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // List all computers
                            $computers = $db->query("SELECT * FROM computers WHERE isTrash=1")->fetchAll();
                            foreach ($computers as $k) {
                                ?>
                                    <tr>
                                        <td>
                                            <form method="POST">
                                            <button type="submit" class="btn btn-light" name="bringBack" value="<?=$k['id']?>"><?=$lang['globals']['bringBack']?></button>
                                            </form>
                                        </td>
                                        <td><?=$k['id']?></td>
                                        <td><?=indexToText($kinds, $k['kind'])?></td>
                                        <td><?=indexToText($brands, $k['brand'])?></td>
                                        <td><?=$k['model']?></td>
                                        <td><?=$k['serialNumber']?></td>
                                        <td><?=$k['CPU']?></td>
                                        <td><?=indexToText($RAMS, $k['RAM'])?></td>
                                        <td><?=$k['disk']?></td>
                                        <td><?=$k['wifiMac']?></td>
                                        <td><?=$k['ethMac']?></td>
                                        <td><?=indexToText($OS, $k['OS'])?></td>
                                        <td><?=indexToText($officePrograms, $k['officePrograms'])?></td>
                                        <td><?=indexToText($antiVirus, $k['antiVirus'])?></td>
                                        <td><?=$k['dateOfPurchase']?></td>
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
                            <a class="btn btn-light" style="margin-left: 5px;" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/globalEditPage.php?langTable=computer&table=computerBrands&valueName=brand"?>" ><?=$lang['globals']['brand']?></a> 
                            <a class="btn btn-light" style="margin-left: 5px;" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/globalEditPage.php?langTable=computer&table=computerRAM&valueName=RAM"?>" ><?=$lang['computer']['RAM']?></a> 
                            <a class="btn btn-light" style="margin-left: 5px;" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/globalEditPage.php?langTable=computer&table=computerOS&valueName=OS"?>" ><?=$lang['computer']['OS']?></a> 
                            <a class="btn btn-light" style="margin-left: 5px;" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/globalEditPage.php?langTable=computer&table=computerOfficePrograms&valueName=officePrograms"?>" ><?=$lang['computer']['officePrograms']?></a> 
                            <a class="btn btn-light" style="margin-left: 5px;" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/globalEditPage.php?langTable=computer&table=computerAntiVirus&valueName=antiVirus"?>" ><?=$lang['computer']['antiVirus']?></a>
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
                    <button class="btn btn-light" name="actions" value="computers"><?=$lang['menusAndButtons']['computers']?></button>
                    <button class="btn btn-light" name="actions" value="computerList"><?=$lang['menusAndButtons']['computerList']?></button>
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