<head>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<meta name="viewport" content="user-scalable=no">
<meta charset="utf-8">
<style>@import url("style.css");</style>
</head>
<body>
  <div id='tabs'>

    <a href="index.php">
    <div id='one' class='current'>
      <i class="material-icons">explore</i>
    </div>
    </a>


    <a href="add.php">
    <div id='two'>
            <i class="material-icons">add_circle_outline</i>
    </div>


    </a>
    <a href="activity.php">
    <div id='three'>
            <i class="material-icons">book</i>
    </div>
    </a>


    <a href="profile.php"><div id='four'>
            <i class="material-icons">person</i>
    </div>
    </a>

  </div>
  <a href="#" id="suggestion-wrapper">
    <div id='suggestionCard'>
      <p>Potrebbe interessarti</p>
      <div id="sub-wrapper">
        <div id='suggestionThumbnail'></div>
        <div id="userNameHeading"></div>
      </div>
      <div id='dismissal'>Ignora</div>
    </div>
  </a>

  </div>
  <div class='heading'>Proposte per te <i class="material-icons" id='search-button'>search</i></div>
  <div class='find'>
  <div id='searchBox'>
    <input type="text" id='search' placeholder='Cerca un annuncio'>
    <i class="material-icons" id='cancel'>cancel</i>
  </div>
    <i id='go' class='material-icons'>send</i>
  </div>
  <p class="catTitle">Cerca per categoria</p>
  <div id="catSelector">
    <p class="tag" data-cat-Code="0" id="tag0">Illustrazioni/arti visive &#127912;</p>
    <p class="tag" data-cat-Code="1" id="tag1">Lavori domestici &#129529;</p>
    <p class="tag" data-cat-Code="2" id="tag2">Condivisione tragitto &#128663;</p>
    <p class="tag" data-cat-Code="3" id="tag3">Pagamento bollette &#128179;</p>
    <p class="tag" data-cat-Code="4" id="tag4">Lezioni &#128214;</p>
    <p class="tag" data-cat-Code="5" id="tag5">Delivery &#128757;</p>
    <p class="tag" data-cat-Code="6" id="tag6">Attività turistica &#127757;</p>
  </div>
  <a href="" class='film_wrap'><div id='hidden'><div class='author_cont'><div class='artPropic'></div><div class='author'></div><div class='date'></div><div class='filler'></div><div class="priceTag"></div><div id='artCoin'></div></div><div class='content'><div class='thumbnail'></div><div class='textualContent'><h3>Titolo</h3><p>Body</p></div></div></div></a>

  <script type="text/javascript">



  document.getElementById("dismissal").addEventListener('click',function(){
  document.getElementById("dismissal").parentElement.parentElement.removeChild(this.parentElement)});
  window.addEventListener('load',loadSugg());
  function loadSugg(){
    reqs=new XMLHttpRequest();
    reqs.open("POST","fetchSugg.php");
    reqs.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    reqs.send();
    reqs.onreadystatechange=feedbackSug;
  }
  function feedbackSug()
  {
    if (reqs.readyState == 4 && reqs.status == 200) {
      if(reqs.response==""){}else{
        risultati=JSON.parse(reqs.response);
          max=0;
          imax=0;
            for(j=0;j<=Object.keys(risultati).length;j++){
              if(risultati["u"+j]>=max){
                imax=j;
                max=risultati["u"+j];
              }
            }
          }
          if(max>0){
            document.getElementById('suggestionCard').style.display="block";
            document.getElementById('userNameHeading').innerHTML=risultati["name"]+" "+risultati["lastname"];
            document.getElementById('suggestion-wrapper').href="publicProfile.php?id="+risultati["u"+imax+""];
          }
      }
    }



  h = window.innerHeight;
function displayWindowSize(){
  if(window.innerHeight<h){
    document.getElementById('tabs').style.display='none';
    h = window.innerHeight;
  }else{
    document.getElementById('tabs').style.display='block';
    h = window.innerHeight;
  }
}
window.addEventListener("resize", displayWindowSize);



    document.getElementById('search-button').addEventListener('click',
    function(){
    document.getElementsByClassName('find')[0].classList.toggle("find-active");
  });




//CODICE CHE VERIFICA SE IL CAMPO DI TESTO E' VUOTO PER FAR APPARIRE E SPARIRE LA X
document.getElementById("search").addEventListener("input", function() {
  if( isEmpty(this.value) ) {
    document.getElementById('cancel').style.visibility='hidden';
  } else {
    document.getElementById('cancel').style.visibility='visible';
  }
});
function isEmpty(str) {
    return !str.trim().length;
}


