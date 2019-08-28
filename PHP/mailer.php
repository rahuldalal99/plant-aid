<?php

  session_start();

  require_once 'Google/Client.php';
  require_once 'Google/Service/Gmail.php';

  // Replace this with your Google Client ID
  $client_id     = 'apps.googleusercontent.com';
  $client_secret = '-Google-Client-Secret';
  $redirect_uri  = 'http://example.com/'; // Change this

  $client = new Google_Client();
  $client->setClientId($client_id);
  $client->setClientSecret($client_secret);
  $client->setRedirectUri($redirect_uri);

  // We only need permissions to compose and send emails
  $client->addScope("https://www.googleapis.com/auth/gmail.compose");
  $service = new Google_Service_Gmail($client);

  // Redirect the URL after OAuth
  if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
  }

  // If Access Toket is not set, show the OAuth URL
  if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
  } else {
    $authUrl = $client->createAuthUrl();
  }

  if ($client->getAccessToken() && isset($_POST['message'])) {

    $_SESSION['access_token'] = $client->getAccessToken();

    // Prepare the message in message/rfc822
    try {

        // The message needs to be encoded in Base64URL
        $mime = rtrim(strtr(base64_encode($_POST["message"]), '+/', '-_'), '=');
        $msg = new Google_Service_Gmail_Message();
        $msg->setRaw($mime);
        $service->users_messages->send("me", $msg);

    } catch (Exception $e) {
        print($e->getMessage());
        unset($_SESSION['access_token']);
    }

  } ?>

 <? if ( isset ( $authUrl ) ) { ?>
  <a href="<?= $authUrl; ?>"><img src="#" title="Sign-in with Google" /></a>
 <? } else { ?>
  <form method="POST" action="">
    <textarea name="message" required></textarea>
    <input type="email" required name="to">
    <input type="text"  required name="subject">
    <a href="#" onclick="document.forms.htmlmail.submit();return false;">Send Mail</a>
  </form>
<? } ?>
