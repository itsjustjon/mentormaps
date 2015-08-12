<?php
//do all login operations / redirects
require "./logincheck.php";
require "./db.php";

//get the logged in user's account type from the session variable
$email = $_SESSION['email'];
$sql = "SELECT `TYPE` FROM `logins` WHERE `EMAIL` = '$email'";
$type = "UNDEFINED";
$result = $db->query($sql);
while($r=mysqli_fetch_assoc($result)){
    $type = $r['TYPE'];
}

//get the user's address
$sql = "SELECT `ADDRESS` FROM `data` WHERE `EMAIL` = '$email'";
$my_address = "UNDEFINED";
$result = $db->query($sql);
while($r=mysqli_fetch_assoc($result)){
    $my_address=$r['ADDRESS'];
}

//store all of the opposite kinds of addresses
$address_array = array();
if($type=="MENTOR"){
    echo '<!--you are a mentor, displaying all results for teams-->';
    $sql = "SELECT `ADDRESS` FROM `data` WHERE ACCOUNT_TYPE = 'TEAM'";
}else{
    echo '<!--you are a team, displaying all results for mentors-->';
    $sql = "SELECT `ADDRESS` FROM `data` WHERE ACCOUNT_TYPE = 'MENTOR'";
}
$result = $db->query($sql);
while($r=mysqli_fetch_assoc($result)){
    array_push($address_array, $r['ADDRESS']);
}

