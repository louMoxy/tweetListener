<?php
	echo '<form method="GET">
		<input type="text" name="username">
		<input type="submit" value="Go!">
	</form>';
	$username =$_GET["username"];
	if (isset($username)) {
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

	    if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
	    if (isset($_GET['user'])) {$user = $_GET['user'];} else {$user = "iagdotme";}
	    foreach ($string as $items) {
	    	echo "Time and Date of Tweet: ".$items['created_at']."<br />";
	        echo "Tweet: ". $items['text']."<br />";
	        echo "Tweeted by: ". $items['user']['name']."<br />";
	        echo "Screen name: ". $items['user']['screen_name']."<br />";
	        echo "Followers: ". $items['user']['followers_count']."<br />";
	        echo "Friends: ". $items['user']['friends_count']."<br />";
	        echo "Listed: ". $items['user']['listed_count']."<br />";
	    }
	}
?>