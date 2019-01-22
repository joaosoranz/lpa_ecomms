<?PHP
  $authChk = true;
  require('app-lib.php');
  require('error.php');

  $cookie_name = "cartItems";
  $totalAmount = 0;
  $msg = "";

  isset($_POST['a'])? $action = $_POST['a'] : $action = "";

  if($action == "CreateOrder") {
    
    isset($_POST['firstName'])? $firstName = $_POST['firstName'] : $firstName = "";
    isset($_POST['lastName'])? $lastName = $_POST['lastName'] : $lastName = "";
    isset($_POST['address'])? $address = $_POST['address'] : $address = "";
    isset($_POST['phone'])? $phone = $_POST['phone'] : $phone = "";
    isset($_POST['payment'])? $payment = $_POST['payment'] : $payment = "";

    $query =
      "INSERT INTO lpa_invoices (
         lpa_inv_date,
         lpa_inv_client_name,
         lpa_inv_client_address,
         lpa_inv_amount,
         lpa_inv_status,
         lpa_inv_phone,
         lpa_inv_payment
       ) VALUES (
         NOW(),
         '$firstName $lastName',
         '$address',
         '10',
         'A',
         '$phone',
         '$payment'
       )
      ";

    openDB();
    $result1 = $db->query($query);

    if($db->error) {
      $msg = "Order failed! Please try again.";
      
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {

      //Get Invoice Id/////////////////////////////////////////////////////
      $query = 
        "SELECT LAST_INSERT_ID() AS Id;";
      $resultx = $db->query($query);
      $row_cnt = $resultx->num_rows;
      $row = $resultx->fetch_assoc();
      $orderId = $row['Id'];
      //Get Invoice /////////////////////////////////////////////////////

      //Save Items/////////////////////////////////////////////////////
      $arr = explode(',', $_COOKIE[$cookie_name]);
      
      foreach ($arr as $val) { 
      
          $id = explode(':', $val)[0];
          $qty =  explode(':', $val)[1];

          $query =
            "SELECT
                *
             FROM
                lpa_stock
             WHERE
              lpa_stock_ID = $id
              AND lpa_stock_status <> 'D'
    
             ";

          $result = $db->query($query);
          $row_cnt = $result->num_rows;
          if($row_cnt >= 1) {
            while ($row = $result->fetch_assoc()) {              

              $totalAmount += $qty * $row['lpa_stock_price'];
              $stockName = $row["lpa_stock_name"];
              $price = $row['lpa_stock_price'];
              $amount = $qty * $row['lpa_stock_price'];

              $query =
              "INSERT INTO lpa_invoice_items (
                 lpa_invitem_inv_no,
                 lpa_invitem_stock_ID,
                 lpa_invitem_stock_name,
                 lpa_invitem_qty,
                 lpa_invitem_stock_price,
                 lpa_invitem_stock_amount,
                 lpa_inv_status
               ) VALUES (
                 $orderId,
                 $id,
                 '$stockName',
                 $qty,
                 $price,
                 $amount,
                 'a'
               )
              ";

            $result3 = $db->query($query);
            }
          }
        }
        //Save Items/////////////////////////////////////////////////////

        $query =
              "UPDATE lpa_invoices SET lpa_inv_amount = $totalAmount WHERE lpa_inv_no = $orderId";

        $result4 = $db->query($query);

        unset($_COOKIE[$cookie_name]);
        setcookie($cookie_name, null, -1, '/');

        $msg = "Payment Successful and Order Completed!!";

    }

  }

  build_header($displayName);

  $userId = (int)$_SESSION['authUser'];

  $query = 
    "SELECT * FROM 
        lpa_users 
    WHERE 
        lpa_user_id = $userId
    LIMIT 1";
  openDB();
  $result = $db->query($query);
  $row_cnt = $result->num_rows;
  $row = $result->fetch_assoc();
  $lpa_user_firstname = $row['lpa_user_firstname'];
  $lpa_user_lastname = $row['lpa_user_lastname'];
  $lpa_address = $row['lpa_address'];
  $lpa_phone = $row['lpa_phone'];
?>
  <?PHP build_navBlock(); ?>
  <form name="frmOrder" id="frmOrder" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
    <div id="content" style="">
      <div class="PageTitle">Payment</div>
      <div>
          First Name:
          <input type="text" name="firstName" id="firstName" style="width:215px;" maxlength="20" value=<?PHP echo $lpa_user_firstname ?>>
      </div>
      <div style="padding-top:7px;">
          Last Name:
          <input type="text" name="lastName" id="lastName" style="width:215px;" maxlength="20" value=<?PHP echo $lpa_user_lastname ?>>
      </div>
      <div style="padding-top:7px;">
          Address:
          <input type="text" name="address" id="address" style="width:215px;" maxlength="20" value=<?PHP echo $lpa_address ?>>
      </div>
      <div style="padding-top:7px;">
          Phone:
          <input type="text" name="phone" id="phone" style="width:215px;" maxlength="20" value=<?PHP echo $lpa_phone ?>>
      </div>
      <div style="padding-top:7px;">
          Payment Type:
          <input name="payment" id="txtSaleStatusActive" type="radio" value="Paypal">
            <label for="txtSaleStatusActive">Paypal</label>
          <input name="payment" id="txtSaleStatusInactive" type="radio" value="VISA">
            <label for="txtSaleStatusInactive">VISA</label>
          <input name="payment" id="txtSaleStatusInactive" type="radio" value="MasterCard">
            <label for="txtSaleStatusInactive">MasterCard</label>
          <input name="payment" id="txtSaleStatusInactive" type="radio" value="Direct Deposit">
            <label for="txtSaleStatusInactive">Direct Deposit</label>
      </div>      
      <div style="padding-top:7px;">
        <button type="button" onclick="loadURL('checkout.php')">Cancel</button>
        <button type="button" onclick="createOrder()">Pay Now</button>
      </div>
    </div>
    <input type="hidden" name="a" value="CreateOrder">
    </form>
    <script>
        var msg = "<?PHP echo $msg; ?>";
        if(msg) {
          alert(msg);

          window.location = "sales.php";
        }

        function createOrder() {
        document.getElementById("frmOrder").submit();    
      }
</script>
<?PHP
    build_footer();
?>