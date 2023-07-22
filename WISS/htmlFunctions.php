<?php

function returnDebitFormHTML(){
    global $lang, $positions;
    ?>
        <form method="POST"> 
            <div id="inputHolder" style="margin: 20px; display:flex; flex-direction: row;">
                <div>
                    <span>
                        <h5><?=$lang['globals']['position']?></h5>
                        <select class="form-select" id="position" name="position">
                            <?php
                                Table2Options($positions);
                            ?>
                        </select>
                    </span>
                    <span>
                        <h5><?=$lang['globals']['employee']?></h5>
                        <div class="wrapper">
                        <div class="search-input">
                            <a href="" target="_blank" hidden></a>
                            <input class="form-control" type="text" name="name" autocomplete="off" placeholder="Type to search..">
                            <div class="autocom-box" style="position: relative;">
                            <!-- here list are inserted from javascript -->
                            </div>
                        </div>
                        </div>
                        <!--
                        <input type="search" class="search form-control" name="employeeId">
                        -->
                    </span>
                </div>
                <div>
                    <span>
                        <h5><?=$lang['computer']['computer']?></h5>
                        <input class="form-control" type="text" name="computerId">
                    </span>
                    <span>
                        <h5><?=$lang['computer']['bag']?></h5>
                        <select class="form-select" name="bag">
                            <option value="1"><?=$lang['globals']['given']?></option>
                            <option value="0"><?=$lang['globals']['notGiven']?></option>
                        </select>
                    </span>
                </div>
                <div>
                <span>
                        <h5><?=$lang['computer']['mouse']?></h5>
                        <select class="form-select" name="mouse">
                            <option value="1"><?=$lang['globals']['given']?></option>
                            <option value="0"><?=$lang['globals']['notGiven']?></option>
                        </select>
                    </span>
                    <span>
                        <h5><?=$lang['computer']['keyboard']?></h5>
                        <select class="form-select" name="keyboard">
                            <option value="1"><?=$lang['globals']['given']?></option>
                            <option value="0"><?=$lang['globals']['notGiven']?></option>
                        </select>
                    </span>
                </div>
                <div>
                    <span>
                        <h5><?=$lang['computer']['monitor']?></h5>
                        <select class="form-select" name="monitor">
                            <option value="1"><?=$lang['globals']['given']?></option>
                            <option value="0"><?=$lang['globals']['notGiven']?></option>
                        </select>
                    </span>
                    <span>
                        <h5><?=$lang['computer']['adapter']?></h5>
                        <select class="form-select" name="adapter">
                            <option value="1"><?=$lang['globals']['given']?></option>
                            <option value="0"><?=$lang['globals']['notGiven']?></option>
                        </select>
                    </span>
                </div>
                <div>
                    <span>
                        <h5><?=$lang['globals']['debitStartDate']?></h5>
                        <input class="form-control" type="date" name="DSD">
                    </span>
                    <span>
                        <h5><?=$lang['globals']['debitEndDate']?></h5>
                        <input class="form-control" type="date" name="DED">
                    </span>
                </div>
    <?php
}

function ReturnEmployeesFormHTML(){
    global $lang, $positions;
    ?>
                    <form method="POST"> 
                    <div id="inputHolder" style="margin: 20px; display:flex; flex-direction: row;">
                        <div>
                            <span>
                                <h5><?=$lang['globals']['name']?></h5>
                                <input name="name" class="form-control"  type="text">
                            </span>
                            <span>
                                <h5><?=$lang['globals']['surname']?></h5>
                                <input name="surName" class="form-control"  type="text">
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['globals']['citizenId']?></h5>
                                <input name="SIN" class="form-control"  type="text">
                            </span>
                            <span>
                                <h5><?=$lang['globals']['phoneNumber']?></h5>
                                <input name="phoneNumber" class="form-control"  type="text">
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['globals']['workGroup']?></h5>
                                <input name="workGroup" class="form-control"  type="text">
                            </span>
                            <span>
                                <h5><?=$lang['globals']['email']?></h5>
                                <input name="email" class="form-control"  type="text">
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['globals']['homeAddress']?></h5>
                                <textarea name="homeAddress" style="height: 110px; resize:none; color:Black;"></textarea>
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['globals']['position']?></h5>
                                <select name="position" class="form-select"><?php
                                            Table2Options($positions);
                                        ?>
                                    </select>
                            </span>
                            <span>
                                <h5><?=$lang['globals']['birthDate']?></h5>
                                <input name="BDate" class="form-control"  type="date">
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['globals']['startWorkDate']?></h5>
                                <input name="SWDate" class="form-control"  type="date">
                            </span>
                            <span>
                                <h5><?=$lang['globals']['dismissalDate']?></h5>
                                <input name="DDate" class="form-control"  type="date">
                            </span>
                        </div>
    <?php
}

