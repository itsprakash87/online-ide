<?php

	// Compile C program
	$myfile = fopen("programs/c/testfile_c.c", "w");
	$input =  fopen("programs/c/input_c.txt", "w");
	$txt = $_POST['program'];
	$_SESSION['c_program'] = $txt;
	fwrite($myfile, $txt);

	$inputTxt = $_POST['input'];
	fwrite($input, $inputTxt);

	$compile = exec('gcc programs\c\testfile_c.c -o programs\c\output_c 2>&1',$ar,$exit_status);
	$str = "";
	if($exit_status == 0){
	// if compiled successfully, save output.
		exec('programs\c\output_c.exe < programs\c\input_c.txt',$ar);
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