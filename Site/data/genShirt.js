/* Paramètres */
var params = new URLSearchParams(document.location.search.substring(1));

var c = params.get("c");
if (c == null || c.length != 7 || c.substring(0, 1) != '#') c = "#f5f5f5";

var hsl = rgbToHsl(parseInt(c.substring(1,3), 16), parseInt(c.substring(3,5), 16), parseInt(c.substring(5,7), 16));

window.onload = createShirt;

function createShirt () {  
    /* Init */
    var c = document.getElementById("canvas");
    var main = document.getElementById("canvasDiv");
    var ctx = c.getContext("2d");

    c.width = main.offsetHeight;
    c.height = main.offsetHeight;

    /* Image de fond */
    var img = new Image();
    img.src = "data/img/blank.png";

    /* https://stackoverflow.com/a/45201094/5591299 */
    img.onload = function() {
        // step 1: draw in original image
        ctx.clearRect(0, 0, c.width, c.height);
        ctx.globalCompositeOperation = "source-over";
        ctx.drawImage(img, 0, 0, c.width, c.height);
        
        // adjust "lightness"
        ctx.globalCompositeOperation = hsl.l < 100 ? "color-burn" : "color-dodge";
        hsl.l = hsl.l >= 100 ? hsl.l - 100 : 100 - (100 - hsl.l);
        ctx.fillStyle = "hsl(0, 50%, " + hsl.l + "%)";
        ctx.fillRect(0, 0, c.width, c.height);
        
        // adjust saturation
        ctx.globalCompositeOperation = "saturation";
        ctx.fillStyle = "hsl(0," + hsl.s + "%, 50%)";
        ctx.fillRect(0, 0, c.width, c.height);

        // adjust hue
        ctx.globalCompositeOperation = "hue";
        ctx.fillStyle = "hsl(" + hsl.h + ",1%, 50%)";
        ctx.fillRect(0, 0, c.width, c.height);

        // clip
        ctx.globalCompositeOperation = "destination-in";
        ctx.drawImage(img, 0, 0, c.width, c.height);

        // reset comp. mode to default
        ctx.globalCompositeOperation = "source-over";

        /* Images */

        var srcs = document.getElementsByClassName("hidden");

        for (src of srcs) {
            var imgParams = params.getAll(src.id + "[]")
            for (p of imgParams) {
                var res = p.split(" ");
                ctx.drawImage(src, res[0] * c.width / 100, res[1] * c.height / 100, res[2] * c.width / 100, res[3] * c.height / 100);
            }
        }

        /* Mask */

        /* Image de fond */
        var mask = new Image();
        mask.src = "data/img/blank-mask.png";
        mask.onload = function() {
            ctx.drawImage(mask, 0, 0, c.width, c.height);
        }
    }
}

/* https://gist.github.com/mjackson/5311256 */
function rgbToHsl(r, g, b) {
    r /= 255, g /= 255, b /= 255;
  
    var max = Math.max(r, g, b), min = Math.min(r, g, b);
    var h, s, l = (max + min) / 2;
  
    if (max == min) {
      h = s = 0; // achromatic
    } else {
      var d = max - min;
      s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
  
      switch (max) {
        case r: h = (g - b) / d + (g < b ? 6 : 0); break;
        case g: h = (b - r) / d + 2; break;
        case b: h = (r - g) / d + 4; break;
      }
  
      h /= 6;
    }
  
    return {h : h*360, s: s*100, l: l*100};
}

function countChar(e) {
    document.getElementById('countLbl').innerHTML = e.value.length + "/60";
};

function back() {
    location.pathname = "Site/creator.php";
}

function toStore () {
    var colorIn = document.getElementById("colorInput");
    var descIn = document.getElementById("description");
    var priceIn = document.getElementById("priceInput");


    if (colorIn == null || colorIn.value == "" || descIn == null || descIn.value == "" || priceIn == null || priceIn.value == "" || isNaN(priceIn.value)) {
        alert("Veuillez remplir tout les champs correctement!");
    } else {
        /* On prépare l'image */
        var c = document.getElementById("canvas");
        document.getElementById("tmpData").value = c.toDataURL();
        document.getElementById("adminForm").submit();
    }
}

function buy () {
    window.location.href = "acheter.php";
}