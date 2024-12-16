<?php

foreach (glob (PATH_CONTENT.'lff-events/venues/*.json') as $key => $file ) 
	{
		$data=json_decode(file_get_contents($file),true);
		$venues[]=$data;
	}

$dataFile=file_get_contents(PATH_CONTENT.'/lff-events/json/lffeventdata.json');
$data = json_decode($dataFile,true); 
$events = $data['events'];
$venues = $data['places'];
$highlights = $data['highlights'];
$services = $data['services'];


function getEvent($id) {
	global $events;
	$id = str_replace("_"," ",$id);
	foreach ($events as $event) {
		if ($event['eventtitle'] == $id) { return $event; }
	}
}

function getVenue($id) {
	global $venues;
	$name=str_replace('_',' ',$id);
	foreach ($venues as $venue) {
		if ($venue['venuename'] == $name) { return $venue; }
	}
}

function getHighlight($id) {
	global $highlights;
	foreach ($highlights as $highlight) {
		if ($highlight['highlightid'] == $id) { return $highlight; }
	}
}

function getService($id) {
	global $services;
	foreach ($services as $service) {
		if ($service['serviceid'] == $id) { return $service; }
	}
}

function findFile($id) {

	foreach (glob (PATH_CONTENT.'lff-events/*', GLOB_ONLYDIR) as $folder)
		{
			if (!str_contains($folder,'json'))
			{
				foreach (glob ($folder.'/*.json') as $file) 
					{
						$contents = file_get_contents($file);
						if (strpos($contents, $id)) { return $file; }
					}
			}	
	}
	
}

function findVenueAddress($name) {
	global $venues;
	foreach ($venues as $venue) {
		if ($venue['venuename'] == $name) { return $venue['venueaddress']; }
	}
}

function findVenueImage($name) {
	global $venues;
	foreach ($venues as $venue) {
		if ($venue['venuename'] == $name) { return $venue['venueimage']; }
	}
}

function getData($filename) {
$data = json_decode(file_get_contents($filename),true);
return $data;	
}

function showHighlight($id) {
	
$highlightID=$_GET['highlight'];

$data = getHighlight($highlightID);
$highlightAddress = $data['venueaddress'];
$html = '<section style="display:flex;">';
$html .= '<div class="pageleft">';
$html .= '<img style="width:35vw;" src="'.HTML_PATH_ROOT.'/bl-content/lff-events/images/'.$data['venueimage'].'" />';
$html .= '</div>';
$html .= '<div class="pageright" style="margin-left:2.5vw;">';
$html .= '<h4>'.$data['highlightvenue'].'</h4>';
$html .= '<h4>'.$data['highlighttitle'].'</h4>';
$html .= '<h5>'.$data['highlightsubtitle'].'</h5>';
$html .= '<p>'.$data['highlightdescription'].'</p>';
if ($data['highlightoffercode']) {
	$html .= '<p>Offer Code: '.$data['highlightoffercode'].'</p>';
}
$html .= '<p><a href="https://maps.google.com/?q='.$highlightAddress.'">'.$highlightAddress.'&nbsp;<i class="fa-solid fa-location-dot"></i></a></p>';
$html .= '</div>';
$html .= '</section>';
echo '<br><br>';
echo $html;
}

function showVenue($name) {
	$venueID = $_GET['venue'];
	$data=getVenue($venueID);
	echo '<br><br>';
	$html = '<section style="display:flex;">';
	$html .= '<div class="pageleft">';
	$html .= '<img style="width:35vw; view-transition-name:venueimage'.$data['venueid'].'" src="'.HTML_PATH_ROOT.'/bl-content/lff-events/images/'.$data['venueimage'].'" />';
	$html .= '</div>';
	$html .= '<div class="pageright" style="margin-left:2.5vw;">';
	$html .= '<h4>'.$data['venuename'].'</h4>';
	$html .= '<p>'.$data['venuedescription'].'</p>';    https://maps.google.com/?q=24-32%20Bridge%20End,%20Leeds%20LS1%204DJ
	$html .= '<p><a href="https://maps.google.com/?q='.$data['venueaddress'].'">'.$data['venueaddress'].'&nbsp;<i class="fa-solid fa-location-dot"></i></a></p>';
	$html .= '<div class="linkbox"><ul class="sociallinkies" style="width:100%; display:flex; flex-wrap:nowrap; font-size:1.5em;">';
	if($data['venuefacebook']) $html .= '<li class="sociallinky" style="margin-right:.5em;"><a href="'.$data['venuefacebook'].'"><i class="fa-brands fa-facebook"></i></a></li>';
	if($data['venueinstagram']) $html .= '<li class="sociallinky" style="margin-right:.5em;"><a href="'.$data['venueinstagram'].'"><i class="fa-brands fa-instagram"></i></a></li>';
	if($data['venuewebsite']) $html .= '<li class="sociallinky" style="margin-right:.5em;"><a href="'.$data['venuewebsite'].'"><i class="fa-solid fa-link"></i></a></li>';
	$html .= '</ul></div>';
	$html .= '</div>';
	$html .= '</section>';
	echo $html;
}

function showEvent($id) {
	$eventID = $_GET['event'];
	//$event=findEvent($eventID);
	$data=getEvent($eventID);
	$eventAddress = $data['venueaddress'];
	$html = '<section style="display:flex;">';
	$html .= '<div class="pageleft">';
	$html .= '<img style="width:35vw; view-transition-name: eventimage'.$data['eventid'].';"src="'.HTML_PATH_ROOT.'/bl-content/lff-events/images/'.$data['eventimage'].'" />';
	$html .= '</div>';
	$html .= '<div class="pageright slideinR fadeIn" style="margin-left:2.5vw;">';
	$html .= '<h4>'.$data['eventtitle'].'</h4>';
	$html .= '<h4>'. date("l jS F Y g:i a",strtotime($data['eventstart'])).'</h4>';
	$html .= '<h5>'.$data['eventsubtitle'].'</h5>';
	$html .= '<p>'.$data['eventdescription'].'</p>';
	//$html .= '<a href="'.$data['eventctaurl'].'">'.$data['eventctatext'].'</a>';
	$html .= '<p>'.$data['eventvenue'].'</p>';
	$html .= '<p><a href="https://maps.google.com/?q='.$eventAddress.'">'.$eventAddress.'&nbsp;<i class="fa-solid fa-location-dot"></i></a></p>';
	$html .= '</div>';
	$html .= '</section>';
	echo '<br><br>';
	echo $html;
}

switch (key($_GET)) {
	case 'highlight':
		showHighlight($_GET['highlight']);
		break;
	
	case 'venue':
		showVenue($_GET['venue']);
		break;

	case 'event':
		showEvent($_GET['event']);
		break;
}
?>
