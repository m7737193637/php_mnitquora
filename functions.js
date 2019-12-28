function autoSubmit()
{
    var formObject = document.forms['catradio'];
    formObject.submit();
}
function catchange()
{
  var cat = document.getElementById('askcat').value
  if(cat=="Other")
    {document.getElementById("othcat").style.display="block";
      document.getElementById("othcat").required=true;
    }
  else
    {document.getElementById("othcat").style.display="none";
      document.getElementById("othcat").required=false;
    }
      
}

function noofoptchange()
{
  var opts = document.getElementById('noofopt').value
  document.getElementById("option1div").style.display="block";
  document.getElementById("option2div").style.display="block";
  if(opts=="3" || opts=="4")
    {document.getElementById("option3div").style.display="block";
      document.getElementById("option3").required = true;      
    }
  else
    {document.getElementById("option3div").style.display="none";
          document.getElementById("option3").required=false;
    }
  if(opts=="4")
    {document.getElementById("option4div").style.display="block";
      document.getElementById("option4").required = true;      
    }
  else
    {document.getElementById("option4div").style.display="none";
          document.getElementById("option4").required=false;
    }  
}


function editcatchange()
{
  var cat = document.getElementById('editcat').value
  if(cat=="Other")
    document.getElementById("editothcat").style.display="block";
  else
    document.getElementById("editothcat").style.display="none";
      
}
function vote(aid,type,qid)
{
  window.location="vote.php?aid="+ aid + "&type=" + type + "&qid="+qid ;
}
function cvote(vid,type,aid,qid)
{
  window.location="cvote.php?aid="+ aid + "&type=" + type + "&qid="+qid + "&vid="+vid;  
}
function svote(sid, optid)
{
  window.location="svote.php?sid="+ sid +"&optid="+optid;  
}