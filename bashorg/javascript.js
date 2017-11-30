// Example 26-14: javascript.js

/*
canvas               = O('logo')
context              = canvas.getContext('2d')
context.font         = 'bold italic 97px Georgia'
context.textBaseline = 'top'
image                = new Image()
image.src            = 'bashim.png'

image.onload = function()
{
  gradient = context.createLinearGradient(0, 0, 0, 89)
  gradient.addColorStop(0.00, '#faa')
  gradient.addColorStop(0.66, '#f00')
  context.fillStyle = gradient
  context.fillText(  "R  bin's Nest", 0, 0)
  context.strokeText("R  bin's Nest", 0, 0)
  context.drawImage(image, 64, 32)
}
*/

function O(i) { return typeof i == 'object' ? i : document.getElementById(i) }
function S(i) { return O(i).style                                            }
function C(i) { return document.getElementsByClassName(i)                    }


// call from functions.php - readPage()
function changeKarma(idArticle, m) {
params  = {
  "idArticle": idArticle,
  "m": m
};
request = new ajaxRequest()
request.open("POST", "changekarma.php?idArticle="+idArticle+"&m="+m, true)
request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
/*
request.setRequestHeader("Content-length", params.length)
request.setRequestHeader("Connection", "close")
*/

request.onreadystatechange = function() {
  if (this.readyState == 4)
    if (this.status == 200)
      if (this.responseText != null) {
        O('karma'+idArticle).innerText = this.responseText;
  }
};
request.send(params)
}

function ajaxRequest()
{
  try { var request = new XMLHttpRequest() }
  catch(e1) {
    try { request = new ActiveXObject("Msxml2.XMLHTTP") }
    catch(e2) {
      try { request = new ActiveXObject("Microsoft.XMLHTTP") }
      catch(e3) {
        request = false
      } } }
  return request
}
