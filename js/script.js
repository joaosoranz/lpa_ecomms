function clickme() {
    alert("You have clicked on me");
}
function navMan(URL) {
    window.location = URL;
}

function addToCartCore(ID) {
  var qty = document.getElementById("fldQTY-"+ID).value;

  var cookieValue = ID + ":" + qty;

  var x = getCookie('cartItems');
  if (x) {
    cookieValue = x + "," + cookieValue;
  }

  setCookie("cartItems", cookieValue, 1);
}

function addToCart(ID) {
    addToCartCore(ID);

    alert("Item added to your cart!!");
}

function deleteFromCartCore(ID) {
  var cart = getCookie('cartItems');
  var cookieValue = ""; 
  
  if (cart) {
    items = cart.split(",");
  }

  for(i = 0; i < items.length; i++){    
    item = items[i].split(":");

    itemId = item[0];
    itemQty = item[1];

    if(itemId == ID)
    {
      //alert(itemId);
    } else {
      cookieValue = itemId + ":" + itemQty + "," + cookieValue; 
    }
  }

  setCookie("cartItems", cookieValue, 1);
}

function deleteFromCart(ID) {
  deleteFromCartCore(ID);

  alert("Item removed from your cart!!");

  window.location = "checkout.php";
}

function updateQTYCart(ID){
  deleteFromCartCore(ID);
  addToCartCore(ID);

  alert("Item updated from your cart!!");

  window.location = "checkout.php";
}

function setCookie(name,value,days) {
  var expires = "";
  if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days*24*60*60*1000));
      expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function getCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

function do_login() {
  document.getElementById("frmLogin").submit();
}

function loadURL(URL) {
  window.location = URL;
}

jQuery.fn.center = function (container) {
this.css("position","absolute");
if(container) {
  this.css("top", Math.max(0, (($(container).height() - $(this).outerHeight()) / 2) +
  $(container).scrollTop()) + "px");
  this.css("left", Math.max(0, (($(container).width() - $(this).outerWidth()) / 2) +
  $(container).scrollLeft()) + "px");
} else {
  this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
  $(window).scrollTop()) + "px");
  this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
  $(window).scrollLeft()) + "px");
}
return this;
};

jQuery.fn.cs_draggable = function(Prams) {
var handleVal=true;
var handle=false;
var container = "window";
var jObj = JSON.stringify(Prams);
if(jObj) {
  JSON.parse(jObj, function (k, v) {
    if (k == "handle") { handleVal = v; }
    if (k == "container") { container = v; }
  });
}
if(handleVal == true) { handle = ".cs-gen-dialog-header"; }
else if(handle == false) {
  if(handleVal) {
    handle = handleVal;
  } else {
    handle = false;
  }
}
this.draggable({
  handle      : handle,
  containment : container,
  opacity     : 0.50,
  scroll      : false
}).css({});
$(handle).css({
  cursor : "move"
});
};