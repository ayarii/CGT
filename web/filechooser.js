function deletemedia(elem)
{
    var index = $(elem).attr('data-id');
    console.log(index);
    function check(index)
    {
        if(media.id != index)
            return media;
    }
    var result=mediacontainer.filter(check);
    mediacontainer=result;
    var bye='#'+index;
    $(bye).remove();
}
function addmediatopost()
{
    $("#src").trigger("click");
}
/*grid grid-3-3-3-3 centered anyClass
function(event){
var input = event.target;
var reader = new FileReader();
reader.onload = function(){
    var dataURL = reader.result;
    var type=detectfiletype(dataURL);
    if (type != "none") {
        console.log("yes type is no none");
        var mediaElements = document.querySelectorAll('.card-img-top');
        if (type == "mp4") {
            console.log("yes type is mp4");
            const mediacard=document.createElement("div");
            mediacard.classList.add("card");
            const video=document.createElement("video");
            video.classList.add("card-img-top");
            video.attr('alt',"video");
            const cardbody=document.createElement("div");
            cardbody.classList.add("card-img-overlay");
            const cardtitle=document.createElement("h6");
            cardtitle.classList.add("card-title");
            const cardtext=document.createElement("p");
            cardtext.classList.add("card-text");
            const deleteme=document.createElement("a");
            deleteme.classList.add("btn btn-primary");
            cardbody.appendChild(cardtitle);
            cardbody.appendChild(cardtext);
            cardbody.appendChild(deleteme);
            mediacard.appendChild(video);
            mediacard.appendChild(cardbody);
            $('#gallerie').appendChild(mediacard);
            console.log("added card");
            for (var i = 0; i < mediaElements.length; i++)
                mediaElements[i].id = 'media-' + i;
            $("media-"+mediaElements.length).src(dataURL);

        }
        else{
            const mediacard=document.createElement("div");
            mediacard.classList.add("card");
            const video=document.createElement("img");
            video.classList.add("card-img-top");
            video.attr('alt',"video");
            const cardbody=document.createElement("div");
            cardbody.classList.add("card-img-overlay");
            const cardtitle=document.createElement("h6");
            cardtitle.classList.add("card-title");
            const cardtext=document.createElement("p");
            cardtext.classList.add("card-text");
            const deleteme=document.createElement("a");
            deleteme.classList.add("btn btn-primary");
            cardbody.appendChild(cardtitle);
            cardbody.appendChild(cardtext);
            cardbody.appendChild(deleteme);
            mediacard.appendChild(video);
            mediacard.appendChild(cardbody);
            $('#gallerie').appendChild(mediacard);

            for (var i=0;i < mediaElements.length; i++)
            {mediaElements[i].id = 'media-' + i;}
            $("media-"+mediaElements.length).src(dataURL);

        }
    }
};
console.log(input.files);
reader.readAsDataURL(input.files);
}*/
/*         if(source!="")
    { var type=detectfiletype(source);
      if (type != "none") {
            console.log("yes type is no none");
            var mediaElements = document.querySelectorAll('.card-img-top');
            if (type == "mp4") {
                console.log("yes type is mp4");
                const mediacard=document.createElement("div");
                mediacard.classList.add("card");
                const video=document.createElement("video");
                video.classList.add("card-img-top");
                video.attr('alt',"video");
                for (var i = 0; i < mediaElements.length; i++)
                    mediaElements[i].id = 'media-' + i;
                const cardbody=document.createElement("div");
                cardbody.classList.add("card-img-overlay");
                const cardtitle=document.createElement("h6");
                cardtitle.classList.add("card-title");
                const cardtext=document.createElement("p");
                cardtext.classList.add("card-text");
                const deleteme=document.createElement("a");
                deleteme.classList.add("btn btn-primary");
                cardbody.appendChild(cardtitle);
                cardbody.appendChild(cardtext);
                cardbody.appendChild(deleteme);
                mediacard.appendChild(video);
                mediacard.appendChild(cardbody);
                $('#gallerie').appendChild(mediacard);
                console.log("added card");
                previewFiles();


            }
            else{
                const mediacard=document.createElement("div");
                mediacard.classList.add("card");
                const video=document.createElement("img");
                video.classList.add("card-img-top");
                for (var i=0;i < mediaElements.length; i++)
                {mediaElements[i].id = 'media-' + i;}
                const cardbody=document.createElement("div");
                cardbody.classList.add("card-img-overlay");
                const cardtitle=document.createElement("h6");
                cardtitle.classList.add("card-title");
                const cardtext=document.createElement("p");
                cardtext.classList.add("card-text");
                const deleteme=document.createElement("a");
                deleteme.classList.add("btn-primary");
                deleteme.classList.add("btn");
                cardbody.appendChild(cardtitle);
                cardbody.appendChild(cardtext);
                cardbody.appendChild(deleteme);
                mediacard.appendChild(video);
                mediacard.appendChild(cardbody);
                $('#gallerie').append(mediacard);
                previewFiles();
                console.log(source);
            }
        }
     console.log(source);
     console.log(type);}*/
