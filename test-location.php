<html>
<head>
<style type="text/css">
   body {
         font-family: sans-serif;
         font-size: 14px;
   }
</style>

<title>Google Maps JavaScript API v3 Example: Places Autocomplete</title>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places" type="text/javascript"></script>
<script type="text/javascript">
   function initialize() {
      var options = {
         types: ['(cities)'],
         componentRestrictions: {country: "ca"}
      };

      var input = document.getElementById('searchTextField');
      var autocomplete = new google.maps.places.Autocomplete(input, options);
   }
   google.maps.event.addDomListener(window, 'load', initialize);
</script>

</head>
<body>
<?php if(isset($_GET['location'])):
   var_dump($_GET['location']);

   $location = $_GET['location'];
   // $city_pos = strpos($city_raw, ",");
   $city = strstr($location,",",true);

   echo "<br>City: ".$city;

   $country = substr(strrchr($location, ", "), 1);
   echo "<br>Country: ".$country;

else: ?>
   <div>
      <form action="test-location.php" method="get">
         <input id="searchTextField" type="text" name="location" size="50" placeholder="Enter a location" autocomplete="on">
         <input type="submit">
      </form>
   </div>
<?php endif; ?>
</body>
</html>