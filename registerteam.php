<html>
    <head>
        <link rel="shortcut icon" href="http://mentormaps.net/favicon.ico"/>
        <title>Mentor Maps</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery.scrollex.min.js"></script>
        <script src="assets/js/jquery.scrolly.min.js"></script>
        <script src="assets/js/skel.min.js"></script>
        <script src="assets/js/util.js"></script>
        <script src="assets/js/main.js"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC-e-RpEFPKNX-hDqBs--zoYYCk2vmXdZg"></script>
        <script src="https://parse.com/downloads/javascript/parse-1.6.0.js"></script>
        <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
        <!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
        <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
        <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
    </head>
    <body class="landing">
            <div id="page-wrapper">
                    <header id="header">
                        <h1><a href="./index.php">Mentor Maps</a></h1>
                        <nav id="nav">
                            <ul>
                                <li class="special">
                                    <a href="#menu" class="menuToggle"><span>Menu</span></a>
                                    <div id="menu">
                                        <ul>
                                            <li><a href="./index.php">Home</a></li>
                                            <li><a href="./register.php">Sign Up</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                    </header>
                    <article id="main">
                        <header>
                            <h2>
                                Register as a Team
                            </h2>
                        </header>
                        <section class="wrapper style5">
                            <div class="inner">
                                <section id="register-section">
                                    <h4>Team Registration</h4>
                                    <div>
                                        <div class="row uniform">
                                            <div class="6u 12u$(xsmall)">
                                                <input type="text" title="Team Name" id="name" placeholder="Team Name" />
                                            </div>
                                            <div class="6u$ 12u$(xsmall)">
                                                <input type="email" title="Email" id="email" placeholder="Email" />
                                            </div>
                                            <div class="6u 12u$(small)">
                                                <input type="password" title="Password" id="pass1" placeholder="Password" />
                                            </div>
                                            <div class="6u 12u$(small)">
                                                <input type="password" title="Retype Password" id="pass2" placeholder="Retype Password" />
                                            </div>
                                            <div class="6u 12u$(small)">
                                                <input type="text" title="Team Number" id="teamNumber" placeholder="Team Number" />
                                            </div>
                                            <div class="6u 12u$(small)">
                                                <input type="text" title="Contact Person" id="rname" placeholder="Contact Person" />
                                            </div>

                                            <?php include "./pages/address_form.html"; ?>

                                            <div class="6u 12u$(xsmall)">
                                                <input type="checkbox" id="team-age"/>
                                                <label for="team-age">Rookie Team?</label>
                                            </div>
                                            <div class="6u 12u$(xsmall)">
                                                <input type="text" id="phone" placeholder="Phone Number (Optional)" />
                                            </div>
                                            <div class="3u 12u$(small)">
                                                <input type="radio" id="FLLcheck" name="typeChecks" checked>
                                                <label for="FLLcheck">FLL</label>
                                            </div>
                                            <div class="3u 12u$(small)">
                                                <input type="radio" id="FTCcheck" name="typeChecks">
                                                <label for="FTCcheck">FTC</label>
                                            </div>
                                            <div class="3u 12u$(small)">
                                                <input type="radio" id="FRCcheck" name="typeChecks">
                                                <label for="FRCcheck">FRC</label>
                                            </div>
                                            <div class="3u 12u$(small)">
                                                <input type="radio" id="VEXcheck" name="typeChecks">
                                                <label for="VEXcheck">VEX</label>
                                            </div>
                                            <div class="6u 12u$(small)">
                                                Searching for...
                                            </div>
                                            <div class="6u 12u$(small)">
                                                <br />&nbsp;
                                            </div>

                                            <?php include("./pages/skillset_form.html"); ?>

                                            <div class="12u$">
                                                <textarea name="comments" maxlength="200" id="comments" title="Comments" placeholder="Write something about your team" rows="6"></textarea>
                                            </div>
                                            <div class="12u$">
                                                <input type="checkbox" id="EulaAgreement"></input>
                                                <label for="EulaAgreement">I agree to the <a target="_blank" href="./tos.php">terms of service</a> and certify that I am of 18 years of age or older</label>
                                            </div>
                                            <div class="12u$">
                                                <button id="submitTeamRegistrationForm" class="button special">Become a Team</button>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </section>
                    </article>
                    <footer id="footer">
                        <ul class="copyright">
                            <li>&copy; FRC Team 3309, 2015</li>
                        </ul>
                    </footer>
            </div>
    </body>
    <script src="./customjquery.js"></script>
    <script src="./geocoder.js"></script>
    <script>
        Parse.initialize("883aq7xdHmsFK7htfN2muJ5K3GE6eXWDiW7WwdYh", "jpoT2BB11qnlhNVUkrdovj9ACj3Ejctu2iaFMJr5");
        Parse.User.logOut();
        $("#submitTeamRegistrationForm").click(function(){
            if(!(checkEULA())){
                return;
            }
            var team_number =  $("#team-number").val();
            var team_name =    $("#team-name").val();
            var email =        $("#team-email").val();
            
            var team_phone =   $("#team-phone").val();
            var pass1 =        $("#pass1").val();
            var pass2 =        $("#pass2").val();
 
            var teamage = "undefined";
            if($("#team-age").is(":checked")){
                teamage = "Rookie Team";
            }else{
                teamage = "Experienced Team";
            }

            //workaround for consistency's sake
            document.write("<div style='display:none;' id='age'>"+teamage+"</div>");
            
            if(!passwordCheck(pass1, pass2)){
                alert("passwords do not match");
                return;
            }

            var user = new Parse.User();
            user.set("username", email);
            user.set("email", email);
            user.set("password", pass1);
            user.signUp(null, {
                success: function(user){
                    addUserData(email, "TEAM", $("#rname").val());
                },
                error: function(user, error){
                    alert("an error occurred; check the console");
                    console.log(error);
                }
            });
            
        });

        $(function(){
            $("#engineering-types-list").toggle();
            $("#programming-types-list").toggle();
        });
    </script>
</html>
<?php
}
?>