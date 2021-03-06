<?php
require "./logincheck.php";
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $email = $_SESSION['email'];
    ?>
    <html>
    <head>
        <link rel="shortcut icon" href="http://mentormaps.net/favicon.ico"/>
        <title>
            Mentor Maps
        </title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="stylesheet" href="assets/css/main.css"/>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery.scrollex.min.js"></script>
        <script src="assets/js/jquery.scrolly.min.js"></script>
        <script src="assets/js/skel.min.js"></script>
        <script type="text/javascript"
                src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC-e-RpEFPKNX-hDqBs--zoYYCk2vmXdZg"></script>
        <script src="assets/js/util.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <!--[if lte IE 8]>
        <script src="assets/js/ie/html5shiv.js"></script><![endif]-->
        <!--[if lte IE 8]>
        <script src="assets/js/ie/respond.min.js"></script><![endif]-->
        <!--[if lte IE 8]>
        <link rel="stylesheet" href="assets/css/ie8.css"/><![endif]-->
        <!--[if lte IE 9]>
        <link rel="stylesheet" href="assets/css/ie9.css"/><![endif]-->
    </head>
    <body class="landing">
    <div id="page-wrapper">
        <header id="header">
            <h1><a href="./index.php">Mentor Maps</a></h1>
            <nav id="nav">
                <ul>
                    <li class="special">
                        <a href="#menu" class="menuToggle">
                                        <span>
                                            Menu
                                        </span></a>

                        <div id="menu">
                            <ul>
                                <li><a href="./index.php">Home</a></li>
                                <li><a href="./logout.php">Log Out</a></li>
                                <li><a href="./profile.php">Profile</a></li>
                                <li><a href="./dashboard.php">Dashboard</a></li>
                                <li><a href="./map.php">Map</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </header>
        <script>
            var exp = 1;
            function redirect() {
                window.location = "./map.php";
            }

            function submit() {
                var experience = exp;
                var yf = document.getElementById("yes").checked;
                var email = '<?php echo $email; ?>';
                var recFriend = true;
                if (yf != true) {
                    recFriend = false;
                }
                var why = $("#why").val();
                var recFeatures = document.getElementById("recFeaturesField").value;
                var dislikedFeatures = document.getElementById("dislikedFeaturesField").value;
                var toAddFeatures = document.getElementById("toAddFeaturesField").value;

                if (recFeatures == "" || dislikedFeatures == "" || toAddFeatures == "") {
                    alert("you did not fill in a required field");
                    return;
                }

                $.ajax({
                    url: './survey.php',
                    type: 'POST',
                    data: {
                        'why': why,
                        'recFeatures': recFeatures,
                        'dislikedFeatures': dislikedFeatures,
                        'toAddFeatures': toAddFeatures,
                        'recFriend': recFriend,
                        'email': email
                    },
                    success: function (data) {
                        document.getElementById("page-section").innerHTML = "<div align=\"center\">Reponse Recorded<br/><button onclick='redirect();'>OK</button></div>";
                    }
                });
            }

            $(function () {
                $("#slider").slider({
                    min: 1,
                    max: 10,
                    change: function (event, ui) {
                        $("#slider-display").html(ui.value + " / 10");
                        exp = ui.value;
                    }
                });
            });
        </script>

        <article id="main" style="width:100%;">
            <header>
                <h2>
                    Mentor Maps Survey
                </h2>

                <h3 style="color:#c1c1c1">
                    Your answers will be collected to improve MentorMaps
                </h3>
            </header>
            <section id="page-section" class="wrapper style5" style="width:100%;">
                <div style="width:100%;text-align:center;margin:auto;padding-top:10px;padding-bottom:10px">
                    <h3>
                        Rate your experience
                    </h3>

                    <div id="slider-wrapper" style="width:50%;margin:auto;">
                        <div id="slider"></div>
                        <div id="slider-display"></div>
                    </div>
                    <script>
                        $("#slider-display").html("1 / 10");
                    </script>
                    <hr/>
                    <h3>
                        Would you recommend MentorMaps to a friend?
                    </h3>

                    <div class="row uniform" style="text-align:center;display:inline-block;">
                        <div class="12u 12u$">
                            <input type="radio" id="yes" name="yesno"/>
                            <label for="yes">
                                Yes
                            </label>
                            <input type="radio" id="no" name="yesno"/>
                            <label for="no">
                                No
                            </label>
                            <textarea id="why" placeholder="Why?" rows="2"></textarea>
                        </div>
                        <script>
                            $("#why").hide();
                            $("#no").change(function () {
                                $("#why").show();
                            });
                            $("#yes").change(function () {
                                $("#why").hide();
                            });
                        </script>
                    </div>
                    <hr/>
                    <h3 style="padding-top:10px; padding-bottom:10px">What feature did you like or use the most?</h3>

                    <div style="padding-top:10px; padding-bottom:10px;text-align:center;display:inline-block;">
                        <select id="recFeaturesField">
                            <option value="" disabled selected style="display:none;">
                                Please Choose
                            </option>
                            <option value="algorithm">
                                Team/Mentor Compatibility Algorithm
                            </option>
                            <option value="sponsor_filter">
                                Search by Sponsor Filter
                            </option>
                            <option value="map">
                                Map to see teams/mentors in your area.
                            </option>
                            <option value="messaging">
                                Messaging System
                            </option>
                        </select>
                    </div>
                    <hr/>
                    <h3 style="padding-top:10px; padding-bottom:10px">
                        What feature did you dislike or never use?
                    </h3>

                    <div style="padding-top:10px; padding-bottom:10px;text-align:center;display:inline-block;">
                        <select id="dislikedFeaturesField">
                            <option value="" disabled selected style="display:none;">
                                Please Choose
                            </option>
                            <option value="algorithm">
                                Team/Mentor Compatibility Algorithm
                            </option>
                            <option value="sponsor_filter">
                                Search by Sponsor Filter
                            </option>
                            <option value="map">
                                Map to see teams/mentors in your area.
                            </option>
                            <option value="messaging">
                                Messaging System
                            </option>
                        </select>
                    </div>
                    <hr/>
                    <h3 style="padding-top:10px; padding-bottom:10px">
                        What features would you like to see added?
                    </h3>

                    <div align='center' style="padding-top:10px; padding-bottom:10px">
                        <textarea name="team-name" id="toAddFeaturesField" placeholder="Write Response"
                                  style="width: 60%"></textarea>
                    </div>
                    <button id="submit" onclick="submit();" class="button">
                        submit
                    </button>
                </div>
            </section>
        </article>
        <footer id="footer">
            <ul class="copyright">
                <li><?php require "./copy.php"; echoCopy(); ?></li>
            </ul>
        </footer>
    </div>
    </body>
    </html>
    <?php
} else {
    require "./db.php";

    //prevent xss & sql injection
    $email = sanitize($_POST['email']);
    $recFriend = sanitize($_POST['recFriend']);
    $recFeatures = sanitize($_POST['recFeatures']);
    $toAddFeatures = sanitize($_POST['toAddFeatures']);
    $dislikedFeatures = sanitize($_POST['dislikedFeatures']);
    $why = sanitize($_POST['why']);

    $db->query("INSERT INTO `survey_results` (WHY, EMAIL, REC_FRIEND, TO_ADD_FEATURES, REC_FEATURES, DISLIKED_FEATURES) VALUES ('$why', '$email', '$recFriend', '$toAddFeatures', '$recFeatures', '$dislikedFeatures');");
    echo '{"status":"queried successfully"}';
}
?>