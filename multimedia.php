<?PHP
    $authChk = true;
    require('app-lib.php');
    require('error.php');

    build_header($displayName);
?>

    <?PHP build_navBlock(); ?>

    <div id="content">
        <div class="PageTitle">Multimedia</div>
        <table>
            <tr>
                <td>
                <iframe width="420" height="315"
                src="https://www.youtube.com/embed/tgbNymZ7vqY">
                </iframe>
                <td/>
                <td>

                <a class="twitter-timeline" data-width="300" data-height="250" href="https://twitter.com/Microsoft?ref_src=twsrc%5Etfw">Tweets by Microsoft</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

                <td/>
            <tr/>
            <tr>
                <td><button onclick="getLocation()">Get Geolocation</button>

<p id="demo"></p><td/>
                <td><td/>
            <tr/>
        <table/>
    <div/>

    <script>
var x = document.getElementById("demo");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  x.innerHTML = "Latitude: " + position.coords.latitude + 
  "<br>Longitude: " + position.coords.longitude;
}
</script>

<?PHP
build_footer();
?>