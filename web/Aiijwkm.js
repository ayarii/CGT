const voice = document.querySelector(".voice");
const voice2text = document.querySelector(".voice2text");

const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
const recorder = new SpeechRecognition();

function addHumanText(text) {
    const chatContainer = document.createElement("div");
    chatContainer.classList.add("chat-widget-speaker");
    chatContainer.classList.add("left");
    chatContainer.classList.add("chat-container");
    const chatBox = document.createElement("p");
    chatBox.classList.add("chat-widget-speaker-message");
    chatBox.classList.add("voice2text");
    const chatText = document.createTextNode(text);
    chatBox.appendChild(chatText);
    chatContainer.appendChild(chatBox);
    return chatContainer;
}

function addBotText(text) {
    const chatContainer1 = document.createElement("div");
    chatContainer1.classList.add("chat-widget-speaker");
    chatContainer1.classList.add("right");
    chatContainer1.classList.add("chat-container");
    chatContainer1.classList.add("darker");
    const chatBox1 = document.createElement("p");
    chatBox1.classList.add("chat-widget-speaker-message");
    chatBox1.classList.add("voice2text");
    const chatText1 = document.createTextNode(text);
    chatBox1.appendChild(chatText1);
    chatContainer1.appendChild(chatBox1);
    return chatContainer1;
}

function botVoice(message) {

    const speech = new SpeechSynthesisUtterance();
    speech.text="je n'arrive pas à vous comprendre"
    var haha=addBotText(speech.text);
    var coca=$(".voice").attr('data-id');
    if (message.includes('salut')) {
        speech.text = "salut, heureuse de te parler une autre fois!";
        haha=addBotText(speech.text);
    }
    if (message.includes('ça va')) {
        speech.text = "ça va bien et vous ";
        haha=addBotText(speech.text);
    }
    if (message.includes('bien')) {
        speech.text = "heureuse de savoir ça ,Comment je peux vous aider";
        haha=addBotText(speech.text);
    }
    if (message.includes('vote')) {
        speech.text = "VoiLa la publication qui a rempoté le plus de votes !";
        haha=addBotText(speech.text);
        var url = coca+"/yes";
        $.ajax({
            type:"GET",
            url:url,
            dataType: "json",
            processData: true,
            success:function(data){
                var card=document.createElement("div");
                card.classList.add("card");
                card.style.width="170px";
                var img=document.createElement("img");
                img.classList.add("card-img-top");
                var card1=document.createElement("div");
                card1.classList.add("card-body");
                var h5=document.createElement("h5");
                h5.classList.add("card-title");
                h5.classList.add("mama");
                var p=document.createElement("p");
                p.classList.add("card-text");
                p.classList.add("details");
                var texte='Titre: '+data['titre']+"Nb Votes: " +data['Votes'];
                const info = document.createTextNode(texte);
                p.appendChild(info);
                card1.appendChild(h5);
                card1.appendChild(p);
                card.appendChild(img);
                card.appendChild(card1);
                   img.src ='/uploads/img/'+data['contenue'];
                   $('.mama').html('POST');
                haha.append(card);

            }
        });}
    if (message.includes('événement')) {
        speech.text = "Voila Les evenement qui pourrait vous interesser ";
        var haha=addBotText(speech.text);
        var url = coca+"/evens";
        $.ajax({
            type:"GET",
            url:url,
            dataType: "json",
            processData: true,
            success:function(data){
                if(data['cout']!=null)
                {
                    var card=document.createElement("div");
                    card.classList.add("card");
                    card.style.width="170px";
                    var img=document.createElement("img");
                    img.classList.add("card-img-top");
                    var card1=document.createElement("div");
                    card1.classList.add("card-body");
                    var h5=document.createElement("h5");
                    h5.classList.add("card-title");
                    h5.classList.add("mama");
                    var p=document.createElement("p");
                    p.classList.add("card-text");
                    p.classList.add("details");
                    var texte='date limite:' +data['datef']+"cout:" +data['cout'];
                    const info = document.createTextNode(texte);
                    p.appendChild(info);
                    card1.appendChild(h5);
                    card1.appendChild(p);
                    card.appendChild(img);
                    card.appendChild(card1);
                    img.src ='template/img/cover/'+data['imgc'];
                    haha.append(card);

                }
                else
                {
                    var card=document.createElement("div");
                    card.classList.add("card");
                    card.style.width="170px";
                    var img=document.createElement("img");
                    img.classList.add("card-img-top");
                    var card1=document.createElement("div");
                    card1.classList.add("card-body");
                    var h5=document.createElement("h5");
                    h5.classList.add("card-title");
                    h5.classList.add("mama");
                    var p=document.createElement("p");
                    p.classList.add("card-text");
                    p.classList.add("details");
                    var texte='Aucun evenement Disponible Pour le moments ';
                    const info = document.createTextNode(texte);
                    p.appendChild(info);
                    card1.appendChild(h5);
                    card1.appendChild(p);
                    card.appendChild(img);
                    card.appendChild(card1);
                    img.src ='template/img/landing/404-bg.png';
                    haha.append(card);
                }
            }

        });
    }
    if (message.includes('Bonjour')) {
        speech.text = "Bounjour, heureuse de te parler une autre fois!";
        haha=addBotText(speech.text);
    }


    speech.volume = 1;
    speech.rate = 1;
    speech.pitch = 1;
    window.speechSynthesis.speak(speech);
    var element = document.getElementById("container");
    element.appendChild(haha);
}

recorder.onstart = () => {
    console.log('Voix Activé');
};

recorder.onresult = (event) => {
    const resultIndex = event.resultIndex;
    const transcript = event.results[resultIndex][0].transcript;
    var element = document.getElementById("container");
    element.appendChild(addHumanText(transcript));
    botVoice(transcript);
};

voice.addEventListener('click', () =>{
    recorder.start();
});
function setatt(elem)
{
    var coca=$(elem).attr('data-id');
    return coca;

}