connectStyle();
function CreateMessage(headerText = "", messageText = "", canCloseByUser = true, callback = function(){}) {
    var link = this;

    document.body.style.overflow = "hidden";
    var background = document.createElement('div');
    background.className = "message-background";
    var body = document.createElement('div');
    body.className = 'message-body';
    var header = document.createElement('h2');
    header.className = 'message-header';
    var text = document.createElement('div');
    text.className = 'message-text';
    var buttonsLayout = document.createElement('div');

    body.appendChild(header);
    body.appendChild(text);
    body.appendChild(buttonsLayout);

    if (canCloseByUser) {
        var button = document.createElement('a');
        button.innerHTML = "✖";
        button.className = 'close-button';
        button.href = "#";
        buttonsLayout.appendChild(button);
        button.addEventListener('click', function() {
            closeMessage();
        });
        background.addEventListener('click', function() {
            closeMessage();
        });
    }
    background.appendChild(body);

    header.innerHTML = headerText;
    text.innerHTML = messageText;

    body.addEventListener('click', function(e) {
        e.preventDefault;
        e.cancelBubble = true;
    });
    document.body.appendChild(background);
    $(button).focus();

    this.Close = function() {
        closeMessage();
        return null;
    };

    this.Update = function(newHeader, newMessage) {
        header.innerHTML = newHeader;
        text.innerHTML = newMessage;
        return this;
    };

    function closeMessage() {
        callback(link);
        background.parentNode.removeChild(background);
        if (document.body.getElementsByClassName("message-background").length == 0) {
            document.body.style.overflow = "auto";
        }
    }

    this.root = background;
    this.body = text;
    this.buttons = buttonsLayout;
}

function connectStyle() {
    var link = document.createElement('link');
    link.rel = 'stylesheet';
    link.type = 'text/css';
    link.href = 'styles/message-style.css?ver=1.4';
    document.head.appendChild(link);
}