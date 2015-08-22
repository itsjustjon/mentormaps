<?php /** register redirect page; displays registration info and links to register as a mentor or a team **/
    require "./core.php";
    echoHeader();
?>
<article id="main">
    <header>
        <h2>
            Register with Mentor Maps
        </h2>
        <br/>
        <p>
            <button class="button special" onclick="window.location = 'registermentor.php';">
                Register as Mentor
            </button>
            &nbsp;
            <button class="button special" onclick="window.location = 'registerteam.php';">
                Register as Team
            </button>
        </p>
    </header>
    <section class="wrapper style5">
        <div class="inner">
            <h3>
                Register as a Mentor
            </h3>
            <p>
                Registering as a Mentor with Mentor Maps provides local teams the support and learning that is required for a team.  This tool allows teams to search for specific needs and get that specific help.  As a registered mentor you will be able inspire this next generation to become the future.
            </p>
            <hr />
            <h4>
                Register as a Team
            </h4>
            <p>
                Registering as a team with Mentor Maps allows an organization to connect with many local and experienced mentors.  Simply fill out the form with your needs and contact information and wait as your team will be connected with mentors in your area.
            </p>
        </div>
    </section>
</article>

<footer id="footer">
    <ul class="copyright">
        <li>&copy; Joseph Sirna 2015</li>
    </ul>
</footer>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>
<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
</body>
</html>