function allowDrop(ev){
  ev.preventDefault();
}

function drag(ev){
  ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev){
  ev.preventDefault();
  var image = document.getElementById(ev.dataTransfer.getData("text"));
  var div = document.getElementById("creator");
  div.appendChild(image);
  

  image.style.marginLeft = ev.pageX - image.width / 2 - div.offsetLeft + "px";
  image.style.marginTop = ev.pageY - image.height / 2 - div.offsetTop + "px";
}