function detectfiletype(source)
{   var hah="none";
    var ext = source.split('.').pop().toLowerCase();
    if($.inArray(ext, ['gif','png','jpg','jpeg','mp4']) == -1) {
        alert('invalid extension!');
        return hah;
    }
    else
    {
        return ext;
    }

}
var openFile = function(event) {
    var input = event.target;

    var reader = new FileReader();
    reader.onload = function(){
        var mediaElements = document.querySelectorAll('.card-img-top');
        source=this.result;
        var ext = source.split('.').pop().toLowerCase();
        if(ext!="mp4")
        {
            var nimage ='<img src="coco"alt="image" > \n'
            nimage=nimage.replace("coco",this.result);
        }
        else{
            var nimage ='<video src="coco"alt="video" ></video> \n'
            nimage=nimage.replace("coco",this.result);
        }
        /* const mediacard=document.createElement("div")
         mediacard.classList.add("card");
         const video=document.createElement("img");
         video.classList.add("card-img-top");
         const cardbody=document.createElement("div");
         cardbody.classList.add("card-img-overlay");
         const cardtitle=document.createElement("h6");
         cardtitle.classList.add("card-title");
         const cardtext=document.createElement("p");
         cardtext.classList.add("card-text");
         const deleteme=document.createElement("a");
         deleteme.classList.add("btn-light");
         deleteme.classList.add("btn");
         const legende=document.createElement("input");
         legende.setAttribute('type','text');
         const label=document.createElement("label");
         cardbody.appendChild(cardtitle);
         cardbody.appendChild(cardtext);
         cardbody.appendChild(deleteme);
         mediacard.appendChild(image);
         mediacard.appendChild(legende);
         mediacard.appendChild(label);
         mediacard.appendChild(cardbody);*/
        var cardphoto='<div class="video-box" id="#0"> \n' +
            '<div class="video-box-cover popup-video-trigger">\n' +
            '<figure class="video-box-cover-image liquid" style="background: url("img/cover/08.jpg") center center / cover no-repeat;">\n' +
            nimage+
            '</figure> \n' +
            '<a onclick="deletemedia(this)" data-id="#00"> \n' +
            '<i class="fa fa-remove"> \n' +
            '</i> \n' +
            '</a >\n' +
            '<a > \n' +
            '<i class="fa fa-edit"> \n' +
            '</i> \n' +
            '</a >\n' +
            '</div> \n' +
            '<input type="file"  id="pp"/>'
        '<div class="video-box-info"><textarea id="ff"name="description"class="video-box-title" placeholder="Légende"></textarea>  \n' +
        '<p class="video-box-text"></p>\n' +
        '</div>\n' +
        '</div>';
        $("#gallerie").data('index',$("#gallerie").find('.video-box').length);
        var index = $("#gallerie").data('index');

        cardphoto=cardphoto.replace('#0',index);
        cardphoto=cardphoto.replace('#00',index);
        cardphoto=cardphoto.replace('ff',"i"+index);
        cardphoto=cardphoto.replace('pp',"file"+index);
        $('#gallerie').append(cardphoto);
        $("#gallerie").data('index', index + 1);
    };

    reader.readAsDataURL(input.files[0]);

    var s=$("#src").val();
    console.log(s);
    var mediatype=s.split('.').pop().toLowerCase();
    console.log(mediatype);
    var mt="";
    if(mediatype =='mp4')
    {
        mt="video";

    }
    else
    {
        mt="image";
    }
    var index = $("#gallerie").data('index');
    var legend= $("#i"+index).val();
    var res = s.split('\/').pop();
    var m=new media(this.result,legend,"post",mt);
    mediacontainer.push(m);
    for(var i=0;i<mediacontainer.length;i++)
    {
        console.log(mediacontainer[i].src);
        console.log(mediacontainer[i].legende);
        console.log(mediacontainer[i].mediatype);
    }

};
class media
{
    constructor(src,legende,type,mediatype)
    {
        this.src = src;
        this.legende=legende;
        this.type=type;
        this.mediatype=mediatype;
    }


}
function addnewpost()
{     var newwera=JSON.stringify(mediacontainer);
    $.ajax({
        type:"POST",
        url: "/addnewpost",
        data: {mediacontainer:newwera},
        success: function(){
            $("#formnewpost").submit();
        }

    });
    mediacontainer=[];
}

var mediacontainer= [];