<!-- -- contributed by:
	-- Name: Ishan Bhatia
	-- Banner Number: B00835259
	-- Implemented the front end layout for the main feed and the micro-blogs  -->

<?php

	session_start();
	require_once "includes/header.php";
	require_once "includes/db.php";

?>

<main class="main-page-body">

<div class="container">
	<div class="row row-content">

		<!-- 
				-- contributed by:
				-- Name: Dhairy Raval
				-- Banner Number: B00845519
				-- Implemented the functionality to see the tweets and retweets from the people you follow 
				-- User Story: 4

				-- Name: Arjun Banga
				-- Banner Number: B00852696
				--  Implemented the functionality to display a list of all the users that follow the active user
				-- User Story: 7

				-- Name: Miftahul Kashfy
				-- Banner Number: B00850212
				-- Implemented the functionality to search the tweets and retweets based on person's name or twitter handle 
				-- Implemented the functionality of posting a tweet
				-- User Story: 5
				-- User Story: 8

			-->


		<div class="col-md-2 left-col-content">
			<div class="upper-content text-center">	
				<img src="https://images.pexels.com/photos/1081685/pexels-photo-1081685.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260" alt="">
				<h5 class="text-center pt-3">
					<?php
						echo $_SESSION['firstname'] . " " . $_SESSION['lastname'];
					?>
				</h5>
				<p class="text-muted text-center">
					@<?php
						echo $_SESSION['handle'];
					?>
				</p>

				<hr>

				<div class="text-center">
					<a href="" class="font-weight-bold text-decoration-none text-center">
						Visit My Profile
					</a>
				</div>

				<hr>
				
			</div>

			<div class="left-list">
				<h3 class="text-center">Quick Links</h3>
				
				<ul class="list-group list-group-flush">
				  <li class="list-group-item"><a href="#" class="text-decoration-none text-dark">Friends</a></li>
				  <li class="list-group-item"><a href="#" class="text-decoration-none text-dark">Groups</a></li>
				  <li class="list-group-item"><a href="#" class="text-decoration-none text-dark">Events</a></li>
				  <li class="list-group-item"><a href="#" class="text-decoration-none text-dark">Saved</a></li>
				  <li class="list-group-item"><a href="#" class="text-decoration-none text-dark">See More</a></li>
				</ul>
			</div>


		</div>


		<div class="col-md-7 scroll-overflow">
			<?php
			/*
				This code to implement posting a tweet and showing appropriate message
				modification from my submission for Assignment 3 in CSCI 2170 (Winter 2021).
					
				Miftahul Kashfy Assignment 3: CSCI 2170 (Winter 2021), Faculty of Computer Science,
				Dalhousie University. Available online on Gitlab at [URL]:
				https://git.cs.dal.ca/courses/2021-winter/csci-2170/a3/kashfy
				Date accessed: April 1st 2021
			*/
				// if post is posted successfully, give a message to the user, that it was posted successfully
				if (isset($_GET['tweep-success'])) {
					echo "<h4 style='color:MediumSlateBlue; padding: 10px 50px;'>Your tweep was posted successfully!<br></h4>";
				}
			?>


			<div class="mainfeedcenter">


				<div class="d-flex justify-content-around">
					<div class="uploadSection">
						
						<a href="#" class="text-dark text-decoration-none"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> &nbsp; Write a tweep</a>
					</div>

					<div class="uploadSection">
						
						<a href="#" class="text-dark text-decoration-none"><i class="fa fa-long-arrow-up" aria-hidden="true"></i> &nbsp; Upload a photo</a>
					</div>


					<div class="uploadSection">
						
						<a href="#" class="text-dark text-decoration-none"><i class="fa fa-book" aria-hidden="true"></i>&nbsp;  Share</a>
					</div>
				</div>

				<hr>
				<form method="post" action="includes/process-tweep.php">
				    <textarea name="tweepText" id="" cols="3" rows="3" class="form-control" placeholder="Write A Tweep...." ></textarea>
				    <input class="btn btn-primary post-button" value = "Submit" type="submit" name="">
			    </form>

			</div>

			<div class="main-post-container" id = "posts">

			<!-- 
				-- contributed by:
				-- Name: Dhairy Raval
				-- Banner Number: B00845519
				-- Implemented the functionality to see the tweets and retweets from the people you follow 
				-- User Story: 4

				-- Name: Miftahul Kashfy
				-- Banner Number: B00850212
				-- Implemented the functionality to search the tweets and retweets based on person's name or twitter handle 
				-- Implemented the functionality of posting a tweet
				-- User Story: 5
				-- User Story: 8

				-- contributed by:
				-- Name: Arjun Banga
				-- Banner Number: B00852696
				-- Modified the query and html created above to include retweets. 
				-- User Story: 4
			-->

			
	        <?php 
	        /*
				Searching tweets based on person's name or twitter handle
				modification from my submission for Assignment 3 in CSCI 2170 (Winter 2021).
					
				Miftahul Kashfy Assignment 3: CSCI 2170 (Winter 2021), Faculty of Computer Science,
				Dalhousie University. Available online on Gitlab at [URL]:
				https://git.cs.dal.ca/courses/2021-winter/csci-2170/a3/kashfy 
				Date accessed: April 1st 2021
			*/
	        	// Session variable for search that was set is retrieved and unset after database is searched for tweets  
	        	if (isset($_SESSION['search'])){
	        		$value = $_SESSION['search'];
	        		unset($_SESSION['search']);
					print_r($_SESSION);
	        		$querySQL = "SELECT Users.firstname, Users.lastname, Users.handle, Tweets.text, Tweets.tweet_id FROM `Users`
							JOIN `Tweets` ON `Users`.`id` = `Tweets`.`author_id`
							JOIN `Follows` ON `Users`.`id` = `Follows`.`following_id`
							WHERE Users.firstname LIKE '%{$value}%' OR Users.lastname LIKE '%{$value}%' OR Users.handle LIKE '%{$value}%'
							ORDER BY `Tweets`.`dateCreated` DESC";
					$result = $dbconnection->query($querySQL);
					$row = mysqli_num_rows($result);

					if($row > 0){
						for($i=1; $i <= $row; $i++){
						$tempData = $result->fetch_assoc();

						$heredoc = <<<END
						<div class="feedContent" id = "tweep$i">
								
						<div class="d-flex image-container">

						<div class="user-image">
							<img src="https://images.pexels.com/photos/1081685/pexels-photo-1081685.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260">
						</div>

						<div class="pl-2 pt-1">
							<h6>&nbsp; &nbsp; {$tempData['firstname']} {$tempData['lastname']} <span class = "text-muted">@{$tempData['handle']}</h6>
						</div>
											
						</div>
							<hr>
							<div class = "tweepText" style = "height:3em; overflow: hidden">
							<p class="text-muted">
									{$tempData['text']}
							</p>					
							</div>
							<hr>

							<div class="d-flex justify-content-around">
								<a href="#" class="text-dark text-decoration-none"><i class="fa fa-heart"></i> Like</a>
								<a href="#" class="text-dark text-decoration-none"><i class="fa fa-comment"></i> Comment</a>
								<a href="includes/share.php?tweet=$tempData[tweet_id]" onclick="preventOpen(event)" class="text-dark text-decoration-none"><i class="fa fa-share"></i>Share</a>
							</div>
						</div>	

						END;

						//if user found
						echo $heredoc;
						}

					}else{
						//if user not found
						echo "<h4 style='color:DarkSlateBlue;'>Sorry, no tweeps found based on your searched user. <br><br> Try searching with another user!</h4>";
					}
				}else{
					
				//Modify the query to join with retweet query instead of tweets to include retweets in the result
	        	$querySQL = "SELECT Users.firstname AS rt_firstname, Follows.following_id, Users.lastname as rt_lastname, tt.tweet_id, tt.author_id, tt.retweeter_id, tt.firstname, tt.lastname, tt.handle, tt.text, tt.dateCreated FROM `Users`
				JOIN `Follows` ON `Users`.`id` = `Follows`.`following_id`
				RIGHT JOIN (SELECT Tweets.author_id, Tweets.tweet_id, Retweets.retweeter_id, Users.firstname, Users.lastname, Users.handle, Tweets.text, Tweets.dateCreated FROM Tweets LEFT JOIN Retweets ON Tweets.tweet_id = Retweets.tweet_id JOIN Users ON Tweets.author_id = Users.id) tt ON  `Users`.`id` = tt.`author_id` OR Users.id = tt.retweeter_id
				WHERE Follows.follower_id = ".$_SESSION['userid']."
				ORDER BY tt.`dateCreated` DESC";
				$result = $dbconnection->query($querySQL);
				$row = mysqli_num_rows($result);
				$prev;
				if($row > 0){
					for($i=1; $i <= $row; $i++){
					$tempData = $result->fetch_assoc();
					$rtmessage;
					//Add the retweeter message if it is retweeted
					if($prev != $tempData && $tempData['retweeter_id'] == $tempData['following_id']) {
						$rtmessage = "<span class = 'text-muted pl-2 pt-1'><i class='fa fa-share' aria-hidden='true'></i> $tempData[rt_firstname] $tempData[rt_lastname]</span>";
					}
					else if($tempData['author_id'] == $tempData['following_id'] && $prev['tweet_id'] != $tempData['tweet_id']) {
						$rtmessage = null;
					}
					else {
						continue;
					}
					$prev = $tempData;
					$heredoc = <<<END
						<div class="feedContent w-100" id = "tweep$i">
						<div class="d-flex flex-row justify-content-between">
						<div class="d-flex flex-fill image-container">
						<div class="user-image">
							<img src="https://images.pexels.com/photos/1081685/pexels-photo-1081685.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260">
						</div>
						<div class="flex-fill pl-2 pt-1">
							<h6>&nbsp; &nbsp; {$tempData['firstname']} {$tempData['lastname']} <span class = "text-muted">@{$tempData['handle']}</span></h6>
						</div>
						$rtmessage
						</div>
						</div>
							<hr>
							<div class = "tweepText" style = "height:3em; overflow: hidden">
							<p class="text-muted">
									{$tempData['text']}
							</p>					
							</div>
							<hr>
							<div class="d-flex justify-content-around">
								<a href="#" class="text-dark text-decoration-none"><i class="fa fa-heart"></i> Like</a>
								<a href="#" class="text-dark text-decoration-none"><i class="fa fa-comment"></i> Comment</a>
								<a href="includes/share.php?tweet=$tempData[tweet_id]" onclick="preventOpen(event)" class="text-dark text-decoration-none"><i class="fa fa-share"></i>Share</a>
							</div>
						</div>
						END;

						echo $heredoc;

						}
					}
					else{
						echo "<div class = 'px-3'><h3>Not following anyone yet?<br><br> What are you waiting for?<br> Follow other people to look at their tweets!</h3></div>";
					}

				}
			?>

			</div>




		</div>		<!-- mid column content closed-->


		<div class="col-md-3">
			<div class="left-section">
				<div class="right-list">
					<h3 class="text-center">Your Followers</h3>
					<ul class="list-group list-group-flush ">
			<!-- 
				-- contributed by:
				-- Name: Arjun Banga
				-- Banner Number: B00852696
				--  Implemented the functionality to display a list of all the users that follow the active user
				-- User Story: 7
			-->
			<?php
				$sql = "SELECT Users.handle, Users.firstname, Users.lastname FROM Follows JOIN Users ON Follows.follower_id = Users.id
				WHERE Follows.following_id = ".$_SESSION['userid']."
				ORDER BY Follows.dateFollowed DESC";
				$result = $dbconnection->query($sql);
				$row = mysqli_num_rows($result);
				if($row>0) {
					for($i=1; $i <= $row; $i++){
						$res = $result->fetch_assoc();
						$hdoc = <<<END
								<li class="list-group-item"><a href="#" class="text-decoration-none text-dark">{$res['firstname']} {$res['lastname']} <span class = "text-muted">@{$res['handle']}</span></a></li>
						END;
						echo $hdoc;
					}
				}
				else {
					echo "<div class = 'text-muted text-center'>You have no followers.</div";
				}

			?>
					  </ul>
				</div>
			


				<!-- follower list ends here -->

			</div>


			<div class="left-section mt-3">
		        <div class="right-list-2">
					<h3 class="text-center">Sponsored</h3>
					
					<ul class="list-group list-group-flush ">
					  <li class="list-group-item"><a href="#" class="text-decoration-none text-dark">Sponsor Link</a></li>
					  <li class="list-group-item"><a href="#" class="text-decoration-none text-dark">Sponsor Link</a></li>
					  <li class="list-group-item"><a href="#" class="text-decoration-none text-dark">Sponsor Link</a></li>
					  <li class="list-group-item"><a href="#" class="text-decoration-none text-dark">Sponsor Link</a></li>
					  <li class="list-group-item"><a href="#" class="text-decoration-none text-dark">Sponsor Link</a></li>
					</ul>
					
				</div>
		    </div>

		</div>




	</div>
</div>

</main>
<script type="text/javascript" src="js/tweepExpand.js"></script>
<?php 
	require_once "includes/footer.php";
	
?>
