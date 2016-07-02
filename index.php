<?php 

session_start();
$str = "";
$exit_status = -1;
if(isset($_SESSION['changed']) && ($_SESSION['changed'] == true)){
	unset($_SESSION['changed']);
}

else{
	// Include the compiler script according to the selected language.
	if(isset($_POST['compile'])){

		if(isset($_POST['language'])){
			if($_POST['language'] == "c"){
				include_once('compilers/compiler_c.php');
			}

			else if($_POST['language'] == "cpp"){
				include_once('compilers/compiler_cpp.php');
			}

			else if($_POST['language'] == "java"){
				include_once('compilers/compiler_java.php');
			}

			else if($_POST['language'] == "python"){
				include_once('compilers/compiler_python.php');
			}
		}
		unset($_POST['compile']);
	}
}

?>

<html>
<head>
	<title>All in one compiler</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Include script and styles for the code editor and web page. -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="codemirror/lib/codemirror.css">
	<link rel="stylesheet" href="codemirror/addon/fold/foldgutter.css">
	<link rel="stylesheet" href="codemirror/addon/dialog/dialog.css">
	<link rel="stylesheet" href="codemirror/theme/monokai.css">
	<link rel="stylesheet" href="codemirror/theme/twilight.css">
	<script src="codemirror/lib/codemirror.js"></script>
	<script src="codemirror/addon/selection/active-line.js"></script>

	<script src="codemirror/addon/search/searchcursor.js"></script>
	<script src="codemirror/addon/search/search.js"></script>
	<script src="codemirror/addon/dialog/dialog.js"></script>
	<script src="codemirror/addon/edit/matchbrackets.js"></script>
	<script src="codemirror/addon/edit/closebrackets.js"></script>
	<script src="codemirror/addon/comment/comment.js"></script>
	<script src="codemirror/addon/wrap/hardwrap.js"></script>
	<script src="codemirror/addon/fold/foldcode.js"></script>
	<script src="codemirror/addon/fold/brace-fold.js"></script>
	<script src="codemirror/mode/clike/clike.js"></script>
	<script src="codemirror/mode/python/python.js"></script>
	<script src="codemirror/mode/javascript/javascript.js"></script>
	<script src="codemirror/keymap/sublime.js"></script>
	

	<style type="text/css">
      .CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black;height: 95%;}
      header{text-align: center;}
      .side-content{	padding: 10px 5px;}
    </style>

	<!-- Use ajax to change the language on language option change. -->
	<script type="text/javascript">
		
		function changeLanguage() {
		  var str = document.getElementById("language").value;
		  var xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
		    if (xhttp.readyState == 4 && xhttp.status == 200) {
		    	window.location.reload(true); 
		    }
		  };
		  xhttp.open("POST", "ajax/change_language.php?q="+str, true);
		  xhttp.send();
		}
	</script>
</head>
<body>
	<div class="container-fluid">

		<header>
			<div class="well"><h2>All in one Compiler</h2></div>
		</header>
		<div class="result">
		<?php
			// if compiled successfully, show output.
			if($exit_status == 0){ ?>
			<div class="panel panel-success">
				<div class="panel-heading">
					<h5>Output</h5>
				</div>
				<div class="panel-body">
					<?php echo $str; ?>
				</div>
			</div>
		<?php } ?>
		<?php
			// if there is any error, show error.
			if($exit_status == 1){ ?>
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h5>Error</h5>
				</div>
				<div class="panel-body">
					<?php echo $str; ?>
				</div>
			</div>
		<?php } ?>
		</div>

		<div class="main-content">
			<form action="index.php" method="post" role="form">
			
				<div class="row">
					<div class="col-sm-9">
						<?php
						if (isset($_SESSION['selected_language']) && $_SESSION['selected_language'] == "java"){
									echo "Public class name should be 'testfile_java'";
							}
						?>
					<textarea rows="40" cols="170" name="program" class="program" id="code"><?php 
						if(isset($_SESSION['selected_language'])){
							// Load the last compiled program, if any, of the selected language.
							if(isset($_SESSION['c_program']) && ($_SESSION['selected_language'] == "c")){
								echo $_SESSION['c_program'];
							}
							else if(isset($_SESSION['cpp_program']) && ($_SESSION['selected_language'] == "cpp")){
								echo $_SESSION['cpp_program'];
							}
							else if(isset($_SESSION['java_program']) && ($_SESSION['selected_language'] == "java")){
								echo $_SESSION['java_program'];
							}
							else if(isset($_SESSION['python_program']) && ($_SESSION['selected_language'] == "python")){
								echo $_SESSION['python_program'];
							}
							else{
								echo "";
							}
						}
						else{
							$_SESSION['selected_language'] = "c";
							echo "";
						}
						
						?></textarea>
					</div>
			

					<div class="col-sm-3 side-content">
						<div class="form-group">
							<select name="language" onchange="changeLanguage()" id="language" class="form-control">
								<?php if(!isset($_SESSION['selected_language']) || $_SESSION['selected_language'] == "c"){?>
									<option value="c" selected> C </option>
									<option value="cpp"> C++ </option>
									<option value="java"> Java </option>
									<option value="python"> Python </option>
								<?php } ?>
								<?php if($_SESSION['selected_language'] == "cpp"){?>
									<option value="c"> C </option>
									<option value="cpp" selected> C++ </option>
									<option value="java"> Java </option>
									<option value="python"> Python </option>
								<?php } ?>
								<?php if($_SESSION['selected_language'] == "java"){?>
									<option value="c"> C </option>
									<option value="cpp"> C++ </option>
									<option value="java" selected> Java </option>
									<option value="python"> Python </option>
								<?php } ?>
								<?php if($_SESSION['selected_language'] == "python"){?>
									<option value="c"> C </option>
									<option value="cpp"> C++ </option>
									<option value="java"> Java </option>
									<option value="python" selected> Python </option>
								<?php } ?>
							</select>
						</div>

						<div class="form-group">
							<!-- Text box for standard  input. -->
							<h2>Input</h2>
							<textarea rows="5" cols="70" name="input" class="form-control"></textarea><br />
						</div>
						
						<div class="form-group">
							<input class="btn btn-primary" type="submit" value="Compile And Run" name="compile">
						</div>
					</div>
				</div>
			</form>
		</div>	
	</div>



	<script>
		// Script for the editor.
		var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
		    styleActiveLine: true,
		    lineNumbers: true,
		    lineWrapping: true,
		    <?php if(($_SESSION['selected_language'] == "c")){
		    	echo "mode: 'text/x-csrc',";
		     }?>
		    <?php if(($_SESSION['selected_language'] == "cpp")){
		    	echo "mode: 'text/x-c++src',";
		     }?>
		    <?php if(($_SESSION['selected_language'] == "java")){
		    	echo "mode: 'text/x-java',";
		     }?>
		     <?php if(($_SESSION['selected_language'] == "python")){
		    	echo "mode: {name: 'text/x-cython',
               				version: 2,
               				singleLineStringErrors: false},";
		     }?>
		    keyMap: "sublime",
		    autoCloseBrackets: true,
		    matchBrackets: true,
		    showCursorWhenSelecting: true,
		    theme: "twilight",
		    tabSize: 2
		  });
	</script>


</body>
</html>