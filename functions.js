function autoSubmit()
{
    var formObject = document.forms['catradio'];
    formObject.submit();
}
function catchange()
{
  var cat = document.getElementById('askcat').value
  if(cat=="Other")
    document.getElementById("othcat").style.display="block";
  else
    document.getElementById("othcat").style.display="none";
      
}

function editcatchange()
{
  var cat = document.getElementById('editcat').value
  if(cat=="Other")
    document.getElementById("editothcat").style.display="block";
  else
    document.getElementById("editothcat").style.display="none";
      
}