//populate an array with the entire database's contents so they can be accessed in javascript
$result=$db->query("SELECT * FROM `data`");
$all_data = array();
while($r=mysqli_fetch_assoc($result)){
    $current = array(
    'name' => $r['NAME'],
    'skills_json' => $r['SKILLS_JSON'],
    'team_number' => $r['TEAM_NUMBER'],
    'comments' => $r['COMMENTS'],
    'phone' => $r['PHONE'],
    'email' => $r['EMAIL'],
    'address' => $r['ADDRESS'],
    'type' => $r['TYPE'],
    'age' => $r['AGE'],
    'account_type' => $r['ACCOUNT_TYPE'],
    );
    array_push($all_data, $current);
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <style>
            html, body, #map-canvas {
                height:100%;
                margin: 0;
                padding: 0;
            }
        </style>
        <title>Mentor Maps</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
        <link rel="stylesheet" href="assets/css/main.css" />
        
        <script src="compare.js"></script>
        
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery.scrollex.min.js"></script>
        <script src="assets/js/jquery.scrolly.min.js"></script>
        <script src="assets/js/skel.min.js"></script>
        <script src="assets/js/util.js"></script>
        <!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
        <script src="assets/js/main.js"></script>
        <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
        <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-e-RpEFPKNX-hDqBs--zoYYCk2vmXdZg"></script>
        <!--<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false"></script>-->
    <script type="text/javascript">
    
      function initialize() {
        var map = new google.maps.Map(document.getElementById('map-canvas'),{zoom: 11});
        geocoder = new google.maps.Geocoder();
        centerMap(map, "<?php echo $my_address; ?>");
        
        <?php
        $allteams = array();
            foreach($address_array as $address){
                $teamjson = "UNDEFINED";
                $sql = "SELECT * FROM `data` WHERE `ADDRESS` = '$address';";
                $result=$db->query($sql);
                while($r=mysqli_fetch_assoc($result)){
                    $a = array( 'name' => $r['NAME'],
                                'searching_skills_json' => $r['SKILLS_JSON'],
                                'team_number' => $r['TEAM_NUMBER'],
                                'comments' => $r['COMMENTS'],
                                'phone' => $r['PHONE'],
                                'email' => $r['EMAIL'],
                                'address' => $r['ADDRESS'],
                                'type' => $r['TYPE'],
                                'account_type' => $r['ACCOUNT_TYPE']
                                );
                    array_push($allteams, $a);
                    $teamjson = json_encode($a);
                }
                echo 'var teamdata = ' . $teamjson . ';' . PHP_EOL;
                echo 'codeAddress(map, "'.$address.'", teamdata);'. PHP_EOL;
            }
        ?>
        }
        


    function centerMap(map, address){
        geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map, 
            position: results[0].geometry.location,
            icon: './mentorflag.png'
        });

        var infowindow=new google.maps.InfoWindow({
        content: 'Your location'
      });

        google.maps.event.addListener(marker, 'mouseover', function() {
            infowindow.open(map, this);
        });

        google.maps.event.addListener(marker, 'mouseout', function() {
            infowindow.close();
        });
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
}

    function codeAddress(map, address, teamdata) {
        var typedata = $.parseJSON(teamdata['type']);
        var iconurl = "http://qca.st/images/redditor.png";
        if(teamdata['account_type']=='TEAM'){
            if(typedata['pref_ftc']=='true'){
                iconurl = 'white.png';
            }
            if(typedata['pref_fll']=='true'){
                iconurl = 'blue.png';
            }
            if(typedata['pref_frc']=='true'){
                iconurl = 'red.png';
            }
            if(typedata['pref_vex']=='true'){
                iconurl = 'orange.png';
            }
        }else{
            var does1 = false;
            if(typedata['pref_ftc']=='true'){
                does1 = true;
                iconurl = 'whitem.png';
            }
            if(typedata['pref_fll']=='true'){
                if(does1==true){
                    iconurl = 'greenm.png';
                }else{
                    does1 = true;
                    iconurl = 'bluem.png';
                }
            }
            if(typedata['pref_frc']=='true'){
                if(does1==true){
                    iconurl = 'greenm.png';
                }else{
                    iconurl = 'redm.png';
                }
            }
            if(typedata['pref_vex']=='true'){
                if(does1==true){
                    iconurl = 'greenm.png';
                }else{
                    iconurl = 'orangem.png';
                }
            }
        }
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        var marker = new google.maps.Marker({
            map: map, 
            position: results[0].geometry.location,
            icon: iconurl
        });
        var infowindow=new google.maps.InfoWindow({
        content: "" + teamdata['name'] + ", " + teamdata['team_number']
      });
      
        google.maps.event.addListener(marker, 'click', function(){
            $("#img-container").html("");
            if(typedata['pref_fll']=='true'){
                document.getElementById("img-container").innerHTML += "<img id=\"ross1\" src=\"fll.png\" width=\"160px\" height=\"160px\" style=\"padding-left:1%;\"/>";
            }
            if(typedata['pref_ftc']=='true'){
                document.getElementById("img-container").innerHTML += "<img id=\"ross2\" src=\"ftc.png\" width=\"160px\" height=\"160px\" style=\"padding-left:1%;\"/>";
            }
            if(typedata['pref_frc']=='true'){
                document.getElementById("img-container").innerHTML += "<img id=\"ross3\" src=\"frc.png\" width=\"160px\" height=\"160px\" style=\"padding-left:1%;\"/>";
            }
            document.getElementById("phone-container").innerHTML = "<b><u>Phone:<br /></u></b>" + teamdata['phone'];
            document.getElementById("email-container").innerHTML = "<b><u>Email:<br /></u></b>" + teamdata['email'];
            document.getElementById("address-container").innerHTML = "<b><u>Location:<br /></u></b>" + teamdata['address'];
            document.getElementById("comments-container").innerHTML = "<b><u>Comments:<br /></u></b>" + teamdata['comments'];
            document.getElementById("team-info-label").innerHTML = 'Team Info: <a href="./profile.php?p='+teamdata['email']+'"><img src="./ic_open_in_new_white_48dp_2x.png" width="32px" height="32px" /></a>';
            
            var searchingFor = "";
            var ssjson = $.parseJSON(teamdata['searching_skills_json']);
            $.each(ssjson, function(key, value){
                if(key == 'skill-other'){
                        searchingFor = searchingFor + "other ("+teamdata['other_detail']+")";
                }else{
                    if(value=='true'){
                        searchingFor = searchingFor + key + "<br />";
                    }
                }
            });
            <?php
            if($type=="MENTOR"){
                echo'
                document.getElementById("searching-skills-container").innerHTML = "<b><u>Searching For:<br /></u></b>" + searchingFor;
                document.getElementById("name-container").innerHTML = "<b><u>Team:<br /></u></b>" + teamdata[\'name\'] + ", " + teamdata[\'team_number\'];
                ';
            }else{
                echo '
                document.getElementById("searching-skills-container").innerHTML = "<b><u>Offers:<br /></u></b>" + searchingFor;
                document.getElementById("name-container").innerHTML = "<b><u>Mentor Info:<br /></u></b>" + teamdata[\'name\'] + ", " + teamdata[\'team_number\'];
                ';
            }
            ?>
            
        });

        google.maps.event.addListener(marker, 'mouseover', function() {
            infowindow.open(map, this);
        });

        google.maps.event.addListener(marker, 'mouseout', function() {
            infowindow.close();
        });
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    </head>
    <body>

        <!-- Page Wrapper -->
            <div id="page-wrapper">

                <!-- Header -->
                    <header id="header">
                        <h1><a href="./index.php">Mentor Maps</a></h1>
                        <nav id="nav">
                            <ul>
                                <li class="special">
                                    <a href="#menu" class="menuToggle"><span>Menu</span></a>
                                    <div id="menu">
                                        <ul>
                                            <li><a href="./index.php">Home</a></li>
                                            <li><a href="./logout.php">Log Out</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                    </header>

                <!-- Main -->
                    <article id="footer" style="padding-top:30px;">
                    <div id="maybe-this-will-work-wrapper"><!--holy crap, it worked-->
                    <div id="map-and-search-wrapper" style="display:inline-block;width:100%;color:black;">
                        <div id="legend">
                        <script>
                            document.getElementById('legend').setAttribute('style', 'height:' + parseInt(parseInt(window.innerHeight) - parseInt((window.innerHeight / 4))) + "px" + ";float:left;background-color:teal;width:15%;color:white;");
                        </script>
                    </div>
                    
                        <div id="search-wrapper">
                        <script>
                        
                        var up = false;
                        
                        document.getElementById('search-wrapper').setAttribute('style', 'height:' + parseInt(parseInt(window.innerHeight) - parseInt((window.innerHeight / 4))) + "px" + ";text-align: center;float:right;background-color:teal;width:15%;color:white;text-align:left;");
                        
                        function frau(){
                            if(up){
                                up = !up;
                                $("#coolarrow").html('&#9660;');
                            }else{
                                up = !up;
                                $("#coolarrow").html('&#9650;');
                            }
                            $("#pancakes").toggle();                            
                        }
                        
                        </script>
                        <div style="overflow-y:scroll;line-height:2em;overflow:scroll;overflow-x:hidden;height:100%;">
                            <ul id="pancakes" style="list-style-type:none;" id="list-thing">
                                <li>Team Search Filter</li>
                                <li>Range <input id="slidely-thing" type="range"/><div id="range-display" style="display:inline;"></div></li>
                                <li><button onclick="refreshListing();">refresh</button></li>
                            </ul>
                            <script>
                                $("#pancakes").toggle();
                            </script>
                            <ul style="list-style-type:none;" id="team-list">
                                <li><button id="coolarrow" onclick="frau();">&#9660;</button></li>
                            </ul>
                            </div>
                        </div>
                        
                        <div id="map-section">
                            <script>
                                document.getElementById("map-section").style.height= window.innerHeight - (window.innerHeight / 4) + "px";
                                //document.getElementById('map-section').style.width = window.innerWidth * 0.7 + "px";
                            </script>
                            <div id="map-canvas"></div>
                        </div>
                    </div>
                    
                    
                    <script>
                    <?php
                        echo 'var alldata = ' . json_encode($all_data) . ';' . PHP_EOL;
                        echo 'var allteams = ' . json_encode($allteams) . ";" . PHP_EOL;
                    ?>
                    
                    var me;
                    for(var i=0;i<alldata.length;i++){
                        var current_item = alldata[i];
                        if(current_item['address'] == '<?php echo $my_address; ?>'){
                            me = current_item;
                            break;
                        }
                    }
                    
                    function getLatLngFromAddress(address){
                    geocoder.geocode( { 'address': address}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            return results[0].geometry.location.LatLng;
                        }else{
                            //TODO handle else case for invalid address
                            console.log("error getting latlng from address");
                        }});
                    }
                    
                    function calculateDistance(address1, address2){
                        var p1 = getLatLngFromAddress(address1);
                        var p2 = getLatLngFromAddress(address2);
                        
                        console.log(p1);
                        
                        //console.log(getDistance(p1,p2));
                        //return getDistance(p1,p2);
                    }
                    
                    function refreshListing(){
                        $("#team-list").html("<li><button id=\"coolarrow\" onclick=\"frau();\">&#9650;</button></li>");
                        var teamscore_map = [];
                        for(var i=0;i<allteams.length;i++){//rrgh cant get foreach loops to work right
                            var team = allteams[i];
                                var searchingfor = $.parseJSON(me['skills_json']);
                                var offered = $.parseJSON(team['searching_skills_json']);
                                var distance = 100;//todo calc this
                                var process_teamtype = $.parseJSON(me['type']);
                                var process_mentortypes = $.parseJSON(team['type']);
                                var teamtype;
                                var mentortypes = [];
                                
                                for(var e in process_mentortypes){
                                    if(process_mentortypes[e]=='true'){
                                        mentortypes.push(e);
                                    }
                                }
                                
                                for(var e in process_teamtype){
                                    if(process_teamtype[e]=='true'){
                                        teamtype = e;
                                        break;
                                    }
                                }
                                
                                var compare_result = compare(searchingfor, offered, teamtype, mentortypes, distance);
                                teamscore_map.push({team, compare_result});
                        }
                        console.log(teamscore_map);
                        
                        var comparator = function(a,b){
                            return parseInt(a['compare_result']) + parseInt(b['compare_result']);
                        }
                        
                        teamscore_map = teamscore_map.sort(comparator);
                        
                        for(var e in teamscore_map){
                            var team = teamscore_map[e]['team'];
                            $("#team-list").append("<li><a href='./profile.php?p="+team['email']+"'>"+parseInt(parseInt(e)+1)+" | "+team['address']+"</a></li>");
                        }
                        
                        console.log(teamscore_map);
                    }
                    </script>
                    
                    </div>
                    <style>
                    .paddedImgHolder{
                        padding-top:10px;
                    }
                    </style>
                    <div style="width:100%;background-color:teal;height:62px;"><img class="paddedImgHolder" src="red.png"/>FRC | <img class="paddedImgHolder" src="white.png"/> FTC | <img class="paddedImgHolder" src="blue.png"/>FLL</div>
                        <div style="white-space:nowrap;">
                        <div class="inner" id="team-info" style="padding-top:20px;float:center;text-align:center;">
                            <section id="team-info-section">
                            <div class="6u 6u$(small)"><b><u id="team-info-label" style="font-size:35px;">Team Info</u></b></div>
                                <div class="row uniform">
                                    <div class="12u 12u$(small)" id="img-container"></div>
                                    <div class="6u 3u$(small)" id="name-container"></div>
                                    <div class="6u 3u$(small)" id="address-container"></div>
                                    <div class="6u 3u$(small)" id="searching-skills-container"></div>
                                    <div class="6u 3u$(small)" id="comments-container"></div>
                                    <div class="6u 3u$(small)" id="phone-container"></div>
                                    <div class="6u 3u$(small)" id="email-container"></div>
                                </div>
                            </section>
                        </div>
                        </div>
                        
                    </article>

                <!-- Footer -->
                    <footer id="footer">
                        <ul class="copyright">
                            <li>&copy; Joseph Sirna 2015</li>
                        </ul>
                    </footer>

            </div>
    </body>
</html>