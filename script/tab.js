function openTab(evt, userType) {
  var i, x, tablinks;
  x = document.getElementsByClassName("user");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    if (tablinks[i].id == "tabStudent")
      tablinks[i].className = tablinks[i].className.replace(" w3-2018-nebulas-blue", "");
    if (tablinks[i].id == "tabTeacher")
      tablinks[i].className = tablinks[i].className.replace(" w3-2018-cherry-tomato", "");
    if (tablinks[i].id == "tabCompany")
      tablinks[i].className = tablinks[i].className.replace(" w3-2018-quetzal-green", "");
  }
  document.getElementById(userType).style.display = "block";
  if (evt.currentTarget.id == "tabStudent")
    evt.currentTarget.className += " w3-2018-nebulas-blue";
  if (evt.currentTarget.id == "tabTeacher")
    evt.currentTarget.className += " w3-2018-cherry-tomato";
  if (evt.currentTarget.id == "tabCompany")
    evt.currentTarget.className += " w3-2018-quetzal-green";
}