<?php
session_start();
?>
<!doctype html>
<html lang='en'>
<?php include 'header.php';?>
<link rel='stylesheet' href='../css/user_lease.css'>
<body class='animation-background'>
<canvas id="canvas"></canvas>
	<?php
        $username = $_SESSION['username'];

        $ch = curl_init('https://lunar-living.herokuapp.com/getReviews');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            "rating: 5",
        ));
        $data = curl_exec($ch);
        $info = curl_getinfo($ch);
        $fiveStar = json_decode($data)->total;
        curl_close($ch);

        $ch = curl_init('https://lunar-living.herokuapp.com/getReviews');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            "rating: 4",
        ));
        $data = curl_exec($ch);
        $info = curl_getinfo($ch);
        $fourStar = json_decode($data)->total;
        curl_close($ch);

        $ch = curl_init('https://lunar-living.herokuapp.com/getReviews');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            "rating: 3",
        ));
        $data = curl_exec($ch);
        $info = curl_getinfo($ch);
        $threeStar = json_decode($data)->total;
        curl_close($ch);

        $ch = curl_init('https://lunar-living.herokuapp.com/getReviews');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            "rating: 2",
        ));
        $data = curl_exec($ch);
        $info = curl_getinfo($ch);
        $twoStar = json_decode($data)->total;
        curl_close($ch);

        $ch = curl_init('https://lunar-living.herokuapp.com/getReviews');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            "rating: 1",
        ));
        $data = curl_exec($ch);
        $info = curl_getinfo($ch);
        $oneStar = json_decode($data)->total;
        curl_close($ch);
    ?>
	<main class = 'content_body'>
	<div class='container-fluid padding-zero'>
        <?php include 'signInNavbar.php';?>
	</div>
	<div class='container-fluid userlease_container'>
		<div class='row'>
			<div class='col-sm-3'>
				<div class='wrapper'>
					<aside class='main_sidebar'>
						<ul>
                        <li><a href='profile.php'>Profile</a></li>
							<?php
                            if ($_SESSION["usertype"] == 1) {
                                echo "<li><a href='user_lease.php'>Lease</a></li>
                                        <li><a href='payment.php'>Payment</a></li>";
                            }
                            if ($_SESSION["usertype"] == 2) {
                                echo "<li><a href='newlease.php'>New Lease</a></li>";
                                echo "<li><a href='allLogin.php'>All Users</a></li>";
                                echo "<li><a href='allLease.php'>All Leases</a></li>";
                                echo "<li><a href='appointments.php'>All Appointments</a></li>";
                                echo "<li><a href='allpromocodes.php'>All Promo Codes</a></li>";
                            }
                            if ($_SESSION["usertype"] == 2) {
                                echo "<li><a href='adminchat.php'>Chats</a></li>";
                            }
                            ?>
                            <li><a href='ticketStatus.php'>Tickets</a></li>
                            <?php
                            if($_SESSION["usertype"] != 1){
                                echo "<li><a href='map.php'>Ticket Map</a></li>";
                            }
                            ?>
							<li><a href='events.php'>Events</a></li>
							<li><a href='laundry.php'>Laundry</a></li>
							<li class='active'><a href='review.php'>Review</a></li>
							<?php
                            if ($_SESSION["usertype"] == 2) {
                                echo "<li>
									<a onclick='displayStats()' href='#'>Stats</a>
									<ul id='statsChilds' class= 'statsChilds'>
										<li><a href='paymentstats.php'>Payment Stats</a></li>
										<li><a href='ticketstats.php'>Ticket Area Stats</a></li>
										<li><a href='ticketstatsstatus.php'>Ticket Status Stats</a></li>
									</ul>
								</li>";
                            }
                            ?>
						</ul>
					</aside>
				</div>
			</div>
			<div class='col-sm-9 side-col'>
                <div class="container">
                <span data-shadow-text="Text-Shadow" class = 'user_lease_info'>Review Us</span><br><br>
                <div class = 'rating-section right-space'>
                    <fieldset class="rating">
                        <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                        <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                        <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                        <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                    </fieldset><br><br><br>
                </div>
                <button class='btn btn-info btn-md' onclick='rateMe()'>Submit Review</button>
                <br>
                <div class='user-review'>
                    <?php
                    $totalVotes = $fiveStar + $fourStar + $threeStar + $twoStar + $oneStar;
                    $sum = 5 * $fiveStar + 4 * $fourStar + 3 * $threeStar + 2 * $twoStar + $oneStar;
                    if ($totalVotes == 0) {
                        $avg = 0;
                        $fiveWidth = 0;
                        $fourWidth = 0;
                        $threeWidth = 0;
                        $twoWidth = 0;
                        $oneWidth = 0;
                    } else {
                        $avg = $sum / $totalVotes;
                        $fiveWidth = ($fiveStar / $totalVotes) * 100;
                        $fourWidth = ($fourStar / $totalVotes) * 100;
                        $threeWidth = ($threeStar / $totalVotes) * 100;
                        $twoWidth = ($twoStar / $totalVotes) * 100;
                        $oneWidth = ($oneStar / $totalVotes) * 100;
                    }
                    echo "
                    <span class='heading'>User Rating &nbsp</span>";
                    if ($avg >= 1) {
                        echo "<span class='fa fa-star checked'></span>";
                    } else {
                        echo "<span class='fa fa-star'></span>";
                    }
                    if ($avg >= 2) {
                        echo "<span class='fa fa-star checked'></span>";
                    } else {
                        echo "<span class='fa fa-star'></span>";
                    }
                    if ($avg >= 3) {
                        echo "<span class='fa fa-star checked'></span>";
                    } else {
                        echo "<span class='fa fa-star'></span>";
                    }
                    if ($avg >= 4) {
                        echo "<span class='fa fa-star checked'></span>";
                    } else {
                        echo "<span class='fa fa-star'></span>";
                    }
                    if ($avg >= 5) {
                        echo "<span class='fa fa-star checked'></span>";
                    } else {
                        echo "<span class='fa fa-star'></span>";
                    }
                    echo "
                    <p>" . $avg . " average based on " . $totalVotes . " reviews.</p>
                    <hr style='border:3px solid #f1f1f1'>
                    <div class='row'>
                    <div class='side'>
                        <div>5 star</div>
                    </div>
                    <div class='middle'>
                        <div class='bar-container'>
                        <div class='bar-5' style='width:" . $fiveWidth . "%;'></div>
                        </div>
                    </div>
                    <div class='side right'>
                        <div>" . $fiveStar . "</div>
                    </div>
                    <div class='side'>
                        <div>4 star</div>
                    </div>
                    <div class='middle'>
                        <div class='bar-container'>
                        <div class='bar-4' style='width:" . $fourWidth . "%;'></div>
                        </div>
                    </div>
                    <div class='side right'>
                        <div>" . $fourStar . "</div>
                    </div>
                    <div class='side'>
                        <div>3 star</div>
                    </div>
                    <div class='middle'>
                        <div class='bar-container'>
                        <div class='bar-3' style='width:" . $threeWidth . "%;'></div>
                        </div>
                    </div>
                    <div class='side right'>
                        <div>" . $threeStar . "</div>
                    </div>
                    <div class='side'>
                        <div>2 star</div>
                    </div>
                    <div class='middle'>
                        <div class='bar-container'>
                        <div class='bar-2' style='width:" . $twoWidth . "%;'></div>
                        </div>
                    </div>
                    <div class='side right'>
                        <div>" . $twoStar . "</div>
                    </div>
                    <div class='side'>
                        <div>1 star</div>
                    </div>
                    <div class='middle'>
                        <div class='bar-container'>
                        <div class='bar-1' style='width:" . $oneWidth . "%;'></div>
                        </div>
                    </div>
                    <div class='side right'>
                        <div>" . $oneStar . "</div>
                    </div>";
                    ?>
                </div>
                </div>
			</div>
		</div>
	</div>
    <?php include 'footer.php';?>
	</main>

	<!-- postJS -->
    <script src='../js/jquery-3.3.1.js'></script>		<!-- Jquery JS (necessary for dropdowns) -->
    <script src='../js/bootstrap.bundle.min.js'></script>		<!-- Bootstrap Bundle JS (necessary for dropdowns) -->
    <!-- <script src='js/bootstrap.min.js'></script> -->		<!-- Bootstrap JS � disabled because when enabled it has a conflict with Bootstrap Bundle JS that makes dropdowns require two clicks to dropdown; it doesn't seem that any needed functionality is lacking when this is disabled -->
    <script>
        function rateMe(){
            var starValue = $("input[name='rating']:checked").val();
            window.location.href = 'submitreview.php?rating=' + starValue;
        }
        function displayStats(){
			var statsChilds = document.getElementById("statsChilds");
			if(statsChilds.style.display == "none"){
				statsChilds.style.display = "block";
			}
			else{
				statsChilds.style.display = "none";
			}
		}
    </script>
    <script>
		function fn() {
			window.requestAnimFrame = (function () {
				return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || function (callback) {
							window.setTimeout(callback, 1000 / 60);
						}
			})();
			var canvas = document.getElementById('canvas'), ctx = canvas.getContext('2d'), w = canvas.width = window.innerWidth, h = canvas.height = window.innerHeight, hue = 217, stars = [], count = 0, maxStars = 1200;
			var canvas2 = document.createElement('canvas'), ctx2 = canvas2.getContext('2d');
			canvas2.width = 100;
			canvas2.height = 100;
			var half = canvas2.width / 2, gradient2 = ctx2.createRadialGradient(half, half, 0, half, half, half);
			gradient2.addColorStop(0.025, '#fff');
			gradient2.addColorStop(0.1, 'hsl(' + hue + ', 61%, 33%)');
			gradient2.addColorStop(0.25, 'hsl(' + hue + ', 64%, 6%)');
			gradient2.addColorStop(1, 'transparent');
			ctx2.fillStyle = gradient2;
			ctx2.beginPath();
			ctx2.arc(half, half, half, 0, Math.PI * 2);
			ctx2.fill();
			function random(min, max) {
				if (arguments.length < 2) {
					max = min;
					min = 0
				}
				if (min > max) {
					var hold = max;
					max = min;
					min = hold
				}
				return Math.floor(Math.random() * (max - min + 1)) + min
			}

			function maxOrbit(x, y) {
				var max = Math.max(x, y), diameter = Math.round(Math.sqrt(max * max + max * max));
				return diameter / 2
			}

			var Star = function () {
				this.orbitRadius = random(maxOrbit(w, h));
				this.radius = random(60, this.orbitRadius) / 12;
				this.orbitX = w / 2;
				this.orbitY = h / 2;
				this.timePassed = random(0, maxStars);
				this.speed = random(this.orbitRadius) / 900000;
				this.alpha = random(2, 10) / 10;
				count++;
				stars[count] = this
			};
			Star.prototype.draw = function () {
				var x = Math.sin(this.timePassed) * this.orbitRadius + this.orbitX, y = Math.cos(this.timePassed) * this.orbitRadius + this.orbitY, twinkle = random(10);
				if (twinkle === 1 && this.alpha > 0) {
					this.alpha -= 0.05
				} else if (twinkle === 2 && this.alpha < 1) {
					this.alpha += 0.05
				}
				ctx.globalAlpha = this.alpha;
				ctx.drawImage(canvas2, x - this.radius / 2, y - this.radius / 2, this.radius, this.radius);
				this.timePassed += this.speed
			};
			for (var i = 0; i < maxStars; i++) {
				new Star()
			}
			function animation() {
				ctx.globalCompositeOperation = 'source-over';
				ctx.globalAlpha = 0.8;
				ctx.fillStyle = 'hsla(' + hue + ', 64%, 6%, 1)';
				ctx.fillRect(0, 0, w, h);
				ctx.globalCompositeOperation = 'lighter';
				for (var i = 1, l = stars.length; i < l; i++) {
					stars[i].draw()
				}
				;
				window.requestAnimationFrame(animation)
			}

			animation();
		}
		fn();
	</script>
</body>
</html>