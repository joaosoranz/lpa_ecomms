<?PHP
  $authChk = true;
  require('app-lib.php');
  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  if(!$action) {
    isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if(!$txtSearch) {
    isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }
  build_header($displayName);
?>

  <?PHP build_navBlock(); ?>
  <div id="content">
    <div class="PageTitle">Sales Management Search</div>

  <!-- Search Section Start -->
    <form name="frmSearchSales" method="post"
          id="frmSearchSales"
          action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
      <div class="displayPane">
        <div class="displayPaneCaption">Search:</div>
        <div>
          <input name="txtSearch" id="txtSearch" placeholder="Search Sales" style="width: calc(100% - 115px)" value="<?PHP echo $txtSearch; ?>">
          <button type="button" id="btnSearch">Search</button>
          <button type="button" id="btnAddRec">Add</button>
        </div>
      </div>
      <input type="hidden" name="a" value="listSales">
    </form>
    <!-- Search Section End -->
    <!-- Search Section List Start -->
    <?PHP
      if($action == "listSales") {
    ?>
    <div>
      <table style="width: calc(100% - 15px);border: #cccccc solid 1px">
        <tr style="background: #eeeeee">
          <td style="width: 130px;border-right: #cccccc solid 1px"><b>Sale Date</b></td>
          <td style="border-right: #cccccc solid 1px;"><b>Client Name</b></td>
          <td style="width: 80px;text-align: right;border-right: #cccccc solid 1px;"><b>Price</b></td>
        </tr>
    <?PHP
      openDB();
      $query =
        "SELECT
            lpa_inv_no, lpa_inv_date, lpa_inv_client_name, lpa_inv_amount
         FROM
            lpa_invoices
         WHERE
            (
              lpa_inv_no LIKE '%$txtSearch%'
                OR
              lpa_inv_client_name LIKE '%$txtSearch%' 
            )
            AND lpa_inv_status <> 'D'
         ORDER BY  lpa_inv_date DESC

         ";
      $result = $db->query($query);
      $row_cnt = $result->num_rows;
      $dAmount = 0;
      if($row_cnt >= 1) {
        while ($row = $result->fetch_assoc()) {
          $sid = $row['lpa_inv_no'];
          $dAmount += $row['lpa_inv_amount'];
          ?>
          <tr class="hl">
            <td onclick="loadSalesItem(<?PHP echo $sid; ?>,'Edit')"
                style="cursor: pointer;border-right: #cccccc solid 1px">
                <?PHP echo date("d/m/Y H:i:s", strtotime($row['lpa_inv_date'])); ?>
            </td>
            <td onclick="loadSalesItem(<?PHP echo $sid; ?>,'Edit')"
                style="cursor: pointer;border-right: #cccccc solid 1px">
                <?PHP echo $row['lpa_inv_client_name']; ?>
            </td>
            <td style="text-align: right">
              $<?PHP echo $row['lpa_inv_amount']; ?>
            </td>
          </tr>
        <?PHP } ?>
        <tr style="border-top: #cccccc solid 1px">
          <td colspan="2" style="text-align: right"><b>Total: </b></td>
          <td style="text-align: right">
            <b>$<?PHP echo number_format($dAmount, 2, '.', ''); ?></b></td>
        </tr>
        <?PHP
      } else { ?>
        <tr>
          <td colspan="3" style="text-align: center">
            No Records Found for: <b><?PHP echo $txtSearch; ?></b>
          </td>
        </tr>
      <?PHP } ?>
      </table>
    </div>
    <?PHP } ?>
    <!-- Search Section List End -->
  </div>
  <script>
    var action = "<?PHP echo $action; ?>";
    var search = "<?PHP echo $txtSearch; ?>";
    if(action == "recUpdate") {
      alert("Record Updated!");
      navMan("sales.php?a=listSales&txtSearch=" + search);
    }
    if(action == "recInsert") {
      alert("Record Added!");
      navMan("sales.php?a=listSales&txtSearch=" + search);
    }
    if(action == "recDel") {
      alert("Record Deleted!");
      navMan("sales.php?a=listSales&txtSearch=" + search);
    }
    function loadSalesItem(ID,MODE) {
      window.location = "Salesaddedit.php?sid=" +
      ID + "&a=" + MODE + "&txtSearch=" + search;
    }
    $("#btnSearch").click(function() {
      $("#frmSearchSales").submit();
    });
    $("#btnAddRec").click(function() {
      loadSalesItem("","Add");
    });
    setTimeout(function(){
      $("#txtSearch").select().focus();
    },1);
  </script>
<?PHP
build_footer();
?>