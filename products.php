<?PHP 
  require('app-lib.php'); 
  build_header();
  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
?>
  <?PHP build_navBlock(); ?>
  <div id="content">
    <div class="sectionHeader">Product List</div>

  <form action="" method="post">
    <div class="setionSearch">
      <div>
        <input id="txtSearch" name="txtSearch" value="" placeholder="Search....">
        <button type="submit">Search</button>
        <button type="button" onclick="loadURL('reg.php')">Add Stock</button>
      </div>
    </div>
    <input type="hidden" name="a" value="search">

  </form>

<?PHP
    if($action == "search") {
      isset($_POST['txtSearch'])? $itmSearch = $_POST['txtSearch'] : $itmSearch = "";
      $itemNum = 1;
      openDB();
      $query = "SELECT * FROM lpa_stock " .
        "WHERE lpa_stock_name LIKE '%$itmSearch%' " .
        "AND lpa_stock_status = 'a' " .
        "ORDER BY lpa_stock_name ASC";
      $result = $db->query($query);

      while ($row = $result->fetch_assoc()) {
        if ($row['lpa_image']) {
          $prodImage = $row['lpa_image'];
        } else {
          $prodImage = "question.png";
        }
        $prodID = $row['lpa_stock_ID'];
        ?>
        <div class="productListItem">
          <div
            class="productListItemImageFrame"
            style="background: url('images/<?PHP echo $prodImage; ?>') no-repeat center center;">
          </div>
          <div class="prodTitle"><?PHP echo $row['lpa_stock_name']; ?></div>
          <div class="prodDesc"><?PHP echo $row['lpa_stock_desc']; ?></div>
          <div class="prodOptionsFrame">
            <div class="prodPriceQty">
              <div class="prodPrice">$<?PHP echo $row['lpa_stock_price']; ?></div>
              <div class="prodQty">QTY:</div>
              <div class="prodQtyFld">
                <input
                  name="fldQTY-<?PHP echo $prodID; ?>"
                  id="fldQTY-<?PHP echo $prodID; ?>"
                  type="number"
                  value="1">
              </div>
            </div>
            <div class="prodAddToCart">
              <button
                type="button"
                onclick="addToCart('<?PHP echo $prodID; ?>')">
                Add To Cart
              </button>
            </div>
          </div>
          <div style="clear: left"></div>
        </div>
      <?PHP } ?>
      </div>
    <?PHP;
    } ?>
  <script>
    function loadURL(URL) {
      window.location = URL;
    }
  </script>

<?PHP
  build_footer();
?>