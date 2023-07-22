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

        ////////////  FIELD EQUIPMENTS MYSQL querys
        /**/    //Create field equipment
        /**/if (isset($_POST['createFieldEquipment']) && $_SESSION['account']['authority'] > 0 && cC($_POST['type']) && cC($_POST['model']) && cC($_POST['name']) && cC($_POST['DSD']) && cC($_POST['DED'])) {
            $fullName = explode(' ',trim($_POST['name']));
            $employee = $db->query("SELECT * FROM employees WHERE position ='" . $_POST['position'] . "' AND name = '". $fullName[0] . "' AND surname = '". $fullName[1] . "'")->fetchAll();
            if (!$employee) {
                UnexpectedErrorMessage();
            }else {
        /**/
        /**/    $values = "'".$employee[0]['id']."', '".$_POST['type']."', '".$_POST['model']."', '".$_POST['DSD']."', '".$_POST['DED']."'";
        /**/    $result = $db->exec("INSERT INTO fieldEquipments (employeeId, type, model, debitStartDate, debitEndDate) VALUES ($values)");
        /**/    if ($result) {
        /**/        SuccessMessage();
        /**/    }
        /**/    else{
        /**/        UnexpectedErrorMessage();
        /**/    }
        /**/}
        /**/}
        /**/ //  Edit fielt equipment
        /**/if (isset($_POST['editFieldEquipment']) && $_SESSION['account']['authority'] > 0 && cC($_POST['type']) && cC($_POST['model']) && cC($_POST['name']) && cC($_POST['DSD']) && cC($_POST['DED'])) {
            $fullName = explode(' ',trim($_POST['name']));
            $employee = $db->query("SELECT * FROM employees WHERE position ='" . $_POST['position'] . "' AND name = '". $fullName[0] . "' AND surname = '". $fullName[1] . "'")->fetchAll();
            if (!$employee) {
                UnexpectedErrorMessage();
            }else {
        /**/
        /**/    $values = "employeeId = '".$employee[0]['id']."', type = '".$_POST['type']."', model = '".$_POST['model']."', debitStartDate = '".$_POST['DSD']."', debitEndDate = '".$_POST['DED']."'";
        /**/    $result = $db->exec("UPDATE fieldEquipments SET $values WHERE id=".$_POST['editFieldEquipment']);
        /**/    if ($result) {
        /**/        SuccessMessage();
        /**/    }
        /**/    else{
        /**/        UnexpectedErrorMessage();
        /**/    }
        /**/}
        /**/}
        /**/  // Delete field Equipment
        /**/if (isset($_POST['deleteFieldEquipment']) && cC($_POST['deleteFieldEquipment']) && $_SESSION['account']['authority'] > 0) {
        /**/    if($db->exec("UPDATE fieldEquipment SET isTrash=1 WHERE id=".$_POST['deleteFieldEquipment'])){
        /**/    SuccessMessage();
        /**/}else {
        /**/    UnexpectedErrorMessage();
        /**/}
        /**/}
        /**/if (isset($_POST['bringBackFieldEquipment']) && cC($_POST['bringBackFieldEquipment']) && $_SESSION['account']['authority'] > 0) {
        /**/    if($db->exec("UPDATE fieldEquipments SET isTrash=0 WHERE id=".$_POST['bringBackFieldEquipment'])){
        /**/    SuccessMessage();
        /**/}else {
        /**/    UnexpectedErrorMessage();
        /**/}
        /**/}
        ////////////  FIELD EQUIPMENTS MYSQL querys

        $positions = $db->query("SELECT * FROM positions")->fetchAll();
        $employees = $db->query("SELECT * FROM employees")->fetchAll();
        $types = $db->query("SELECT * FROM fieldEquipmentTypes")->fetchAll();
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
                    case 'fieldEquipments':
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
                        ReturnFieldEquipmentsFormHTML();
                    ?>
                        <div>
                            <span style="height: 68%;display: flex; justify-content: center; align-items:center;">
                                <button type="submit" name="createFieldEquipment" value="1" class="btn btn-light"><?=$lang['globals']['create']?></button> 
                            </span>
                        </div>
                    </div>
                </form><?php
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
                            <th><?=$lang['globals']['employee']?></th>
                            <th><?=$lang['globals']['type']?></th>
                            <th><?=$lang['globals']['model']?></th>
                            <th><?=$lang['globals']['debitStartDate']?></th>
                            <th><?=$lang['globals']['debitEndDate']?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // List all field Equipments
                            $fieldE = $db->query("SELECT * FROM fieldEquipments WHERE isTrash=0")->fetchAll();
                            foreach ($fieldE as $k) {
                                ?>
                                    <tr>
                                    <?php
                                        if ($_SESSION['account']['authority'] > 0) {?>
                                        <td>
                                            <form method="POST">
                                            <button type="submit" class="btn btn-light" name="actions" value="fieldEquipmentEditScreen"><?=$lang['globals']['edit']?></button>
                                            <input type="hidden" name="id" value="<?=$k['id']?>">
                                            <button type="submit" class="btn btn-danger" name="deleteFieldEquipment" disabled value="<?=$k['id']?>"><?=$lang['globals']['delete']?></button>
                                            <span style="display: block;">
                                                <input type="checkbox" class="deleteConfirm form-check-input" id="deleteConfirm<?=$k['id']?>" >
                                                <label class="form-check-label deleteConfirm" for="deleteConfirm<?=$k['id']?>" style="user-select: none;" ><?=$lang['globals']['deleteConfirm']?></label>
                                            </span>
                                            </form>
                                        </td>
                                        <?php
                                        }?>
                                        <td><?=$k['id']?></td>
                                        <td><a target="_blank" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/bigInfo.php?employee=" . $k['employeeId'] . '&actions=employee"'?>"><?=$k['employeeId']?></a></td>
                                        <td><?=indexToText($types, $k['type'])?></td>
                                        <td><?=$k['model']?></td>
                                        <td><?=$k['debitStartDate']?></td>
                                        <td><?=$k['debitEndDate']?></td>
                                    </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                    </table>
                        <?php
                        break;
                    case 'fieldEquipmentEditScreen':
                        if (cC($_POST['id']) && $_SESSION['account']['authority'] > 0) {
                            $fieldE = $db->query("SELECT * FROM fieldEquipments WHERE id=". $_POST['id'])->fetchAll()[0];
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
                        ReturnFieldEquipmentsFormHTML();
                        foreach ($employees as $d) {
                            if ($fieldE['employeeId'] == $d['id']) {
                                $fullName = $d['name'] . " " . $d['surname'];
                                $position = $d['position'];
                            }
                        }
                        ?>
                                <div>
                                    <span style="display:flex; height: 72%; justify-content: center; align-items: center;">
                                        <button type="submit" name="editFieldEquipment" value="<?=$_POST['id']?>" class="btn btn-light"><?=$lang['globals']['edit']?></button> 
                                    </span>
                                    <span style="display:flex; height: 27%; justify-content: center; align-items: center;">
                                        <button type="submit" name="actions" value="fieldEquipments" class="btn btn-danger"><?=$lang['globals']['cancel']?></button> 
                                    </span>
                                </div>
                            </div>
                        </form>
                        <script>
                                $("input[name=model]").val("<?=$fieldE['model']?>");
                                $("input[name=name]").val("<?=$fullName?>");
                                $("input[name=DED]").val("<?=$fieldE['debitEndDate']?>");
                                $("input[name=DSD]").val("<?=$fieldE['debitStartDate']?>");
                                $("select[name=position]").val("<?=$position?>");
                                $("select[name=type]").val("<?=$fieldE['type']?>");
                        </script>
                        <?php
                        }
                    break;
                        case 'trash':
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
                                <th><?=$lang['globals']['type']?></th>
                                <th><?=$lang['globals']['model']?></th>
                                <th><?=$lang['globals']['debitStartDate']?></th>
                                <th><?=$lang['globals']['debitEndDate']?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // List all field Equipments
                                $fieldE = $db->query("SELECT * FROM fieldEquipments WHERE isTrash=1")->fetchAll();
                                foreach ($fieldE as $k) {
                                    ?>
                                        <tr>
                                        <?php
                                            if ($_SESSION['account']['authority'] > 0) {?>
                                            <td>
                                            <form method="POST">
                                            <button type="submit" class="btn btn-light" name="bringBackFieldEquipment" value="<?=$k['id']?>"><?=$lang['globals']['bringBack']?></button>
                                            </form>
                                            </td>
                                            <?php
                                            }?>
                                            <td><?=$k['id']?></td>
                                            <td><?=indexToText($types, $k['type'])?></td>
                                            <td><?=$k['model']?></td>
                                            <td><?=$k['debitStartDate']?></td>
                                            <td><?=$k['debitEndDate']?></td>
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
                            <a class="btn btn-light" style="margin-left: 5px;" href="<?=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . "/globalEditPage.php?langTable=globals&table=fieldEquipmentTypes&valueName=type"?>" ><?=$lang['globals']['type']?></a> 
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
                        <button class="btn btn-light" name="actions" value="fieldEquipments"><?=$lang['menusAndButtons']['fieldEquipments']?></button>
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
    if (isset($_POST['actions']) && $_POST['actions'] == "fieldEquipments" || $_POST['actions'] == "fieldEquipmentEditScreen") {
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