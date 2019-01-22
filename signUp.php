<?PHP
  require('app-lib.php');
  require('error.php');
  
  $chkLogin = false;
  $msg = "";

  isset($_POST['a'])? $action = $_POST['a'] : $action = "";

  if($action == "doSignUp") {
    
    isset($_POST['firstName'])? $firstName = $_POST['firstName'] : $firstName = "";
    isset($_POST['lastName'])? $lastName = $_POST['lastName'] : $lastName = "";
    isset($_POST['address'])? $address = $_POST['address'] : $address = "";
    isset($_POST['phone'])? $phone = $_POST['phone'] : $phone = "";
    isset($_POST['userName'])? $userName = $_POST['userName'] : $userName = "";
    isset($_POST['passWord'])? $passWord = $_POST['passWord'] : $passWord = "";
    isset($_POST['confirmPassword'])? $confirmPassword = $_POST['confirmPassword'] : $confirmPassword = "";

    $password_hash = crypt($passWord);

    $query =
      "INSERT INTO lpa_users (
         lpa_user_username,
         lpa_user_password,
         lpa_user_firstname,
         lpa_user_lastname,
         lpa_user_group,
         lpa_user_status,
         lpa_phone,
         lpa_address
       ) VALUES (
         '$userName',
         '$password_hash',
         '$firstName',
         '$lastName',
         'standard',
         'a',
         '$phone',
         '$address'
       )
      ";

    openDB();
    $result = $db->query($query);

    if($db->error) {
      $msg = "Sign Up failed! Please try again.";
      
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: login.php");
      exit;
    }

  }

  build_header($displayName);
?>

  <div id="contentSignUp">
    <form name="frmSignUp" id="frmSignUp" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
    <div class="titleBar">Sign Up /  New Customers</div>
      <div id="loginFrame">
        <div class="msgTitle">Please fill up the form above:</div>
        <div>
          <div style="display: inline-block;">
            First Name:<br/>
            <input type="text" name="firstName" id="firstName" style="width:215px;" maxlength="20">
          </div>
          <div style="display: inline-block;">
            Last Name:<br/>
            <input type="text" name="lastName" id="lastName" style="width:213px;" maxlength="20">
          </div>
        </div>
        <div>Address:</div>
        <input type="text" name="address" id="address" maxlength="60">
        <div>Phone Number:</div>
        <input type="text" name="phone" id="phone" maxlength="10">
        <div>Username:</div>
        <input type="text" name="userName" id="userName" maxlength="30">
        <div>Password:</div>
        <input type="password" name="passWord" id="passWord" maxlength="25">
        <div>Confirm Password:</div>
        <input type="password" name="confirmPassword" id="confirmPassword" maxlength="25">
        <div class="buttonBar">
          <button type="button" onclick="loadURL('login.php')">Cancel</button>
          <button  type="button" onclick="do_SignUp()">Register</button>
        </div>
      </div>
    </div>
    <input type="hidden" name="a" value="doSignUp">
    </form>
  </div>

  <script>
    var msg = "<?PHP echo $msg; ?>";
    if(msg) {
      alert(msg);
    }

    function do_SignUp() {

      var pass = document.getElementById("passWord").value;
      var confPass = document.getElementById("confirmPassword").value;

      if(pass != confPass){
        alert("Password does not match!!");
      } else {
        document.getElementById("frmSignUp").submit();
      }      
    }
    
    $( "#contentSignUp").center().cs_draggable({
        handle : ".titleBar",
        containment : "window"
      });
</script>

<?PHP
  build_footer();
?>