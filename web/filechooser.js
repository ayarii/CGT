function deletemedia(elem)
{
    var index = $(elem).attr('data-id');
    console.log(index);
    function check(index)
    {
        if(media.id != index)
            return media;
    }
    var result=mediaarrayfilter(check);
    mediaarray=result;
    var bye='#'+index;
    $(bye).remove();
}
function addmediatopost()
{
    $("#src").trigger("click");
}

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
/*var openFile = function(event) {
    var input = event.target;

    var reader = new FileReader();
    reader.onload = function () {
        var mediaElements = document.querySelectorAll('.card-img-top');
        var source = this.result;
        filecontainer.push(source);
        var ext = source.split('.').pop().toLowerCase();
        var cardphoto = '<div class="video-box" id="#0"> \n' +
            '<div class="video-box-cover popup-video-trigger">\n' +
            '<figure class="video-box-cover-image liquid" >\n' +
            '<img id="img-post"src=""alt="image" > \n'+
        '<video id="video-post" src=""alt="video" style="display:none"></video> \n'+
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
        '<div class="video-box-info"><textarea id="ff"name="description"class="video-box-title" placeholder="Légende"></textarea>  \n' +
        '<p class="video-box-text"></p>\n' +
        '</div>\n' +
        '</div>';
        $("#gallerie").data('index', $("#gallerie").find('.video-box').length);
        var index = $("#gallerie").data('index');

        cardphoto = cardphoto.replace('#0', index);
        cardphoto = cardphoto.replace('#00', index);
        cardphoto = cardphoto.replace('ff', "i" + index);
        cardphoto = cardphoto.replace('pp', "file" + index);
        cardphoto = cardphoto.replace('img-post', "img" + index);
        cardphoto = cardphoto.replace('video-post', "vid" + index);
        $('#gallerie').append(cardphoto);
        if (ext != "mp4") {
            $("#img" + index).css("display", "block");
            $("#img" + index).src(this.result);
        } else {
            {
                $("#vid" + index).css("display", "block");
                $("#vid" + index).src(this.result);
            }
            $("#gallerie").data('index', index + 1);
            var s = $("#src").val();
            console.log(s);
            var mediatype = s.split('.').pop().toLowerCase();
            console.log(mediatype);
            var mt = "";
            if (mediatype == 'mp4') {
                mt = "video";

            } else {
                mt = "image";
            }
            var index = $("#gallerie").data('index');
            var legend = $("#i" + index).val();
            var res = s.split('\/').pop();
            var srec = filecontainer[filecontainer.length - 1];
            var m = new media(this.result, legend, "post", mt);
            mediacontainer.push(m);
            for (var i = 0; i < mediacontainer.length; i++) {
                console.log(mediacontainer[i].src);
                console.log(mediacontainer[i].legende);
                console.log(mediacontainer[i].mediatype);
            }
        }
        ;

        reader.readAsDataURL(input.files[0]);

    };
}*/
class media
{
    constructor(src,description2,type,mediatypo,name,mime)
    {   this.name=name,
        this.src = src;
        this.legende=description2;
        this.type=type;
        this.mediatype=mediatypo;
        this.mime=mime;
    }


}
/*function addnewpost()
{   $("#formnewpost").submit();
    var newwera=JSON.stringify(mediaarray);
    var contenu=$('#new-post-content').val();
    var titre=$('#new-post-title').val();
    var content=contenu;
    var title=titre;
    $.ajax({
        type:"POST",
        url: "/addnewpost",
        data: {mediaarray:newwera,content:content,title:title},
        dataType: "json",
        processData: true,
        success: function(){
            $("#formnewpost").submit();
        }

    });
    mediaarray=[];
    filecontainer=[];
}*/
var mediaarray= [];
var filecontainer=[];