document.getElementById('cancel').addEventListener("click",function(){
  document.getElementById("search").value="";
  //CANCELLO I RISULTATI DI RICERCA TROVATI PRIMA DI RICARICARE GLI ORIGINALI
  fetch();
},false);


    window.addEventListener('load',function(){fetch(0,null)},false);


    function feedback()
    {
      if (req.readyState == 4 && req.status == 200) {
        if(req.response=="")
        {
          alert('Non ci sono annunci');
      }else{
        while(document.getElementsByClassName('film_wrap')[1]){
            document.body.removeChild(document.getElementsByClassName('film_wrap')[1]);
            document.getElementById('cancel').style.visibility='hidden';
        }
        risultati=JSON.parse(req.response);
        lunghezza=Object.keys(risultati).length;
        for(let i=0;i<lunghezza;i++){
          newArt=document.getElementsByClassName('film_wrap')[0].cloneNode(true);
          document.body.appendChild(newArt);
          newArt.className='film_wrap';
          newArt.childNodes[0].id='film';
          newArt.href='article.php'+'?id='+risultati[i]['id'];
          newArt.childNodes[0].childNodes[0].childNodes[1].innerHTML=risultati[i]['name']+" "+risultati[i]['lastname'];
          newArt.childNodes[0].childNodes[0].childNodes[2].innerHTML=risultati[i]['data'];
          newArt.childNodes[0].childNodes[0].childNodes[4].innerHTML=risultati[i]['price'];
          newArt.childNodes[0].childNodes[1].childNodes[0].style.backgroundImage = "url('"+risultati[i]['imgPath']+"')";
          newArt.childNodes[0].childNodes[1].childNodes[1].childNodes[0].innerHTML=risultati[i]['title'];
          newArt.childNodes[0].childNodes[1].childNodes[1].childNodes[1].innerHTML=risultati[i]['body'];
      }
      }
    }
  }

    function fetch(opt,cat)
    {
      req=new XMLHttpRequest();
      req.open("POST","fetchArt.php");
      req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      req.send("tipoRichiesta="+ 1+"&option="+ opt+"&category="+cat);
      req.onreadystatechange=feedback;
      }

window.addEventListener('load',function(){setTimeout(ad, 5000)},false);
function ad(){
  adPane=document.createElement('div');
  adPane.id='adPane';
  document.body.appendChild(adPane);
  adPopup=document.createElement('div');
  adPopup.id='adPopup';
  adPane.appendChild(adPopup);
  document.body.style.overflow='hidden';
  adClose=document.createElement('div');
  adClose.id='adClose';
  adClose.innerHTML='Chiudi annunci';
  adPane.appendChild(adClose);
  adClose.addEventListener('click',function(){hide(adPane,adPopup,adClose)},false);
}

function hide(a,b,c){
a.style.opacity=0;
a.style.display='none';
document.body.style.overflow='visible';
setTimeout(function(){a.style.display='flex';a.style.opacity=1;document.body.style.overflow='hidden';}, 20000);

}

//CODICE PER LA RICERCA DEGLI ARTICOLI
bottoneInvia=document.getElementById('go');
bottoneInvia.addEventListener('click',sendQuery,false);
function sendQuery(){
  searchValue=document.getElementById('search').value;
  search=new XMLHttpRequest();
  search.open("POST","fetchSearchResults.php");
  search.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  search.send("searchQuery="+searchValue);
  search.onreadystatechange=feedback1;

}


function feedback1()
{
  if (search.readyState == 4 && search.status == 200) {
    if(search.response=="")
    {
      alert('La ricerca non ha prodotto risultati');
  }else{
    risultati=JSON.parse(search.response);
    lunghezza=Object.keys(risultati).length;
    //CANCELLO TUTTI GLI ARTICOLI VISUALIZZATI IN PRECEDENZA
    while(document.getElementsByClassName('film_wrap')[1]){
        document.body.removeChild(document.getElementsByClassName('film_wrap')[1]);
    }

    for(let i=0;i<lunghezza;i++){
      newArt=document.getElementsByClassName('film_wrap')[0].cloneNode(true);
      document.body.appendChild(newArt);
      newArt.className='film_wrap';
      newArt.childNodes[0].id='film';
      newArt.href='article.php'+'?id='+risultati[i]['id'];
      newArt.childNodes[0].childNodes[0].childNodes[1].innerHTML=risultati[i]['name']+" "+risultati[i]['lastname'];
      newArt.childNodes[0].childNodes[0].childNodes[2].innerHTML=risultati[i]['data'];
      newArt.childNodes[0].childNodes[0].childNodes[4].innerHTML=risultati[i]['price'];
      newArt.childNodes[0].childNodes[1].childNodes[0].style.backgroundImage = "url('"+risultati[i]['imgPath']+"')";
      newArt.childNodes[0].childNodes[1].childNodes[1].childNodes[0].innerHTML=risultati[i]['title'];
      newArt.childNodes[0].childNodes[1].childNodes[1].childNodes[1].innerHTML=risultati[i]['body'];
  }
  }
}
}
  document.getElementsByClassName("tag")[0].addEventListener("click",function(){fetch(2,this.dataset.catCode);},false);
  document.getElementsByClassName("tag")[1].addEventListener("click",function(){fetch(2,this.dataset.catCode);},false);
  document.getElementsByClassName("tag")[2].addEventListener("click",function(){fetch(2,this.dataset.catCode);},false);
  document.getElementsByClassName("tag")[3].addEventListener("click",function(){fetch(2,this.dataset.catCode);},false);
  document.getElementsByClassName("tag")[4].addEventListener("click",function(){fetch(2,this.dataset.catCode);},false);
  document.getElementsByClassName("tag")[5].addEventListener("click",function(){fetch(2,this.dataset.catCode);},false);
  document.getElementsByClassName("tag")[6].addEventListener("click",function(){fetch(2,this.dataset.catCode);},false);
  </script>
</body>
