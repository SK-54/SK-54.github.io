<?php
error_reporting(E_ALL);

$ReadJsonFile = json_decode(file_get_contents('random.json'),true);

# FIRST if
# get new name
if(isset($_POST['AddName']) and !empty($_POST['AddName'])){
	$AddName = $_POST['AddName'];
	
	if(!in_array($AddName, $ReadJsonFile['name'])){
		$ReadJsonFile['name'][] = $AddName;
		file_put_contents("random.json", json_encode($ReadJsonFile, 448));
		echo $AddName . ' added in name list';
	}else{
		echo 'this name already exists in name list';
	}
}

#~~~~~~~~~~~~~~~~~~~~~

# get new bio
elseif(isset($_POST['AddBio']) and !empty($_POST['AddBio'])){
	$AddBio = $_POST['AddBio'];
	
	if(!in_array($AddBio, $ReadJsonFile['bio'])){
		$ReadJsonFile['bio'][] = $AddBio;
		file_put_contents("random.json", json_encode($ReadJsonFile, 448));
		echo $AddBio . ' added in bio list';
	}else{
		echo 'this bio already exists in bio list';
	}
}

#~~~~~~~~~~~~~~~~~~~~~

elseif(isset($_POST['DelName']) and !empty($_POST['DelName']) ){
	$DelName = $_POST['DelName'];
	if(in_array($DelName, $ReadJsonFile['name'])){
		$search = array_search($DelName, $ReadJsonFile['name']);
		unset($ReadJsonFile['name'][$search]);
		file_put_contents("random.json", json_encode($ReadJsonFile, 448));
		echo $DelName . ' deleted from name list';
	}else{
		echo $DelName . ' does not exists in name list';
	}
}

#~~~~~~~~~~~~~~~~~~~~~

elseif(isset($_POST['DelBio']) and !empty($_POST['DelBio']) ){
	$DelBio = $_POST['DelBio'];
	if(in_array($DelBio, $ReadJsonFile['bio'])){
		$search = array_search($DelBio, $ReadJsonFile['bio']);
		unset($ReadJsonFile['bio'][$search]);
		file_put_contents("random.json", json_encode($ReadJsonFile, 448));
		echo $DelBio . ' deleted from bio list';
	}else{
		echo $DelBio . ' does not exists in bio list';
	}

}else{ # FIRST if ELSE
	header('location: https://EviLHosT.org');
}


/*
# get random text from array
	$a = $ReadJsonFile['bio'][array_rand($ReadJsonFile['bio'])];
	echo $a;
*/


?>