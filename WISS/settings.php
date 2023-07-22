<?php
ob_start();
session_start();
setlocale(LC_TIME,'turkish');
try {
    $db = new PDO("mysql:host=localhost; dbname=WISS; charset=utf8;", "root", "");
} catch (Exception $e) {
    echo $e->getMessage();
}

if(isset($_SESSION['account'])){ // This is for control client account data incorrect | This required for security
    $isCorrent = $db->query("SELECT COUNT(*) from accounts WHERE username='".$_SESSION['account']['username']."' AND password='".$_SESSION['account']['password']."'")->fetchColumn();
    if ($isCorrent > 0) {
        $_SESSION['account'] =  $db->query("SELECT * from accounts WHERE username='".$_SESSION['account']['username']."' AND password='".$_SESSION['account']['password']."'")->fetchAll()[0];
    }else {
        $_SESSION['account'] = NULL;
    }
}

// controls is client selected a language
if (isset($_SESSION['account']['selectedLanguage']) && $_SESSION['account']['selectedLanguage'] != "" ){
    $cLang = $_SESSION['account']['selectedLanguage'];  // cLang is mean clientLanguage
}else {
    $cLang = "TR"; // Deafult Language
}

$lang = json_decode(file_get_contents("languages.json"), true);  // gets languages and turn it into a php array
$langKeys = array_keys($lang);
$lang = $lang[$cLang][0];
$lang['globals'] = $lang['globals'][0];
$lang['errorMessages'] = $lang['errorMessages'][0];
$lang['menusAndButtons'] = $lang['menusAndButtons'][0];
$lang['computer'] = $lang['computer'][0];
$lang['cellPhone'] = $lang['cellPhone'][0];


$announceHacker = FALSE;


$easterEggsOn = TRUE;

$easterEggMessages = array("I am going UP and you're going down",
"Next time give me ghallenge, Please",
"Sorry about that amigo. get respawn so I can chase you down again",
"You can't out run the OCT TRAIN",
"You think I'm afraid of you. I'm blow up my own legs",
"If its make you feel any better My fans love you",
"I'd say eat my dust, but.. you're already dead, amigo."
);

/*                                                                                   
███████╗██╗   ██╗███╗   ██╗ ██████╗████████╗██╗ ██████╗ ███╗   ██╗███████╗
██╔════╝██║   ██║████╗  ██║██╔════╝╚══██╔══╝██║██╔═══██╗████╗  ██║██╔════╝
█████╗  ██║   ██║██╔██╗ ██║██║        ██║   ██║██║   ██║██╔██╗ ██║███████╗
██╔══╝  ██║   ██║██║╚██╗██║██║        ██║   ██║██║   ██║██║╚██╗██║╚════██║
██║     ╚██████╔╝██║ ╚████║╚██████╗   ██║   ██║╚██████╔╝██║ ╚████║███████║
╚═╝      ╚═════╝ ╚═╝  ╚═══╝ ╚═════╝   ╚═╝   ╚═╝ ╚═════╝ ╚═╝  ╚═══╝╚══════╝
*/   
        
function UseEasterEgg() {
    if (rand(0, 100) < 10) {
        return TRUE;
    }else {
        return FALSE;
    }
}

function SelectEasterEggMessage() {
    global $easterEggMessages;
    return $easterEggMessages[array_rand($easterEggMessages)];
}

function AnnounceFuckingHacker($sql_str) { // if anyone try to access where need permissions and he don't have permission | send a warning
    //send Email
}

function Error2FuckingHacker(){
    global $easterEggsOn, $announceHacker;
    if ($easterEggsOn) {
        if (UseEasterEgg()) {
            CreateErrorMessage(SelectEasterEggMessage());
        }else {
            UnexpectedErrorMessage();
        }
    }else {
        UnexpectedErrorMessage();
    }
    if ($announceHacker) {
        AnnounceFuckingHacker();
    }
}

if (!function_exists('str_contains')) {
    function str_contains(string $haystack, string $needle): bool
    {
        return '' === $needle || false !== strpos($haystack, $needle);
    }
}

function Table2Options($table) {  
    // this function is for creating options elemet 
    foreach ($table as $k) {
        echo '<option value="'.$k['id'].'">'.$k['value'].'</option>';
    }
}


function cC(string $str) // Banned char control
{
    global $lang;
    if (!str_contains($str, "'") && !str_contains($str, '"')) {
        return true;
    } else {
        echo '<script type="text/javascript">Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "'.$lang['errorMessages']['bannedCharsMessage'].'"
          })</script>';  
    }
}

function mainMenuBtn() {
    global $lang;
    echo '<a type="submit" class="btn btn-danger" href="'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".  basename(getcwd()) . '/index.php"  style="position: absolute; right: 1px; top: 0;">'.$lang['menusAndButtons']['mainMenu'].'</a>';
}

function indexToText($array, $yourIndex) {
    foreach ($array as $k) {
        if ($k['id'] == $yourIndex) {
            return $k['value'];
        }
    }
}

function UnexpectedErrorMessage(){
    global $lang;
    echo '<script type="text/javascript">Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "'.$lang['errorMessages']['UnexpectedErrorMessage'].'"
      })</script>';  
}

function SuccessMessage() {
    global $lang;
    echo '<script type="text/javascript">Swal.fire({
        position: "top-end",
        icon: "success",
        title: "'.$lang['successMessage'].'",
        showConfirmButton: false,
        timer: 1500
      })</script>';
}

function CreateErrorMessage($string){
    echo '<script type="text/javascript">Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "'.$string.'"
      })</script>';  
}

?>