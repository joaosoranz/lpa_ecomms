<?PHP
  $authChk = true;
  require('app-lib.php');
  require('error.php');

  $cookie_name = "cartItems";

  build_header($displayName);
?>
  <?PHP build_navBlock(); ?>
  <div id="content">
    <div class="PageTitle">Checkout</div>

    <!-- Search Section List Start -->
    <div>
      <table style="width: calc(100% - 15px);border: #cccccc solid 1px">
        <tr style="background: #eeeeee">
          <td style="width: 100px; border: #cccccc solid 1px"><b>Product Code</b></td>
          <td style="border: #cccccc solid 1px"><b>Product Name</b></td>
          <td style="width: 80px;text-align: center; border: #cccccc solid 1px"><b>Price</b></td>
          <td style="width: 80px;text-align: center; border: #cccccc solid 1px"><b>QTY</b></td>
          <td style="width: 80px;text-align: center; border: #cccccc solid 1px"><b>Amount</b></td>
          <td style="width: 80px;text-align: center; border: #cccccc solid 1px"></td>
          <td style="width: 80px;text-align: center; border: #cccccc solid 1px"></td>
        </tr>

        <?php
            if(!isset($_COOKIE[$cookie_name]) || $_COOKIE[$cookie_name] == "") { ?>
            <tr>
                <td colspan="7" style="text-align: center">
                    No items Found!!
                </td>
            </tr>
        <?php
        } else {
            // echo "Cookie '" . $cookie_name . "' is set!<br>";
            // echo "Value is: " . $_COOKIE[$cookie_name];

            $arr = explode(',', $_COOKIE[$cookie_name]);
            $totalAmount = 0;
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
                openDB();
                $result = $db->query($query);
                $row_cnt = $result->num_rows;
                if($row_cnt >= 1) {
                  while ($row = $result->fetch_assoc()) {

                    $totalAmount += $qty * $row['lpa_stock_price'];
                    ?>
                        <tr class="hl">
                            <td style="border: #cccccc solid 1px; text-align: center"><?PHP echo $id; ?></td>
                            <td style="border: #cccccc solid 1px"><?PHP echo $row['lpa_stock_name']; ?></td>
                            <td style="border: #cccccc solid 1px; text-align: right"><?PHP echo $row['lpa_stock_price']; ?></td>
                            <td style="border: #cccccc solid 1px; text-align: right">
                            <input name="fldQTY-<?PHP echo $id; ?>" id="fldQTY-<?PHP echo $id; ?>" type="number" value="<?PHP echo $qty; ?>" style="text-align: right">
                            </td>
                            <td style="border: #cccccc solid 1px; text-align: right"><?PHP echo number_format($qty * $row['lpa_stock_price'], 2, '.', ''); ?></td>
                            <td onclick="updateQTYCart(<?PHP echo $id; ?>)" style="border: #cccccc solid 1px; text-align: center; cursor:pointer; color:Green;">Update</td>
                            <td onclick="deleteFromCart(<?PHP echo $id; ?>)" style="border: #cccccc solid 1px; text-align: center; cursor:pointer; color:#ff0000;">Delete</td>
                        <tr/>
                    <?php 
                  }
                }
            } ?>
                <tr>
                    <td colspan="7" style="border: #cccccc solid 1px; text-align:right;">Total: <?PHP echo number_format($totalAmount, 2, '.', ''); ?></td>
                <tr>
                <tr>
                    <td colspan="7" style="border: #cccccc solid 1px; text-align:right;">
                        <button type="button" onclick="loadURL('payment.php')">Confirm</button>
                    </td>
                <tr/>
            <?php
        }
        ?>
      </table>
    </div>

    <!-- Search Section List End -->
  </div>

  <script>
   
  </script>

<?PHP
    build_footer();
?>