<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 14/02/2019
 * Time: 08:04
 */

//**************  Exemplo  **************
//Email,Password,Quota
//jill@domain.com,1234,10
//bill@domain.com,4567,8
//phil@domain.com,8910,10

//$header = ['first name', 'last name', 'email'];
//$records = [
//    [1, 2, 3],
//    ['foo', 'bar', 'baz'],
//    ['john', 'doe', 'john.doe@example.com'],
//];
//echo "<pre>";
//print_r($records);
//die;

require 'vendor/autoload.php';

use League\Csv\Writer;

$json = $_POST['json'];

$array_from_json = json_decode($json, true);

$index_email = array_keys($array_from_json)[0];

$email_count = $array_from_json[$index_email]['account_count'];

//echo "<pre>";
//print_r($array_from_json[$index_email]['accounts']);

$emails = $array_from_json[$index_email]['accounts'];

$header_csv = ["Email", "Password", "Quota"];

$pswd = $_POST['senha'];
$static_pswd = false;

if ($pswd !== "" && strlen($pswd) > 6) {
    $static_pswd = true;
}

$prefix_pswd = explode('.', $index_email)[0] . "@";

$sufix_email = "@" . $index_email;
//print_r($index_email);

try {
    $new_emails = manipulateArrayEmails($emails, $prefix_pswd, $sufix_email, $static_pswd, $pswd);
} catch (Exception $e) {
    echo "Parâmetros inválidos. <br>" . $e;
    die;
}

if (count($new_emails) === intval($email_count) && is_array($new_emails)) {
//load the CSV document from a string
    $csv = Writer::createFromString('');

//insert the header
    $csv->insertOne($header_csv);

//insert all the records
    $csv->insertAll($new_emails);

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="emails.csv"');

    echo $csv->getContent();
}

function manipulateArrayEmails($emails, $prefix_pswd, $sufix_email, $static_pswd, $pswd) {
    $new_emails = [];

    if (is_array($emails)) {
        foreach ($emails as $i => $v) {
            $this_email = [];
            $this_email[] = $i . $sufix_email;
            $this_email[] = ($static_pswd) ? $pswd : $prefix_pswd . $i;
            $this_email[] = floor($v['diskquota'] / 1000000);

            array_push($new_emails, $this_email);
        }

        return $new_emails;
    }else{
        throw new Exception("Json inválido");
    }
}

?>