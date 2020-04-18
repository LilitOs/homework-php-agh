<?php
session_start();
$_SESSION['url'];
$tab = array();
$_SESSION['keywords'];
array_merge($_SESSION['keywords'], $tab);

function array_count_values_of($value, $array) {
    $counts = array_count_values($array);
    return $counts[$value];
}
?>

<html>
<head>
<title>Text manager</title>
<link rel="stylesheet" href="https://unpkg.com/mustard-ui@latest/dist/css/mustard-ui.min.css">
<meta charset="UTF-8">
</head>
<body>

<header style="height: 200px;">
<h1>Text manager</h1>
</header>
<br>
<div class="row">
    <div class="col col-sm-5">
        <div class="panel">
            <div class="panel-body">
                <form action="index.php" method="post">
					<div class="get-text">
						<h1> 1.Get text:</h1> 
						<input type="text" name="url" value="<?php if(isset($_SESSION['url'])){echo $_SESSION['url'];} ?>" placeholder="text file url">
						<input type="submit">
					</div>
					
					<div class="get-words">
						<h1>2. Find word:</h1>
						<input type="text" name="word" placeholder="Word">
						<input type="submit">
					</div>
					<?php
					if (isset($_POST['url'])) {
						$_SESSION['url'] = $_POST['url'];
						$content = file_get_contents($_SESSION['url']);
						$count = 0;
					if (isset($_POST['word'])) {
						$word = $_POST['word'];
						$words = preg_split('/\s+/', $content);
						array_push($_SESSION['keywords'], $word);
						
						echo "<div class=\"check-results\">
								<h1> 3. Check results : </h1>
							  </div>";
						foreach($_SESSION['keywords'] as $mot){
							echo $mot;
							$count = array_count_values_of($mot, $words);
							echo "<div class=\"stepper\">
									<div class=\"step\">
									  <p class=\"step-number\"> ". $count ."</p>
									  <p class =\"step-title\">Keyword : $mot</p>
									  <p></p>
									 </div>
								</div>";
						}				
					}
					?>
				<div class="get-text">
					<h1> Reset :</h1> 
					<input type="submit" name="reset" value="reset">
					<?php
					/*if(isset($_POST['reset'])){
						session_destroy();
						header('Location: index.php');
					}*/
					?>
				</div>
            </div>
        </div>
    </div>

    <div class="col col-sm-7" style="padding-left: 25px;">
        <pre><code>
            <?php
				if (isset($_POST['word'])) {
					/*for($i=0; $i<count($words); $i++){
						if($words[$i] == $word){						
							//echo substr_replace($content, "<span style=\"background-color:yellow;\">".$word."</span>;", $i, strlen($word) );
						}
					}*/
					$content = str_replace($word, "<span style=\"background-color:yellow;\">".$word."</span>;", $content);
					echo $content;
				}
				else if(!isset($_POST['word']) || $word == ""){
					echo $content;
				}
			}
			else{
				echo "Enter an url ...";
			}
			
			?>
        </code></pre>
    </div>
</div>

</body>
</html>