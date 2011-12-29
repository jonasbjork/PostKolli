<?php

class PostKolli {

  private $postUrl = "http://server.logistik.posten.se/servlet/PacTrack?kolliid=";

  function _getUrl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $r = curl_exec($ch);
    curl_close($ch);
    return $r;
  }

  function _getXml($kolliId) {
    $data = $this->_getUrl($this->postUrl.$kolliId);
    $xml = new SimpleXMLElement($data);

    $arr = array(
		 'parcel_id' => (string)$xml->body->parcel['id'],
		 'customerno' => (string)$xml->body->parcel->customerno,
		 'customername' => (string)$xml->body->parcel->customername,
		 'statuscode' => (string)$xml->body->parcel->statuscode,
		 'statusdescription' => (string)$xml->body->parcel->statusdescription,
		 'servicecode' => (string)$xml->body->parcel->servicecode,
		 'servicename' => (string)$xml->body->parcel->servicename,
		 'receiverzipcode' => (string)$xml->body->parcel->receiverzipcode,
		 'receivercity' => (string)$xml->body->parcel->receivercity,
		 'datesent' => (string)$xml->body->parcel->datesent,
		 'actualweight' => (string)$xml->body->parcel->actualweight,
		 );

    foreach ($xml->body->parcel->extraservice as $e) {
      $arr['extraservice'][(string)$e->code] = (string)$e->name;
    }

    foreach ($xml->body->parcel->event as $ev) {
      $arr['event'][] = array(
        'date' => (string)$ev->date,
	'time' => (string)$ev->time,
	'id' => (string)$ev->id,
	'type' => (string)$ev->type,
	'location' => (string)$ev->location,
	'code' => (string)$ev->code,
	'description' => (string)$ev->description,
      );
    }


    return $arr;
  }

}

