<?php
require_once('PostKolli.class.php');

if (!empty($argv[1])) {

  $post = new PostKolli();

  $kolli = $argv[1];

  $data = $post->_getXml($kolli);


  printf("Kolli:\t%s\n", $data['parcel_id']);
  printf("From:\t%s\n", $data['customername']);
  printf("To:\t%s (%s)\n", $data['receivercity'], $data['receiverzipcode']);
  printf("Status:\t%s\n", $data['statusdescription']);
  printf("\n");
  foreach($data['event'] as $e) {
    printf("%s %s - %s : %s\n", $e['date'], $e['time'], $e['location'], $e['description']);
  }

} else {
  printf("Syntax: text.php KOLLI_ID\n");
}



