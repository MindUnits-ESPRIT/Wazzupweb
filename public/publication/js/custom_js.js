/*$(function(){
    $('img').each(function(e){
        console.log("fgfgfg");
        var src = $(e).attr('src');
        $(e).hover(function(){
            $(this).attr('src', src.replace('.gif', '../../public/publication/img/mouhib_pfp.gif'));
        }, function(){
            $(this).attr('src', asset('../../public/publication/img/mouhib_pfp.jpg'));
        });
    });
});*/
$(document).ready(function()
{
    $("#imgAnimate").hover(
        function()
        {
            $(this).attr("src","C:/xampp/htdocs/Wazzupweb/public/publication/img/mouhib_pfp.gif");
        },
        function()
        {
            $(this).attr("src", "C:/xampp/htdocs/Wazzupweb/public/publication/img/mouhib_pfp.jpg");
        });
});
function delPub(id)
{
    console.log("publication"+id);
    // document.getElementById('DeleteExec').href="/delete/"+id;
    $("#DeleteExec").attr("href","/publication/delete/"+id);
}

function editPub(id)
{
    //console.log("publication"+id);
    document.getElementById("editForm").action="/publication/"+id+"/editLE";
    $('#dark').on('shown.bs.modal', function () {
        var modal = $(this);
        $.ajax('/publication/'+id+'/editL', {
            success: function (data) {
                modal.find('.modal-body').html(data);
            }
        });
    });
}

function SigPub()
{
    x=document.querySelector('input[name="group1"]:checked').value;
     console.log("allooo");
  //  $("#SignalExec").attr("href","/publication/signaler/new/"+id_p+"/"+x);
        location.href="/publication/signaler/new/"+id_p+"/"+x;
}
function RedirectToEdit()
{
    location.href="/edit/profile";
}
function CountT()
{
    x=document.getElementById("publication_description").value.length+1;
    document.getElementById("char-count").innerText=x;
    console.log(x);
}
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imgPreviewPost').attr('src', e.target.result).show();
        };

        reader.readAsDataURL(input.files[0]);
    }
}
function GifLoadOpener()
{
   if( $('.gifcardload').is(":visible"))
   {  $('.gifcardload').hide();$("#imgContainer").empty();$("#GifSearcher").val("");
   }
   else
       $('.gifcardload').show();
}
