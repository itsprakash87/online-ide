<?php
	// Compile Java program
	$myfile = fopen("programs/java/testfile_java.java", "w");
	$input =  fopen("programs/java/input_java.txt", "w");
	$txt = $_POST['program'];
	$_SESSION['java_program'] = $txt;
	fwrite($myfile, $txt);

	$inputTxt = $_POST['input'];
	fwrite($input, $inputTxt);

	$compile = exec('javac programs/java/testfile_java.java 2>&1',$ar,$exit_status);
	$str = "";
	if($exit_status == 0){
		// if compiled successfully, save output.
		exec('java -cp programs/java/ testfile_java < programs/java/input_java.txt',$ar);

		foreach($ar as $ars){
			$str = $str."".$ars."<br />";
		}
	}
	else if($exit_status == 1){
		// if there is any error, save error.
		$str = $str."".$compile;
		foreach($ar as $ars){
			$str = $str."".$ars."<br />";
		}
	}


?>