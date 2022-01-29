ClassicEditor
    .create( document.querySelector( '#sixteen' ), {} )
    .then( editor => { window.editor = editor; } )
    .catch( err => { console.error( err.stack ); } );

function insert() {
    $(function(){
      $(".five").load("updateBio.php"); 
    });
}

function preview(k, flag) {
    if( k.files[0] ) {                
        var name = k.files[0].name;
        var extension = name.replace(/^.*\./, '');
        var size = k.files[0].size / (1024*1024);
        if( size<=10 && (extension == 'png' || extension == 'jpg' || extension == 'jpeg' || extension == 'webp') ) {
            var reader = new FileReader();
            if( flag==0 )
                reader.onload = function(e) { document.querySelector("#seven").setAttribute("src", e.target.result); };
            else if( flag==1 )
                reader.onload = function(e) { document.querySelector("#eight").setAttribute("src", e.target.result); };
            else if( flag==2 )
                reader.onload = function(e) { document.querySelector("#twentysix").setAttribute("src", e.target.result); };

            reader.readAsDataURL(k.files[0]);
        }
    }
}

var check = 0;

function R(e, flag) {
    if( !flag ) check = 0;

    var f = e.innerHTML.trim();
    document.getElementById(f).setAttribute("value", 0);
    document.querySelector("input[name="+f+"]").setAttribute("value", 0);
    e.parentNode.removeChild(e);
}

function TrackC(e) {
    var f = e.innerHTML.trim();
    if( document.getElementById(f).getAttribute("value")=="0" && check==0 ) {
        check = 1;

        document.getElementById(f).setAttribute("value", 1);
        document.querySelector("input[name="+f+"]").setAttribute("value", 1);
        document.getElementById("twentyseven").innerHTML += "<span onclick='R(this,0)' class='category' style='background-color:black; cursor: pointer'>" + e.innerHTML + "</span>";
    }
}

function TrackT(e) {
    var f = e.innerHTML.trim();
    if( document.getElementById(f).getAttribute("value")=="0" ) {
        document.getElementById(f).setAttribute("value", 1);
        document.querySelector("input[name="+f+"]").setAttribute("value", 1);
        document.getElementById("twentyseven").innerHTML += "<span onclick='R(this,1)' class='category' style='cursor: pointer'>" + e.innerHTML + "</span>";  ;
    }
}