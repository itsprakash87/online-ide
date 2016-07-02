<?php
	// Compile Python program
	$myfile = fopen("programs/python/testfile_python.py", "w");
	$input =  fopen("programs/python/input_python.txt", "w");
	$txt = $_POST['program'];
	$_SESSION['python_program'] = $txt;
	fwrite($myfile, $txt);

	$inputTxt = $_POST['input'];
	fwrite($input, $inputTxt);

	$compile = exec('python programs/python/testfile_python.py < programs/python/input_python.txt 2>&1',$ar,$exit_status);
	$str = "";
	if($exit_status == 0){
		// if compiled successfully, save output.
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