function ReturnComputerFormHTML() {
    global $lang, $kinds, $brands, $RAMS, $antiVirus, $OS, $officePrograms, $positions;
    ?>
                <form method="POST"> 
                    <div id="inputHolder" style="margin: 20px; display:flex; flex-direction: row;">
                        <div>
                            <span>
                                <h5><?=$lang['globals']['kind']?></h5>
                                <select name="kind" class="form-select">
                                    <?php
                                        Table2Options($kinds);
                                    ?>
                                </select>
                            </span>
                            <span>
                                <h5><?=$lang['globals']['brand']?></h5>
                                <select name="brand" class="form-select">
                                    <?php
                                        Table2Options($brands);
                                    ?>
                                </select>
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['globals']['model']?></h5>
                                <input name="model" class="form-control"  type="text">
                            </span>
                            <span>
                                <h5><?=$lang['globals']['serialN']?></h5>
                                <input name="serialNumber" class="form-control"  type="text">
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['computer']['CPU']?></h5>
                                <input name="CPU" class="form-control"  type="text">
                            </span>
                            <span>
                                <h5><?=$lang['computer']['RAM']?></h5>
                                <select name="RAM" class="form-select">
                                    <?php
                                        Table2Options($RAMS);
                                    ?>
                                </select>
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['globals']['position']?></h5>
                                <select name="position" class="form-select">
                                    <?php
                                        Table2Options($positions);
                                    ?>
                                </select>
                            </span>
                            <span>
                                <h5><?=$lang['computer']['disk']?></h5>
                                <input name="disk" class="form-control"  type="text">
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['computer']['wifiMac']?></h5>
                                <input name="wifiMac" class="form-control"  type="text">
                            </span>
                            <span>
                                <h5><?=$lang['computer']['ethMac']?></h5>
                                <input name="ethMac" class="form-control"  type="text">
                            </span>
                        </div>
                        <div style="min-width: 150px;">
                            <span>
                                <h5><?=$lang['computer']['OS']?></h5>
                                <select name="OS" class="form-select">
                                    <?php
                                        Table2Options($OS);
                                    ?>
                                </select>
                            </span>
                            <span>
                                <h5><?=$lang['computer']['antiVirus']?></h5>
                                <select name="antiVirus" class="form-select">
                                    <?php
                                        Table2Options($antiVirus);
                                    ?>
                                </select>
                            </span>
                        </div>
                        <div>
                        <span>
                                <h5><?=$lang['computer']['officePrograms']?></h5>
                                <select name="officePrograms" class="form-select">
                                    <?php
                                        Table2Options($officePrograms);
                                    ?>
                                </select>
                            </span>
                            <span>
                                <h5><?=$lang['globals']['purchaseDate']?></h5>
                                <input name="PDate" class="form-control"  type="date">
                            </span>
                        </div>
    <?php
}

function ReturnCellPhoneFormHTML() {
    global $lang, $brands, $positions;
    ?>
                <form method="POST"> 
                    <div id="inputHolder" style="margin: 20px; display:flex; flex-direction: row;">
                        <div>
                            <span>
                                <h5><?=$lang['globals']['brand']?></h5>
                                <select name="brand" class="form-select">
                                    <?php
                                        Table2Options($brands);
                                    ?>
                                </select>
                            </span>
                            <span>
                                <h5><?=$lang['globals']['model']?></h5>
                                <input name="model" class="form-control"  type="text">
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['globals']['serialN']?></h5>
                                <input name="serialNumber" class="form-control"  type="text">
                            </span>
                            <span>
                                <h5><?=$lang['cellPhone']['IMEI']?></h5>
                                <input name="IMEI" class="form-control"  type="text">
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['cellPhone']['adapter']?></h5>
                                <select class="form-select" name="adapter">
                                    <option value="1"><?=$lang['globals']['given']?></option>
                                    <option value="0"><?=$lang['globals']['notGiven']?></option>
                                </select>
                            </span>
                            <span>
                                <h5><?=$lang['cellPhone']['wifiMac']?></h5>
                                <input name="wifiMac" class="form-control"  type="text">
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['globals']['position']?></h5>
                                <select name="position" class="form-select">
                                    <?php
                                        Table2Options($positions);
                                    ?>
                                </select>
                            </span>
                            <span>
                                <h5><?=$lang['globals']['purchaseDate']?></h5>
                                <input name="PDate" class="form-control"  type="date">
                            </span>
                        </div>
    <?php
}


