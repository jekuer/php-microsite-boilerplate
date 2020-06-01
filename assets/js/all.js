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

