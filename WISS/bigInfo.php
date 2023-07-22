<?php  // biginfo.php for just list the all devices and other stuffs that employee owned
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

        if (isset($_POST['cEndDebit']) && cC($_POST['cEndDebit']) && $_SESSION['account']['authority'] > 0) {
            $result = $db->exec("UPDATE computerdebits SET debitEndDate='".date('Y-m-d')."' WHERE id=" . $_POST['cEndDebit']);
        }
        if (isset($_POST['pEndDebit']) && cC($_POST['pEndDebit']) && $_SESSION['account']['authority'] > 0) {
            $result = $db->exec("UPDATE cellphonedebits SET debitEndDate='".date('Y-m-d')."' WHERE id=" . $_POST['pEndDebit']);
        }
        if (isset($_POST['nEndDebit']) && cC($_POST['nEndDebit']) && $_SESSION['account']['authority'] > 0) {
            $result = $db->exec("UPDATE networkdevicedebits SET debitEndDate='".date('Y-m-d')."' WHERE id=" . $_POST['nEndDebit']);
        }
        if (isset($_POST['fEndDebit']) && cC($_POST['fEndDebit']) && $_SESSION['account']['authority'] > 0) {
            $result = $db->exec("UPDATE fieldequipments SET debitEndDate='".date('Y-m-d')."' WHERE id=" . $_POST['fEndDebit']);
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
            if (isset($_GET['actions'])) {
                switch ($_GET['actions']) {
                    case 'employee':
                        if (isset($_GET['employee']) && cC($_GET['employee'])) {
                            $employee = $db->query("SELECT * FROM employees WHERE id=". $_GET['employee'])->fetchAll()[0];
                            $positions = $db->query("SELECT * FROM positions")->fetchAll();
                            $kinds = $db->query("SELECT * FROM computerKinds")->fetchAll();
                            $brands = $db->query("SELECT * FROM computerBrands")->fetchAll();
                            $RAMS = $db->query("SELECT * FROM computerRAM")->fetchAll();
                            $antiVirus = $db->query("SELECT * FROM computerAntiVirus")->fetchAll();
                            $OS = $db->query("SELECT * FROM computerOS")->fetchAll();
                            $officePrograms = $db->query("SELECT * FROM computerOfficePrograms")->fetchAll();
                            $positions = $db->query("SELECT * FROM positions")->fetchAll();
                            if ($employee && $positions) {
                                ?>
                                <style>
                                body {
                                    justify-content: flex-start !important;
                                    flex-direction: column;
                                }
                                </style>
                                <h1><?=$lang['globals']['employee']?></h1>
                    <table id="wiroTable" style="width:80%;" class="table table-bordered table-striped table-dark">
                    <thead>
                        <tr style="text-align: center; text-transform: uppercase;">
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
                    <h1><?=$lang['menusAndButtons']['computers']?></h1>
                    <table style="width:80%;" class="table table-bordered table-striped table-dark">
                    <thead>
                        <tr style="text-align: center; text-transform: uppercase;">
                            <th><?=$lang['globals']['id']?></th>
                            <th><?=$lang['globals']['kind']?></th>
                            <th><?=$lang['globals']['brand']?></th>
                            <th><?=$lang['globals']['model']?></th>
                            <th><?=$lang['globals']['serialN']?></th>
                            <th><?=$lang['computer']['CPU']?></th>
                            <th><?=$lang['computer']['RAM']?></th>
                            <th><?=$lang['computer']['disk']?></th>
                            <th><?=$lang['computer']['PDate']?></th>
                            <th><?=$lang['computer']['wifiMac']?></th>
                            <th><?=$lang['computer']['ethMac']?></th>
                            <th><?=$lang['computer']['OS']?></th>
                            <th><?=$lang['computer']['officePrograms']?></th>
                            <th><?=$lang['computer']['antiVirus']?></th>
                            <th><?=$lang['globals']['other']?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // List all computers
                            $computerDebits = $db->query("SELECT * FROM computerDebits")->fetchAll();
                            $computers = $db->query("SELECT * FROM computers WHERE isTrash=0")->fetchAll();
                            foreach ($computers as $k) {
                                foreach ($computerDebits as $d) {
                                    if ($d['computerId'] == $k['id']) {
                                        ?>
                                        <tr>
                                            <td><?=$k['id']?></td>
                                            <td><?=indexToText($kinds, $k['kind'])?></td>
                                            <td><?=indexToText($brands, $k['brand'])?></td>
                                            <td><?=$k['model']?></td>
                                            <td><?=$k['serialNumber']?></td>
                                            <td><?=$k['CPU']?></td>
                                            <td><?=indexToText($RAMS, $k['RAM'])?></td>
                                            <td><?=$k['disk']?></td>
                                            <td><?=$k['dateOfPurchase']?></td>
                                            <td><?=$k['wifiMac']?></td>
                                            <td><?=$k['ethMac']?></td>
                                            <td><?=indexToText($OS, $k['OS'])?></td>
                                            <td><?=indexToText($officePrograms, $k['officePrograms'])?></td>
                                            <td><?=indexToText($antiVirus, $k['antiVirus'])?></td>
                                            <?php
                                            if ($d['debitEndDate'] == NULL || $d['debitEndDate'] == '0000-00-00') {
                                                ?><td><form method="POST"><button type="submit" class="btn btn-light" name="cEndDebit" value="<?=$d['id']?>"><?=$lang['globals']['endDebit']?></button></form></td><?php
                                            }else {
                                                ?><td><?=$lang['globals']['debitEnded']?></td><?php
                                            }?>
                                        </tr>
                                    <?php
                                    break;
                                    }
                                }
                            }
                        ?>
                    </tbody>
                    </table>
                    <h1><?=$lang['menusAndButtons']['cellPhones']?></h1>
                    <table style="width:80%;" class="table table-bordered table-striped table-dark">
                    <thead>
                        <tr style="text-align: center; text-transform: uppercase;">
                            <th><?=$lang['globals']['id']?></th>
                            <th><?=$lang['globals']['brand']?></th>
                            <th><?=$lang['globals']['model']?></th>
                            <th><?=$lang['globals']['serialN']?></th>
                            <th><?=$lang['cellPhone']['IMEI']?></th>
                            <th><?=$lang['cellPhone']['wifiMac']?></th>
                            <th><?=$lang['cellPhone']['adapter']?></th>
                            <th><?=$lang['globals']['purchaseDate']?></th>
                            <th><?=$lang['globals']['other']?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // List all phones
                            $cellPhoneDebits = $db->query("SELECT * FROM cellPhoneDebits WHERE employeeId = ". $_GET['employee'])->fetchAll();
                            $cellPhones = $db->query("SELECT * FROM cellphones WHERE isTrash=0")->fetchAll();
                            $cellPhonebrands = $db->query("SELECT * FROM cellPhoneBrands")->fetchAll();
                            foreach ($cellPhones as $k) {
                                foreach ($cellPhoneDebits as $d) {
                                    if ($d['cellPhoneId'] == $k['id']) {
                                        ?>
                                        <tr>
                                            <td><?=$k['id']?></td>
                                            <td><?=indexToText($cellPhonebrands, $k['brand'])?></td>
                                            <td><?=$k['model']?></td>
                                            <td><?=$k['serialNumber']?></td>
                                            <td><?=$k['IMEI']?></td>
                                            <td><?=$k['wifiMac']?></td>
                                            <td><?=$k['adapter']?></td>
                                            <td><?=$k['purchaseDate']?></td>
                                            <?php
                                            if ($d['debitEndDate'] == NULL || $d['debitEndDate'] == '0000-00-00') {
                                                ?><td><form method="POST"><button type="submit" class="btn btn-light" name="pEndDebit" value="<?=$d['id']?>"><?=$lang['globals']['endDebit']?></button></form></td><?php
                                            }else {
                                                ?><td><?=$lang['globals']['debitEnded']?></td><?php
                                            }?>
                                        </tr>
                                    <?php
                                        break;
                                    }
                                }

                            }
                        ?>
                    </tbody>
                    </table>
                    <h1><?=$lang['menusAndButtons']['network']?></h1>
                    <table style="width:80%;" class="table table-bordered table-striped table-dark">
                    <thead>
                        <tr style="text-align: center; text-transform: uppercase;">
                            <th><?=$lang['globals']['id']?></th>
                            <th><?=$lang['globals']['kind']?></th>
                            <th><?=$lang['globals']['brand']?></th>
                            <th><?=$lang['globals']['model']?></th>
                            <th><?=$lang['globals']['serialN']?></th>
                            <th><?=$lang['globals']['purchaseDate']?></th>
                            <th><?=$lang['globals']['other']?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // List all network
                            $networkKinds = $db->query("SELECT * FROM networkDKinds")->fetchAll();
                            $networkBrands = $db->query("SELECT * FROM networkDBrands")->fetchAll();
                            $networkDeviceDebits = $db->query("SELECT * FROM networkDeviceDebits WHERE employeeId = ". $_GET['employee'])->fetchAll();
                            $networkDevices = $db->query("SELECT * FROM networkDevices WHERE isTrash=0")->fetchAll();
                            foreach ($networkDevices as $k) {
                                foreach ($networkDeviceDebits as $d) {
                                    if ($d['networkDeviceId'] == $k['id']) {
                                        ?>
                                        <tr>
                                            <td><?=$k['id']?></td>
                                            <td><?=indexToText($networkKinds, $k['kind'])?></td>
                                            <td><?=indexToText($networkBrands, $k['brand'])?></td>
                                            <td><?=$k['model']?></td>
                                            <td><?=$k['serialNumber']?></td>
                                            <td><?=$k['purchaseDate']?></td>
                                            <?php
                                            if ($d['debitEndDate'] == NULL || $d['debitEndDate'] == '0000-00-00') {
                                                ?><td><form method="POST"><button type="submit" class="btn btn-light" name="nEndDebit" value="<?=$d['id']?>"><?=$lang['globals']['endDebit']?></button></form></td><?php
                                            }else {
                                                ?><td><?=$lang['globals']['debitEnded']?></td><?php
                                            }?>
                                        </tr>
                                    <?php
                                        break;
                                    }
                                }
                            }
                        ?>
                    </tbody>
                    </table>
                    <h1><?=$lang['menusAndButtons']['fieldEquipments']?></h1>
                    <table style="width:80%;" class="table table-bordered table-striped table-dark">
                        <thead>
                            <tr style="text-align: center; text-transform: uppercase;">
                                <th><?=$lang['globals']['id']?></th>
                                <th><?=$lang['globals']['employee']?></th>
                                <th><?=$lang['globals']['type']?></th>
                                <th><?=$lang['globals']['model']?></th>
                                <th><?=$lang['globals']['debitStartDate']?></th>
                                <th><?=$lang['globals']['debitEndDate']?></th>
                                <th><?=$lang['globals']['other']?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // List all field Equipments
                                $types = $db->query("SELECT * FROM fieldEquipmentTypes")->fetchAll();
                                $fieldE = $db->query("SELECT * FROM fieldEquipments WHERE isTrash=0 AND employeeId = ". $_GET['employee'])->fetchAll();
                                foreach ($fieldE as $k) {
                                    ?>
                                        <tr>
                                            <td><?=$k['id']?></td>
                                            <td><a target="_blank" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/bigInfo.php?employee=" . $k['employeeId'] . '&actions=employee"'?>"><?=$k['employeeId']?></a></td>
                                            <td><?=indexToText($types, $k['type'])?></td>
                                            <td><?=$k['model']?></td>
                                            <td><?=$k['debitStartDate']?></td>
                                            <td><?=$k['debitEndDate']?></td>
                                            <?php
                                            if ($d['debitEndDate'] == NULL || $d['debitEndDate'] == '0000-00-00') {
                                                ?><td><form method="POST"><button type="submit" class="btn btn-light" name="fEndDebit" value="<?=$d['id']?>"><?=$lang['globals']['endDebit']?></button></form></td><?php
                                            }else {
                                                ?><td><?=$lang['globals']['debitEnded']?></td><?php
                                            }?>
                                        </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                        </table>
                                <?php
                            }
                        }else {
                            Error2FuckingHacker();
                        }
                        break;

                    default:
                        UnexpectedErrorMessage();
                        break;
                }
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
});
</script>
</html>