function ReturnCellPhoneDebitFormHTML() {
    global $lang, $positions;
    ?>
                <form method="POST"> 
                    <div id="inputHolder" style="margin: 20px; display:flex; flex-direction: row;">
                        <div>
                            <span>
                                <h5><?=$lang['globals']['position']?></h5>
                                <select class="form-select" id="position" name="position">
                                    <?php
                                        Table2Options($positions);
                                    ?>
                                </select>
                            </span>
                            <span>
                                <h5><?=$lang['globals']['employee']?></h5>
                                <div class="wrapper">
                                <div class="search-input">
                                    <a href="" target="_blank" hidden></a>
                                    <input class="form-control" type="text" name="name" autocomplete="off" placeholder="Type to search..">
                                    <div class="autocom-box" style="position: relative;">
                                    <!-- here list are inserted from javascript -->
                                    </div>
                                </div>
                                </div>
                                <!--
                                <input type="search" class="search form-control" name="employeeId">
                                -->
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['cellPhone']['cellPhone']?></h5>
                                <input name="cellPhone" class="form-control"  type="text">
                            </span>
                            <span>
                                <h5><?=$lang['cellPhone']['extensionNumber']?></h5>
                                <input name="extensionNumber" class="form-control"  type="text">
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['globals']['debitStartDate']?></h5>
                                <input name="DSD" class="form-control"  type="date">
                            </span>
                            <span>
                                <h5><?=$lang['globals']['debitEndDate']?></h5>
                                <input name="DED" class="form-control"  type="date">
                            </span>
                        </div>
    <?php
}

function ReturnNetworkDeviceFormHTML() {
    global $lang, $brands, $kinds;
    ?>
                <form method="POST"> 
                    <div id="inputHolder" style="margin: 20px; display:flex; flex-direction: row;">
                        <div>
                            <span>
                                <h5><?=$lang['globals']['kind']?></h5>
                                <select name="kind" class="form-select">
                                    <?php
                                        Table2Options($kinds);
                                    ?>
                                </select>
                            </span>
                            <span>
                                <h5><?=$lang['globals']['brand']?></h5>
                                <select name="brand" class="form-select">
                                    <?php
                                        Table2Options($brands);
                                    ?>
                                </select>
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['globals']['model']?></h5>
                                <input name="model" class="form-control"  type="text">
                            </span>
                            <span>
                                <h5><?=$lang['globals']['serialN']?></h5>
                                <input name="serialNumber" class="form-control"  type="text">
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['globals']['purchaseDate']?></h5>
                                <input name="PDate" class="form-control"  type="date">
                            </span>
                        </div>
    <?php
}

function ReturnNetworkDeviceDebitFormHTML() {
    global $lang, $positions;
    ?>
                <form method="POST"> 
                    <div id="inputHolder" style="margin: 20px; display:flex; flex-direction: row;">
                        <div>
                            <span>
                                <h5><?=$lang['globals']['position']?></h5>
                                <select class="form-select" id="position" name="position">
                                    <?php
                                        Table2Options($positions);
                                    ?>
                                </select>
                            </span>
                            <span>
                                <h5><?=$lang['globals']['employee']?></h5>
                                <div class="wrapper">
                                <div class="search-input">
                                    <a href="" target="_blank" hidden></a>
                                    <input class="form-control" type="text" name="name" autocomplete="off" placeholder="Type to search..">
                                    <div class="autocom-box" style="position: relative;">
                                    <!-- here list are inserted from javascript -->
                                    </div>
                                </div>
                                </div>
                                <!--
                                <input type="search" class="search form-control" name="employeeId">
                                -->
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['menusAndButtons']['networks']?></h5>
                                <input name="network" class="form-control"  type="text">
                            </span>
                            <span>
                                <h5><?=$lang['globals']['debitStartDate']?></h5>
                                <input name="DSD" class="form-control"  type="date">
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['globals']['debitEndDate']?></h5>
                                <input name="DED" class="form-control"  type="date">
                            </span>
                        </div>
    <?php
}

function ReturnFieldEquipmentsFormHTML() {
    global $lang, $positions, $types;
    ?>
                <form method="POST"> 
                    <div id="inputHolder" style="margin: 20px; display:flex; flex-direction: row;">
                        <div>
                            <span>
                                <h5><?=$lang['globals']['position']?></h5>
                                <select class="form-select" id="position" name="position">
                                    <?php
                                        Table2Options($positions);
                                    ?>
                                </select>
                            </span>
                            <span>
                                <h5><?=$lang['globals']['employee']?></h5>
                                <div class="wrapper">
                                <div class="search-input">
                                    <a href="" target="_blank" hidden></a>
                                    <input class="form-control" type="text" name="name" autocomplete="off" placeholder="Type to search..">
                                    <div class="autocom-box" style="position: relative;">
                                    <!-- here list are inserted from javascript -->
                                    </div>
                                </div>
                                </div>
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['globals']['equipment']?></h5>
                                <select class="form-select" id="equipment" name="type">
                                    <?php
                                        Table2Options($types);
                                    ?>
                                </select>
                            </span>
                            <span>
                                <h5><?=$lang['globals']['model']?></h5>
                                <input name="model" class="form-control"  type="text">
                            </span>
                        </div>
                        <div>
                            <span>
                                <h5><?=$lang['globals']['debitStartDate']?></h5>
                                <input name="DSD" class="form-control"  type="date">
                            </span>
                            <span>
                                <h5><?=$lang['globals']['debitEndDate']?></h5>
                                <input name="DED" class="form-control"  type="date">
                            </span>
                        </div>
    <?php
}

?>