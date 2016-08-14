<?php
function clear_function() {
	$username =NULL;
}
function set_username($name) {
	$username = $name;
}

	echo "
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>
	<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
	<link rel='stylesheet' type='text/css' href='css/style.css'>
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
		<header>
			<div class='container'>
			<div id='logo'>
				<img src='img/logo.png' alt='Logo'>
				<h1>Tux Tweet Reader</h1>
			</div>
			<div id='queryBox'>
				<form method='GET'>
					<input type='text' name='username' placeholder='username'>
					<input type='submit' value='Go!'><br>
					<button onclick='clear_function()'>Clear</button>
				</form>
			</div>
			</div>
		</header>
		<div class='container'>
		";
	$username =$_GET["username"];
	if (isset($username) && $username !=NULL) {
		require_once('TwitterAPIExchange.php');
	    $settings = array(
	        'oauth_access_token' => "382297340-A0FvPn052uqUjCtxcS6LRzxPQUnQD5j8c4Ap9FRo",
	        'oauth_access_token_secret' => "BtWzGCtJQOtsJ24ChiQ75UDH8v5NqS5wrWGvyS5KKoUEP",
	        'consumer_key' => "IzK9XTDGikXcEjEUP7ZIG4ouG",
	        'consumer_secret' => "hVgSltPwCZKq41Ni0kt02URhtBoNpIiFDrQyt3OXzs4oxsgpYG"
	    );

	    $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

	    $requestMethod = "GET";

	    $getfield = '?screen_name=' .$username;
	    $getfield .= '&count=20';
	    $twitter = new TwitterAPIExchange($settings);
	    $string = json_decode($twitter->setGetfield($getfield)
	             ->buildOauth($url, $requestMethod)
	             ->performRequest(),$assoc = TRUE);

	    if($string["errors"][0]["message"] != "") {echo "<div id='whiteBox'><h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p></div>";exit();}
	    foreach ($string as $items) {
	    	echo "<div class='tweetBox'>";
	    	echo "<img src='https://twitter.com/". $username ."/profile_image?size=original' class='pic'>";
	    	echo "<p class='name'>". $items['user']['name']."</p>";
	    	echo "<p class='tweet'>".$items['created_at']."</p>";
	        echo "<p class='time'>". $items['text']."</p>";
	        echo "<p class='retweet'>". $items['retweet_count']."</p>";
	        echo "</div>";
	    }
	}
	else {
		echo "
		<div class='container'>
			<div id='whiteBox'> 
			<h3>Tux Tweet Reader will display tweets from any twiiter username just enter the name below:</h3>
			<form method='GET'>
				<input type='text' name='username'>
				<input type='submit' value='Go!'>
				</form>
			</div>
		</div>
		";
	}
	echo "</div>
	<footer>
		<div class='container'>
			<p>COPYRIGHT</p>
		</div>
	<footer>;

	"

?>