function allowDrop(ev){
  if (ev.target.nodeName == "IMG") {
    var div = ev.target.parentElement;
    if (ev.pageX - div.offsetLeft < div.offsetWidth &&
      ev.pageY - div.offsetTop < div.offsetHeight) {
      ev.preventDefault();
    }
  } else {
    ev.preventDefault();
  }
}

var dropOffsetX, dropOffsetY, origin, n = 0;

function drag(ev){
  ev.dataTransfer.setData("text", ev.target.id);
  origin = ev.target.parentElement.id;
  /* Tenir compte du placement du curseur */
  if (origin == "scrollBox") {
    /* Depuis le sélécteur */
    dropOffsetX = ev.pageX - ev.currentTarget.offsetLeft;
    dropOffsetY = ev.pageY - ev.currentTarget.offsetTop;
  } else {
    /* Depuis le créateur */
    dropOffsetX = ev.pageX - parseInt(ev.currentTarget.style.marginLeft) - ev.currentTarget.parentElement.offsetLeft;
    dropOffsetY = ev.pageY - parseInt(ev.currentTarget.style.marginTop) - ev.currentTarget.parentElement.offsetTop;
  }
}

function drop(ev){
  ev.preventDefault();

  console.log(event.dataTransfer.files[0]);

  var div = document.getElementById("creator");

  if (origin == "scrollBox") {
    /* On duplique l'image si elle provient du sélecteur */
    var id = ev.dataTransfer.getData("text");
    var img = document.getElementById(id).cloneNode(false);
    img.id = n;
    img.classList.remove("thumbnail");
    img.classList.add("used");
    n++;
  } else if (origin == "creator") {
    /* On bouge simplement l'image si elle provient du créateur */
    var img = document.getElementById(ev.dataTransfer.getData("text"));
  }
  div.appendChild(img);
  
  /* Placement adapté au curseur */
  img.style.marginLeft = ev.pageX - dropOffsetX - div.offsetLeft + "px";
  img.style.marginTop = ev.pageY - dropOffsetY - div.offsetTop + "px";

  /* On remet les handle à la bonne place */
  if (selected != "") {
    selectImg (selected);
  }
  saveToURL();
}

function handleClick (ev) {
  if (event.target.nodeName == "IMG") {
    if (event.target.id == "delBtn") {
      /* Suppression */
      deleteSelected();
    } else {
      /* Sélection */
      imgClick (event.target.id);
    }
  }
}

function showHandles () {
  /* Poignées de redimensionnements */
  var handles = document.getElementsByClassName("handle");

  for (handle of handles) {
    handle.style.visibility = "visible";
  }
  /* Bouton de suppression */
  document.getElementById("delBtn").style.visibility = "visible";
}

var selected = "";

function selectImg (id) {
  var handleTL = document.getElementById("topleft");
  var handleTR = document.getElementById("topright");
  var handleBL = document.getElementById("bottomleft");
  var handleBR = document.getElementById("bottomright");
  var handleDEL = document.getElementById("delBtn");

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
  /* Delete Button */
  handleDEL.style.marginLeft = parseInt(img.style.marginLeft) + img.width - handleDEL.offsetWidth + "px";
  handleDEL.style.marginTop = parseInt(img.style.marginTop) + "px";

  /* On place l'image sélectionné au dessus des autres */
  document.getElementById('creator').appendChild(img);

  selected = id;
}

function deselectImg () {
  /* Poignées de redimensionnements */
  var handles = document.getElementsByClassName("handle");

  for (handle of handles) {
    handle.style.margin = "0px";
    handle.style.visibility = "hidden";
  }
  
  /* Bouton de suppression */
  var btn = document.getElementById("delBtn");
  btn.style.margin = "0px";
  btn.style.visibility = "hidden";

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
    saveToURL();
  }
}

function resizeStop () {
  resizing = "";
}

function deleteSelected() {
  var img = document.getElementById(selected);
  img.parentNode.removeChild(img);
  deselectImg();
  saveToURL();
}

/* Couleur 
   https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/color */

var colorWell;

window.addEventListener("load", startup, false);

function startup() {
  /* Couleur */
  colorWell = document.querySelector("#colorWell");
  if (colorWell != null) {
    document.getElementById("creator").style.backgroundColor = colorWell.value;
    colorWell.addEventListener("input", update, false);
    colorWell.select();
  }
  
  /* Images */
  adjustURLImages();
}

function update (event) {
  document.getElementById("creator").style.backgroundColor = event.target.value;
  saveToURL();
}

/* Récupère toutes les infos nécessaire à la création du t-shirt 
   et les ajoutent à l'URL.
  https://developers.google.com/web/updates/2016/01/urlsearchparams */
function saveToURL () {
  const params = new URLSearchParams();

  var imgs = document.getElementsByClassName("used");
  var divD = document.getElementById("creator").offsetWidth;
  for (img of imgs) {
    // Le champs 'name' de l'image correspond à l'ID de la source 
    params.append(img.name + '[]', roundToThree(parseInt(img.style.marginLeft) * 100 / divD) + " " + roundToThree(parseInt(img.style.marginTop) * 100 / divD) + " " + roundToThree(img.offsetWidth * 100 / divD) + " " + roundToThree(img.offsetHeight * 100 / divD));
  }

  colorWell = document.querySelector("#colorWell");
  params.set('c', colorWell.value);

  params.sort();
  window.history.replaceState({}, '', `${location.pathname}?${params}`);
}

/* Ajuste les images par rapport à la taille du div */
function adjustURLImages () {
  var divW = document.getElementById("creator").offsetWidth;
  var divH = document.getElementById("creator").offsetWidth;

  var imgs = document.getElementsByClassName("used");
  for (img of imgs) {
    img.style.marginLeft = parseInt(img.style.marginLeft) * divW / 100 + "px";
    img.style.marginTop = parseInt(img.style.marginTop) * divH / 100 + "px";
    img.style.width = parseInt(img.style.width) * divW / 100 + "px";
    img.style.height = parseInt(img.style.height) * divH / 100 + "px";
  }
}

function genTshirt () {
  location.pathname = "Site/genererTshirt.php";
}

/* https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Math/round */
function roundToThree(num) {    
  return +(Math.round(num + "e+3")  + "e-3");
}