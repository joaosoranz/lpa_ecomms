<?PHP
  $authChk = true;
  require('app-lib.php');
  require('error.php');
  
  isset($_REQUEST['sid'])? $sid = $_REQUEST['sid'] : $sid = "";
  if(!$sid) {
    isset($_POST['sid'])? $sid = $_POST['sid'] : $sid = "";
  }
  isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  if(!$action) {
    isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if(!$txtSearch) {
    isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }
  if($action == "delRec") {
    $query =
      "UPDATE lpa_invoices SET
         lpa_inv_status = 'D'
       WHERE
         lpa_inv_no = '$sid' LIMIT 1
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: sales.php?a=recDel&txtSearch=$txtSearch");
      exit;
    }
  }

  isset($_POST['txtInvNo'])? $SaleID = $_POST['txtInvNo'] : $SaleID = gen_ID();
  isset($_POST['txtInvDate'])? $InvDate = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['txtInvDate']))) : $InvDate = "";
  isset($_POST['txtInvClientID'])? $InvClientID = $_POST['txtInvClientID'] : $InvClientID = "";
  isset($_POST['txtInvClientName'])? $InvClientName = $_POST['txtInvClientName'] : $InvClientName = "";
  isset($_POST['txtInvClientAddress'])? $InvClientAddress = $_POST['txtInvClientAddress'] : $InvClientAddress = "";
  isset($_POST['txtInvAmount'])? $InvAmount = $_POST['txtInvAmount'] : $InvAmount = "0.00";
  isset($_POST['txtStatus'])? $InvStatus = $_POST['txtStatus'] : $InvStatus = "";
  $mode = "insertRec";
  if($action == "updateRec") {
    $query =
      "UPDATE lpa_invoices SET
         lpa_inv_date = '$InvDate',
         lpa_inv_client_ID = '$InvClientID',
         lpa_inv_client_name = '$InvClientName',
         lpa_inv_client_address = '$InvClientAddress',
         lpa_inv_amount = '$InvAmount',
         lpa_inv_status = '$InvStatus'
       WHERE
         lpa_inv_no = '$sid' LIMIT 1
      ";
     openDB();
     $result = $db->query($query);
     if($db->error) {
       printf("Errormessage: %s\n", $db->error);
       exit;
     } else {
         header("Location: Sales.php?a=recUpdate&txtSearch=$txtSearch");
       exit;
     }
  }



  if($action == "insertRec") {
  
    $query =
      "INSERT INTO lpa_invoices (
         lpa_inv_no,
         lpa_inv_date,
         lpa_inv_client_ID,
         lpa_inv_client_name,
         lpa_inv_client_address,
         lpa_inv_amount,
         lpa_inv_status
       ) VALUES (
         '$SaleID',
         '$InvDate',
         '$InvClientID',
         '$InvClientName',
         '$InvClientAddress',
         '$InvAmount',
         '$InvStatus'
       )
      ";

    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: sales.php?a=recInsert");
      exit;
    }
  }

  if($action == "Edit") {
    $query = "SELECT * FROM lpa_invoices WHERE lpa_inv_no = '$sid' LIMIT 1";
    $result = $db->query($query);
    $row_cnt = $result->num_rows;
    $row = $result->fetch_assoc();
    $SaleID     = $row['lpa_inv_no'];
    $InvDate   = $row['lpa_inv_date'];
    $InvClientID   = $row['lpa_inv_client_ID'];
    $InvClientName = $row['lpa_inv_client_name'];
    $InvClientAddress  = $row['lpa_inv_client_address'];
    $InvAmount  = $row['lpa_inv_amount'];
    $InvStatus = $row['lpa_inv_status'];
    $mode = "updateRec";
  }
  build_header($displayName);
  build_navBlock();
  $fieldSpacer = "5px";
?>

  <div id="content">
    <div class="PageTitle">Sales Record Management (<?PHP echo $action; ?>)</div>
    <form name="frmSaleRec" id="frmSaleRec" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
      <div>
        <div style="width:130px; display: inline-block;">
            Sale Number:<br/><input name="txtInvNo" id="txtInvNo" value="<?PHP echo $SaleID; ?>" style="width: 100px;" readonly>
        </div>
        <div style="margin-top: <?PHP echo $fieldSpacer; ?>; display: inline-block;">
            Sale Date:<br/><input name="txtInvDate" id="txtInvDate" value="<?PHP if (isset($InvDate) && $InvDate!="") echo date("d/m/Y H:i:s", strtotime($InvDate)); ?>" style="width: 140px;">
        </div>
      </div>
      <div>
        <div style="width:130px; margin-top: <?PHP echo $fieldSpacer; ?>; display: inline-block;">
            Client Code:<br/><input name="txtInvClientID" id="txtInvClientID" value="<?PHP echo $InvClientID; ?>" style="width: 100px;" maxlength="8">
        </div>
        <div style="margin-top: <?PHP echo $fieldSpacer; ?>; width:260px; display: inline-block;">
            Client Name:<br/><input name="txtInvClientName" id="txtInvClientName" value="<?PHP echo $InvClientName; ?>" style="width: 250px;" maxlength="30">
        </div>
      </div>      
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>;">
        Client Address:<br/><input name="txtInvClientAddress" id="txtInvClientAddress" value="<?PHP echo $InvClientAddress; ?>" style="width: 385px;" maxlength="100">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        Sale Amount:<br/><input name="txtInvAmount" id="txtInvAmount" value="<?PHP echo $InvAmount; ?>" style="width: 90px;text-align: right">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>;">
        <div>Sale Status:</div>
        <input name="txtStatus" id="txtSaleStatusActive" <?php if (isset($InvStatus) && ($InvStatus=="A" || $InvStatus=="")) echo "checked";?> type="radio" value="A">
          <label for="txtSaleStatusActive">Active</label>
        <input name="txtStatus" id="txtSaleStatusInactive" <?php if (isset($InvStatus) && $InvStatus=="I") echo "checked";?> type="radio" value="I">
          <label for="txtSaleStatusInactive">Inactive</label>
      </div>
      <input name="a" id="a" value="<?PHP echo $mode; ?>" type="hidden">
      <input name="sid" id="sid" value="<?PHP echo $sid; ?>" type="hidden">
      <input name="txtSearch" id="txtSearch" value="<?PHP echo $txtSearch; ?>" type="hidden">
    </form>
    <div class="optBar">
      <button type="button" id="btnSaleSave" <?php if (isset($_SESSION['UserGroup']) && $_SESSION['UserGroup']=="standard") echo "disabled";?>>Save</button>
      <button type="button" onclick="navMan('sales.php')">Close</button>
      <?PHP if($action == "Edit") { ?>
      <button type="button" onclick="delRec('<?PHP echo $sid; ?>')" style="color: darkred; margin-left: 20px" <?php if (isset($_SESSION['UserGroup']) && $_SESSION['UserGroup']=="standard") echo "disabled";?>>DELETE</button>
      <?PHP } ?>
    </div>
  </div>
  <script>
    $( function() {
      $("#txtInvDate").mask('00/00/0000 00:00:00');
      $("#txtInvAmount").mask('000000.00', {reverse: true});
    } );

    $("#btnSaleSave").click(function(){
        $("#frmSaleRec").submit();
    });

    function delRec(ID) {
      navMan("salesaddedit.php?sid=" + ID + "&a=delRec");
    }

    setTimeout(function(){
      $("#txtInvDate").focus();
    },1);

  </script>
<?PHP
build_footer();
?>