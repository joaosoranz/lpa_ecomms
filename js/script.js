function clickme() {
    alert("You have clicked on me");
}
function navMan(URL) {
    window.location = URL;
}
function addToCart(ID) {
    var qty = document.getElementById("fldQTY-"+ID).value;
    alert(qty + " x Item: " + ID + " has been added to your cart");
}
function do_login() {
    document.getElementById("frmLogin").submit();
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