<?php
require_once 'vendor/autoload.php';
/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
//define( STDIN ,"4/AACVUBY6qDPCbHojBgE6BsCVYQzgRFOpbASra64onfb8_-WcTB_e4Fg");
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Drive API PHP Quickstart');
    $client->setScopes(Google_Service_Drive::DRIVE_METADATA_READONLY);
    $client->setAuthConfig('client_secret.json');
    $client->setAccessType('offline');

    // Load previously authorized credentials from a file.
    $credentialsPath = expandHomeDirectory('credentials.json');
    if (file_exists($credentialsPath)) {
        $accessToken = json_decode(file_get_contents($credentialsPath), true);
    } else {
        // Request authorization from the user.
        $authUrl = $client->createAuthUrl();
        printf("Open the following link in your browser:\n%s\n", $authUrl);
        print 'Enter verification code: ';
        $authCode = trim(fgets(STDIN));

        // Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        // Store the credentials to disk.
        if (!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0700, true);
        }
        file_put_contents($credentialsPath, json_encode($accessToken));
        printf("Credentials saved to %s\n", $credentialsPath);
    }
    $client->setAccessToken($accessToken);

    // Refresh the token if it's expired.
    if ($client->isAccessTokenExpired()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path)
{
    $homeDirectory = getenv('HOME');
    if (empty($homeDirectory)) {
        $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
    }
    return str_replace('~', realpath($homeDirectory), $path);
}

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Drive($client);

// Print the names and IDs for up to 10 files.
$optParams = array(
    'pageSize' => 50,
//    'fields' => 'nextPageToken, files(id, size, name, createdTime, parents, hasThumbnail, thumbnailLink, webContentLink, iconLink, imageMediaMetadata, fileExtension, webViewLink)',
    'q' => "parents = '0B_nWBbr_Zq7FZXdWT1Vkb242NUk'",
    'fields' => 'nextPageToken, files(id, size, name, createdTime, parents, hasThumbnail, thumbnailLink, webContentLink, iconLink, imageMediaMetadata, fileExtension, webViewLink)'
);
$results = $service->files->listFiles($optParams);

if (count($results->getFiles()) == 0) {
    print "No files found.\n";
} else {
    print "Files:\n";
    foreach ($results->getFiles() as $file) {
        echo "<br>";
        echo "Size: " . $file->getSize();
        echo "<br>";
        echo "Name: " . $file->getName();
        echo "<br>";
        echo "Created time: " . $file->getCreatedTime();
        echo "<br>";
        echo "Tem thumb: " . $file->getHasThumbnail();
        echo "<br>";
        echo "thumb link https://drive.google.com/thumbnail?id=YourFileID: " . $file->getThumbnailLink();
        echo "<br>";
        echo "link : " . $file->getWebContentLink();
        echo "<br>";
        echo "icon : " . $file->getIconLink();
        echo "<br>";
        echo "ext : " . $file->getFileExtension();
        echo "<br>";
        echo "id : " . $file->getId();
        echo "<br>";
        echo "web : " . $file->getWebViewLink();
        echo "<br>";
//        echo "parents : <pre>";
//        var_dump($file->getParents());
//        echo "</pre>";
//        echo "<br>";
//        echo "image : <pre>";
//        var_dump($file->getImageMediaMetadata());
        echo "</pre>";
        echo "--------------------------------------------";
        echo "<br>";
    }
}
?>
<div style="width: 100%; height: 100%;">
    <iframe src="https://drive.google.com/embeddedfolderview?id=1iV9HYHMrpGi66eqwFOkRdSmLkRcnPeZt" width="100%"  height="537" frameborder="0"></iframe>
</div>