function openFile(event) {
    const input = event.target;
    const fichier = input.files[0];
    filecontainer.push[fichier];
    if (fichier) {
        var reader = new FileReader();
        reader.onload = function () {
            var source = this.result;
            var ext = source.split('.').pop().toLowerCase();
            var cardphoto = '<div class="video-box" id="#0"> \n' +
                '<div class="close"> ' +
                '<a onclick="deletemedia(this)" data-id="#00">\n' +
                '<i class="fa fa-remove">\n' +
                '</i> \n' +
                '</a > \n' +
                '</div> \n' +
                '<div class="video-box-cover popup-video-trigger">\n' +
                '<figure class="video-box-cover-image liquid" id="momo" >\n' +
                '<img id="img-post"src=""alt="image" > \n'+
                '<video id="video-post" src=""alt="video" style="display:none"></video> \n'+
                '</figure> \n' +
                '<a > \n' +
                '<i class="fa fa-edit"> \n' +
                '</i> \n' +
                '</a >\n' +
                '</div> \n' +
                '<div class="video-box-info"><textarea id="ff"name="description"class="video-box-title" placeholder="Légende"></textarea>  \n' +
                '<p class="video-box-text"></p>\n' +
                '</div>\n' +
                '</div>';
            $("#gallerie").data('index', $("#gallerie").find('.video-box').length);
            var index = $("#gallerie").data('index');
            cardphoto = cardphoto.replace('#0', index);
            cardphoto = cardphoto.replace('#00', index);
            cardphoto = cardphoto.replace('ff', "i" + index);
            cardphoto = cardphoto.replace('pp', "file" + index);
            cardphoto = cardphoto.replace('momo', "tonysosa" + index);
            cardphoto = cardphoto.replace('img-post', "img" + index);
            cardphoto = cardphoto.replace('video-post', "vid" + index);
            $('#gallerie').append(cardphoto);
            if (ext != "mp4") {
                $("#img" + index).css("display", "block");
                $("#img" + index).attr('src',this.result);}
            else {
                    $("#vid" + index).css("display", "block");
                    $("#vid" + index).src(this.result);
                  }
            $("#gallerie").data('index', index + 1);

            var s = $("#src").val();
            console.log(s);
            var mediatype = s.split('.').pop().toLowerCase();
            console.log(mediatype);
            var mt = "";
            if (mediatype == 'mp4') {
                mt = "video";

            } else {
                mt = "image";
            }
            var index = $("#gallerie").data('index');
            var legend = $("#i" + index).val();
            var res = s.split('\/').pop();
            var name=s;
            var mime=mediatype;
            var m = new media(input.files[0], legend, "post", mt,name,mime);
            mediaarray.push(m);
            for (var i = 0; i < mediaarray.length; i++) {
                console.log(mediaarray[i].src);
                console.log(mediaarray[i].legende);
                console.log(mediaarray[i].mediatype);
            }

        }
        reader.readAsDataURL(fichier);
    }
}
function createformdata(){
    var form=new FormData();
    var i=0;
    var contenu=$('#new-post-content').val();
    var titre=$('#new-post-title').val();
    var content=contenu;
    var title=titre;
    form.append('titredupub',title);
    form.append('contenudupub',contenu);
    for(i;i<mediaarray.length;i++)
    {var name='media'+i;
     var media=JSON.stringify(mediaarray[i]);
     var file=mediaarray[i].src;
     var filename='file'+i;
     form.append(name,media);
     form.append(filename,file);
    }
    form.append('number',mediaarray.length);
    return form;
}
function addnewpost()
{   var form=new FormData();
    form=createformdata();
    $.ajax({
        type:"POST",
        url: "/addnewpost",
        data:form,
        contentType:false,
        processData:false,
        cache:false,
        dataType:"json",
        success: function(){
            $("#formnewpost").submit();
        }

    });
    mediaarray=[];
    filecontainer=[];
}
/*tired to rewrite the prototype */
/*change name cuz of cache of console*/
function imagescreening(event)
{
    const input = event.target;
    const fichier = input.files[0];
    filecontainer.push[fichier];
    if (fichier) {
        var reader = new FileReader();
        reader.onload = function () {
            var source = this.result;
            var ext = source.split('.').pop().toLowerCase();
            var cardphoto = '<div class="upload-item" id="#0"> \n' +
                ' <figure class="upload-item-image liquid" style="background: url(&quot;' + this.result + '&quot;) center center / cover no-repeat;">\n' +
                '<img id="img-edit-post"src="" style="display: none;">\n' +
                '<video id="video-edit-post" src="" style="display:none;"></video> \n'+
                '</figure>\n' +
                '<div class="form-input small">\n' +
                '<textarea id="momo" name="album_photo_description_" value=""></textarea>\n' +
                ' </div>\n' +
                '<div class="checkbox-wrap small">\n' +
                '<input type="radio" id="#00" name="album_set_photo_cover" value="cover-01" checked="">\n' +
                '<a onclick="deletemedia()"><i class="fa fa-minus-circle"></i></a>\n'+
                '<div class="checkbox-box">\n' +
                '<svg class="icon-cross">\n' +
                ' <use xlink:href="#svg-cross"></use>\n' +
                '</svg>\n' +
                '</div>\n' +
                '<label for="album-set-photo-cover-'+i+'">Set as album cover</label>\n' +
                '</div>\n' +
                '</div>';
            $("#uploadlist").data('index', $("#uploadlist").find('.upload-item').length);
            var index = $("#uploadlist").data('index');
            cardphoto = cardphoto.replace('#0', index);
            cardphoto = cardphoto.replace('#00', index);
            cardphoto = cardphoto.replace('album_photo_description_', "album_photo_descriptionnew_" + index);
            cardphoto = cardphoto.replace('album_set_photo_cover', "album_set_photo_cover" + index);
            cardphoto = cardphoto.replace('momo', "tonysosa" + index);
            cardphoto = cardphoto.replace('img-edit-post', "img" + index);
            cardphoto = cardphoto.replace('video-edit-post', "vid" + index);
            $('#uploadlist').append(cardphoto);
            if (ext != "mp4") {
                $("#img" + index).css("display", "block");
                $("#img" + index).attr('src',this.result);}
            else {
                $("#vid" + index).css("display", "block");
                $("#vid" + index).src(this.result);
            }
            $("#uploadlist").data('index', index + 1);

            var s = $("#src").val();
            console.log(s);
            var mediatype = s.split('.').pop().toLowerCase();
            console.log(mediatype);
            var mt = "";
            if (mediatype == 'mp4') {
                mt = "video";

            } else {
                mt = "image";
            }
            var index = $("#uploadlist").data('index');
            var legend = $("#tonysosa" + index).val();
            var res = s.split('\/').pop();
            var name=s;
            var mime=mediatype;
            var m = new media(input.files[0], legend, "post", mt,name,mime);
            mediaarray.push(m);
            for (var i = 0; i < mediaarray.length; i++) {
                console.log(mediaarray[i].src);
                console.log(mediaarray[i].legende);
                console.log(mediaarray[i].mediatype);
            }

        }
        reader.readAsDataURL(fichier);
    }
}
function createeditformdata(){
    var form=new FormData();
    var i=0;
    var contenu=$('#Contenuedit-Form').val();
    var titre=$('#titlepub').val();
    var content=contenu;
    var title=titre;
    form.append('titredupubmodif',title);
    form.append('contenudupubmodif',contenu);
    for(i;i<mediaarray.length;i++)
    {var name='media'+i;
        var media=JSON.stringify(mediaarray[i]);
        var file=mediaarray[i].src;
        var filename='file'+i;
        form.append(name,media);
        form.append(filename,file);
    }
    form.append('number',mediaarray.length);
    return form;
}
var divclone123=$("#formnewpost").clone();
if($("#addnewpost").is(':hidden')){$("#addnewpost").replaceWith(divclone123.clone().clone());console.log('bo3');}

var divclone1234=$("#Posteditt").clone();

function MediaDelete(idmedia)
{
   $("#"+idmedia).remove();
}
function MediaEdit(idmedia) {

}