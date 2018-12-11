<?PHP 
  require('app-lib.php');
  build_header();
?>
  <?PHP build_navBlock(); ?>
  <div id="content">
    <div class="sectionHeader">New Customer Registration</div>
    <div>First Name: <input
                        name="fldfirstName"
                        id="fldfirstName"
                        style="width: 200px">
    </div>
    <div>Last Name: <input
        name="fldlastName"
        id="fldlastName"
        style="width: 200px">
    </div>
  </div>
<?PHP
build_footer();
?>