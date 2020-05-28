// Some simple stupid code for playing with the box icon.
document.getElementById('open_box').addEventListener("click", openIt);
document.getElementById('close_box').addEventListener("click", closeIt);
function openIt() {
  document.getElementById('box_closed').style.display = 'none';
  document.getElementById('box_opened').style.display = 'block';
}
function closeIt() {
  document.getElementById('box_closed').style.display = 'block';
  document.getElementById('box_opened').style.display = 'none';
}

// Deferred loading of YouTube Videos.
// To make this work, use YouTube's iframe embedd code, but empty src (src="") and put its content into data-src (data-src="https://www.youtube....").
function initYT() {
  var vidDefer = document.getElementsByTagName('iframe');
  for (var i=0; i<vidDefer.length; i++) {
    if(vidDefer[i].getAttribute('data-src')) {
      vidDefer[i].setAttribute('src',vidDefer[i].getAttribute('data-src'));
    }
  }
}
window.onload = initYT;
