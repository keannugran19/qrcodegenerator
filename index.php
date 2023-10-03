<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    :root {
        --text: #0a0b1a;
        --background: #ecedf8;
        --primary: #252965;
        --secondary: #d2d4ee;
        --accent: #424ab3;
    }

    * {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }

    body {
        background-color: var(--background);
    }

    h1,
    p,
    .form-title {
        color: var(--accent);
        text-align: center;
    }

    .img {
        text-align: center;
    }

    .card {
        width: 500px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        background-color: var(--secondary);
    }

    .form-label {
        font-weight: bold;
    }

    .form-input {
        width: 100%;
        height: 40px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-select {
        width: 100%;
        height: 40px;
        margin-bottom: 5px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .submit-button {
        width: 100%;
        height: 40px;
        margin: 10px 0px 10px 0px;
        background-color: var(--primary);
        color: var(--secondary);
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .submit-button:hover {
        background-color: var(--accent);
    }
</style>

<?php

echo "<h1>QR Code Generator</h1>";
echo "<p><em>by: Keannu Gran & Justine De Juan</em></p>";



//set it to writable location, a place for temp generated PNG files
$PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;

//html PNG location prefix
$PNG_WEB_DIR = 'temp/';

include "qrlib.php";

//ofcourse we need rights to create temp dir
if (!file_exists($PNG_TEMP_DIR))
    mkdir($PNG_TEMP_DIR);


$filename = $PNG_TEMP_DIR . 'qrCode.png';

//processing form input
//remember to sanitize user input in real-life solution !!!
$errorCorrectionLevel = 'L';
if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L', 'M', 'Q', 'H')))
    $errorCorrectionLevel = $_REQUEST['level'];

$matrixPointSize = 8;
if (isset($_REQUEST['size']))
    $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


if (isset($_REQUEST['name']) && isset($_REQUEST['address']) && isset($_REQUEST['school']) && isset($_REQUEST['age']) && isset($_REQUEST['status']) && isset($_REQUEST['birthday']) && isset($_REQUEST['phonenumber'])) {

    // Check if the 'name' field is empty
    if (trim($_REQUEST['name']) == '') {
        die('Name cannot be empty! <a href="?">back</a>');
    }

    // Get the values of 'address' and 'school'
    $name = $_REQUEST['name'];
    $address = $_REQUEST['address'];
    $school = $_REQUEST['school'];
    $age = $_REQUEST['age'];
    $birthday = $_REQUEST['birthday'];
    $status = $_REQUEST['status'];
    $phonenumber = $_REQUEST['phonenumber'];

    // Generate a unique filename
    $filename = $PNG_TEMP_DIR . 'test' . md5($name . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';

    // Generate QR code with 'name', 'address', and 'school' values
    QRcode::png("Name: $name\nAddress: $address\nSchool: $school\nAge: $age\nStatus: $status\nBirthday: $birthday\nPhone Number: $phonenumber", $filename, $errorCorrectionLevel, $matrixPointSize, 2);
} else {

    //default data

    QRcode::png('Lecture on QR Code!!! By: Engr. Ian Val P. Delos Reyes, DIT', $filename, $errorCorrectionLevel, $matrixPointSize, 2);

    // SAMPLE DATA:
    //	url 		- http://www.facebook.com
    //	telephone	- tel:09214552001
    //	sms			- smsto:09214552001:How are you?
    // 	email		- mailto:ian_val2008@yahoo.com:Testing email
    //  Text		- I'm generating a QRCode
    //  geolocation - geo:7.3136286,125.6703633?site=DNSC
}

//config form
echo '
<div class="card">
<form action="index.php" method="post">

    <div class="form-title"><h2>Personal Information:</h2></div>
  <div class="form-label">Name:</div>&nbsp;
		<input name="name"  class="form-input" style="width: 500px; height:40px" value="' . (isset($_REQUEST['name']) ? htmlspecialchars($_REQUEST['name']) : '') . '" />&nbsp;
		<br>
        <div class="form-label">Address:</div>&nbsp;
		<input name="address"  class="form-input" style="width: 500px; height:40px" value="' . (isset($_REQUEST['address']) ? htmlspecialchars($_REQUEST['address']) : '') . '" />&nbsp;
		<br>
        <div class="form-label">Age:</div>&nbsp;
		<input name="age" class="form-input" style="width: 500px; height:40px" value="' . (isset($_REQUEST['age']) ? htmlspecialchars($_REQUEST['age']) : '') . '" />&nbsp;
		<br>
        <div class="form-label">School:</div>&nbsp;
		<input name="school" class="form-input" style="width: 500px; height:40px" value="' . (isset($_REQUEST['school']) ? htmlspecialchars($_REQUEST['school']) : '') . '" />&nbsp;
		<br>
        <div class="form-label">Status:</div>&nbsp;
		<input name="status" class="form-input" style="width: 500px; height:40px" value="' . (isset($_REQUEST['status']) ? htmlspecialchars($_REQUEST['status']) : '') . '" />&nbsp;
		<br>
        <div class="form-label">Birthday:</div>&nbsp;
		<input name="birthday" class="form-input" style="width: 500px; height:40px" value="' . (isset($_REQUEST['birthday']) ? htmlspecialchars($_REQUEST['birthday']) : '') . '" />&nbsp;
		<br>
        <div class="form-label">Phone Number:</div>&nbsp;
		<input name="phonenumber" class="form-input" style="width: 500px; height:40px" value="' . (isset($_REQUEST['phonenumber']) ? htmlspecialchars($_REQUEST['phonenumber']) : '') . '" />&nbsp;
		<br>
        <div class="form-label">ECC:</div>&nbsp;<select name="level">
            <option value="L"' . (($errorCorrectionLevel == 'L') ? ' selected' : '') . '>L - smallest</option>
            <option value="M"' . (($errorCorrectionLevel == 'M') ? ' selected' : '') . '>M</option>
            <option value="Q"' . (($errorCorrectionLevel == 'Q') ? ' selected' : '') . '>Q</option>
            <option value="H"' . (($errorCorrectionLevel == 'H') ? ' selected' : '') . '>H - best</option>
        </select>&nbsp;
		<br>
        <div class="form-label">Size:</div>&nbsp;<select name="size">';

for ($i = 1; $i <= 10; $i++)
    echo '<option value="' . $i . '"' . (($matrixPointSize == $i) ? ' selected' : '') . '>' . $i . '</option>';

echo '</select>&nbsp;
        <input type="submit" value="GENERATE" class="submit-button"></form>';

//display generated file
echo '<div class="img">
<img src="' . $PNG_WEB_DIR . basename($filename) . '" />
</div>';

?>