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
    document.getElementById('DeleteExec').href="delete/"+id;
}

function editPub(id)
{
    console.log("publication"+id);
    location.href=id+"/edit";
}

function SigPub()
{
    x=document.querySelector('input[name="group1"]:checked').value;
    // console.log(x);
        document.getElementById('SignalExec').href="signaler/new/"+id_p+"/"+x;
}
