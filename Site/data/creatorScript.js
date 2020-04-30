function allowDrop(ev){
  ev.preventDefault();
}

var dropOffsetX;
var dropOffsetY;

function drag(ev){
  ev.dataTransfer.setData("text", ev.target.id);
  /* Tenir compte du placement du curseur */
  if (ev.currentTarget.parentElement.nodeName == "BODY") {
    /* En dehors du créateur */
    dropOffsetX = ev.pageX - ev.currentTarget.offsetLeft;
    dropOffsetY = ev.pageY - ev.currentTarget.offsetTop;
  } else {
    /* Dans le créateur */
    dropOffsetX = ev.pageX - parseInt(ev.currentTarget.style.marginLeft) - ev.currentTarget.parentElement.offsetLeft;
    dropOffsetY = ev.pageY - parseInt(ev.currentTarget.style.marginTop) - ev.currentTarget.parentElement.offsetTop;
  }
}

function drop(ev){
  ev.preventDefault();
  var image = document.getElementById(ev.dataTransfer.getData("text"));
  var div = document.getElementById("creator");
  div.appendChild(image);
  
  image.style.marginLeft = ev.pageX - dropOffsetX - div.offsetLeft + "px";
  image.style.marginTop = ev.pageY - dropOffsetY - div.offsetTop + "px";
  image.style.border = "none";
  image.style.borderRadius = "0px";

  /* On remet les handle à la bonne place */
  if (selected != "") {
    selectImg (selected);
  }
}

function showHandles () {
  var handles = document.getElementsByClassName("handle");

  for (handle of handles) {
    handle.style.visibility = "visible";
  }
}

var selected = "";

function selectImg (id) {
  var handleTL = document.getElementById("topleft");
  var handleTR = document.getElementById("topright");
  var handleBL = document.getElementById("bottomleft");
  var handleBR = document.getElementById("bottomright");

  showHandles();

  var img = document.getElementById(id);
  var offsetX = handleTL.offsetWidth / 2;
  var offsetY = handleTL.offsetHeight / 2;

  var x1 = parseInt(img.style.marginLeft) - offsetX;
  var y1 = parseInt(img.style.marginTop) - offsetY;
  var x2 = x1 + img.width + "px";
  var y2 = y1 + img.height + "px";
  x1 = x1 + "px";
  y1 = y1 + "px";

  /* Top Left */
  handleTL.style.marginLeft = x1;
  handleTL.style.marginTop = y1;
  /* Top Right */
  handleTR.style.marginLeft = x2;
  handleTR.style.marginTop = y1;
  /* Bottom Left */
  handleBL.style.marginLeft = x1;
  handleBL.style.marginTop = y2;
  /* Bottom Right */
  handleBR.style.marginLeft = x2;
  handleBR.style.marginTop = y2;

  selected = id;
}

function deselectImg () {
  var handles = document.getElementsByClassName("handle");

  for (handle of handles) {
    handle.style.margin = "0px";
    handle.style.visibility = "hidden";
  }
  selected = "";
}

function imgClick (id) {
  if (document.getElementById(id).parentElement.nodeName == "DIV") {
    if (selected === id) {
      deselectImg (id);
    } else if (selected == "") {
      selectImg (id);
    } else {
      deselectImg (selected);
      selectImg (id);
    }
  }
}

var resizing = "";

function resizeStart (handle) {
  resizing = handle;
}

function resize (ev) {
  if (resizing != "") {
    var div = document.getElementById("creator");
    var img = document.getElementById(selected);
    var x = ev.pageX;
    var y = ev.pageY;
    var imgX = parseInt(img.style.marginLeft);
    var imgY = parseInt(img.style.marginTop);
    var handle = document.getElementById(resizing);

    if (resizing == "topleft") {
      /* Verification des limites */
      if (x > imgX + div.offsetLeft + img.offsetWidth || x < div.offsetLeft ||
          y > imgY + div.offsetTop + img.offsetHeight || y < div.offsetTop) {
        resizeStop();
      } else {
        /* Deplacements */
        img.style.width = imgX - (x - div.offsetLeft) + img.offsetWidth + "px"; 
        img.style.marginLeft = x - div.offsetLeft + "px";
        img.style.height = imgY - (y - div.offsetTop) + img.offsetHeight + "px"; 
        img.style.marginTop = y - div.offsetTop + "px";
      }
    } else if (resizing == "topright") {
      /* Verification des limites */
      if (x < imgX + div.offsetLeft || x > div.offsetLeft + div.offsetWidth ||
          y > imgY + div.offsetTop + img.offsetHeight || y < div.offsetTop) {
        resizeStop();
      } else {
        /* Deplacements */
        img.style.width = x - imgX - div.offsetLeft + "px";
        img.style.height = imgY - (y - div.offsetTop) + img.offsetHeight + "px"; 
        img.style.marginTop = y - div.offsetTop + "px";
      }
    } else if (resizing == "bottomleft") {
      /* Verification des limites */
      if (x > imgX + div.offsetLeft + img.offsetWidth || x < div.offsetLeft ||
          y < imgY + div.offsetTop || y > div.offsetTop + div.offsetHeight) {
        resizeStop();
      } else {
        /* Deplacements */
        img.style.width = imgX - (x - div.offsetLeft) + img.offsetWidth + "px"; 
        img.style.marginLeft = x - div.offsetLeft + "px";
        img.style.height = y - div.offsetTop - imgY + "px";
      }
    } else if (resizing == "bottomright") {
      /* Verification des limites */
      if (x < imgX + div.offsetLeft || x > div.offsetLeft + div.offsetWidth ||
          y < imgY + div.offsetTop || y > div.offsetTop + div.offsetHeight) {
        resizeStop();
      } else {
        /* Deplacements */
        img.style.width = x - imgX - div.offsetLeft + "px";
        img.style.height = y - imgY - div.offsetTop + "px";
      }
    }

    /* Shift pour garder les proportions */
    if (ev.shiftKey) {
      img.style.width = "initial";
    }
    selectImg(selected);
  }
}

function resizeStop () {
  resizing = "";
}

/* Couleur 
   https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/color */

var colorWell;
var defaultColor = "#f5f5f5";

window.addEventListener("load", startup, false);

function startup() {
  colorWell = document.querySelector("#colorWell");
  colorWell.value = defaultColor;
  colorWell.addEventListener("input", update, false);
  colorWell.select();
}

function update (event) {
  document.getElementById("creator").style.backgroundColor = event.target.value;
}