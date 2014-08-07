<?php
define('__ROOT__', dirname(__FILE__));
error_reporting(E_ALL);
ini_set('display_errors', 1);

  require_once(__ROOT__ . '/config/constants.php');

  require_once(PATH_TO_GOOGLE_API . 'Google/Client.php');
  require_once(PATH_TO_GOOGLE_API . 'Google/Service/Analytics.php');

// create client object and set app name
$client = new Google_Client();
$client->setApplicationName(APP_NAME); // name of your app

// set assertion credentials
$client->setAssertionCredentials(
  new Google_Auth_AssertionCredentials(

    APP_EMAIL, // email you added to GA

    array('https://www.googleapis.com/auth/analytics.readonly'),

    file_get_contents(PATH_TO_PRIVATE_KEY_FILE)  // keyfile you downloaded

));

// other settings
$client->setClientId(CLIENT_ID);           // from API console
// $client->setAccessType('offline_access');  // this may be unnecessary?

// create service and get data
$service = new Google_Service_Analytics($client);

// ids - Unique table ID for retrieving Analytics data. Table ID is of the form ga:XXXX, where XXXX is the Analytics view (profile) ID.
// startDate - Start date for fetching Analytics data. Requests can specify a start date formatted as YYYY-MM-DD, or as a relative date (e.g., today, yesterday, or 7daysAgo). The default value is 7daysAgo.
// endDate - End date for fetching Analytics data. Request can should specify an end date formatted as YYYY-MM- DD, or as a relative date (e.g., today, yesterday, or 7daysAgo). The default value is yesterday.
// metrics - A comma-separated list of Analytics metrics. E.g., 'ga:sessions,ga:pageviews'. At least one metric must be specified.
$ids = 'ga:59542273';
$startDate = '2014-01-01';
$endDate = '2014-01-31';
$metrics = 'ga:bounces';
$optParams = array('segment' => 'users::sequence::ga:userType==New Vistor');
$call = $service->data_ga->get($ids, $startDate, $endDate, $metrics, $optParams);


$totalsForAllResults = $call->totalsForAllResults;
// $bounceRate = $totalsForAllResults['bounces'] / $totalsForAllResults['sessions'];
// $organic = $totalsForAllResults['organicSearches'];
// $newVisitors = $totalsForAllResults['newUsers'];
// $returning = $totalsForAllResults['users'] - $totalsForAllResults['newUsers'];

//var_dump(compact('bounceRate', 'organic', 'newVisitors', 'returning'));
var_dump($totalsForAllResults);

?>