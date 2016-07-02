<?php
	// Compile C++ program
	$myfile = fopen("programs/cpp/testfile_cpp.cpp", "w");
	$input =  fopen("programs/cpp/input_cpp.txt", "w");
	$txt = $_POST['program'];
	$_SESSION['cpp_program'] = $txt;
	fwrite($myfile, $txt);

	$inputTxt = $_POST['input'];
	fwrite($input, $inputTxt);

	$compile = exec('g++ programs\cpp\testfile_cpp.cpp -o programs\cpp\output_cpp 2>&1',$ar,$exit_status);
	$str = "";
	if($exit_status == 0){
	// if compiled successfully, save output.
		exec('programs\cpp\output_cpp.exe < programs\cpp\input_cpp.txt',$ar);

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