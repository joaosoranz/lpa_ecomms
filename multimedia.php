<?PHP
    //$authChk = true;
    require('app-lib.php');
    require('error.php');

    build_header($displayName);
?>

    <?PHP build_navBlock(); ?>

    <style>
      /* Set the size of the div element that contains the map */
      #map {
        height: 250px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
    </style>

    <div id="content">
        <div class="PageTitle">Mashup</div>
        <table style="border: 1px solid; padding: 5px 5px 5px 5px;">
          <tr>
            <td style="width:400px; text-align:justified; border:1px solid;" colspan="2">Logical Peripherals Australia’s mission is to supply high quality computer peripherals, reliable
            customer service and above all customer satisfaction. We strive to deliver the very best in the
            latest technologies and support our customers with the highest after sales support, allowing our
            customers to enjoy the best of technology that our ever-changing world demands.</td>
            <td style="width:300px;border: 1px solid;"><div id="map"></div></td>
          </tr>
          <tr>
              <td style="border:1px solid;width:300px;">
                <iframe width="300" height="250" src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>
              </td>
              <td style="width:400px;border: 1px solid;" colspan="2">
                <a class="twitter-timeline" data-width="400" data-height="250" href="https://twitter.com/Microsoft?ref_src=twsrc%5Etfw">Tweets by Microsoft</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
              </td>
          </tr>
        <table/>
    <div/>


    <script>
// Initialize and add the map
function initMap() {
  // The location of Uluru
  var uluru = {lat: -27.465343, lng: 153.029375};
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 4, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCLDR7lG9zXfhXsL46z50NYnv_AtREqHn8&callback=initMap">
    </script>

<?PHP
build_footer();
?>