<?PHP
  $authChk = true;
  require('app-lib.php');
  require('error.php');

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
        <input type="text" name="phone" id="address" style="width:215px;" maxlength="20" value=<?PHP echo $lpa_phone ?>>
    </div>
    <div style="padding-top:7px;">
        Payment Type:
        <input name="txtStatus" id="txtSaleStatusActive" type="radio" value="Paypal">
          <label for="txtSaleStatusActive">Paypal</label>
        <input name="txtStatus" id="txtSaleStatusInactive" type="radio" value="VISA">
          <label for="txtSaleStatusInactive">VISA</label>
        <input name="txtStatus" id="txtSaleStatusInactive" type="radio" value="MasterCard">
          <label for="txtSaleStatusInactive">MasterCard</label>
        <input name="txtStatus" id="txtSaleStatusInactive" type="radio" value="Direct Deposit">
          <label for="txtSaleStatusInactive">Direct Deposit</label>
    </div>
    <div style="padding-top:7px;"><button type="button" onclick="addToCart('x')">Finalize Order</button></div>
  </div>

<?PHP
    build_footer();
?>