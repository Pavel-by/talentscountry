<style type="text/css">
    .watcher-background {
        background-color: rgba(61, 61, 61, 0.49);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 200;
        -moz-user-select: none;
        -khtml-user-select: none;
        user-select: none;
    }
    
    .watcher-close-button {
        position: absolute;
        top: 30px;
        right: 30px;
        width: 30px;
        height: 30px;
        cursor: pointer;
        -moz-user-select: none;
        -khtml-user-select: none;
        user-select: none;
    }
    
    .watcher-image-background {
        background: black;
        position: absolute;
        width: 80%;
        height: 80%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        -moz-user-select: none;
        -khtml-user-select: none;
        user-select: none;
    }
    
    .watcher-image {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 100%;
        max-height: 100%;
        display: inline-block;
        -moz-user-select: none;
        -khtml-user-select: none;
        user-select: none;
    }
    
    .watcher-change-button {
        position: absolute;
        top: 0;
        height: 100%;
        width: 100px;
        background-color: rgba(0, 0, 0, 0.09);
        opacity: .3;
        transition: all .2s ease-out;
        -moz-transition: all .2s ease-out;
        -webkit-transition: all .2s ease-out;
        text-align: center;
        -moz-user-select: none;
        -khtml-user-select: none;
        user-select: none;
    }
    
    .watcher-change-button img {
        vertical-align: middle;
        padding: 0;
        margin: 0;
        display: inline-block;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 60px;
        -moz-user-select: none;
        -khtml-user-select: none;
        user-select: none;
    }
    
    .watcher-image-background:hover .watcher-change-button {
        opacity: .6;
    }
    
    .watcher-change-button:hover {
        opacity: 1 !important;
    }
    
    .watcher-left {
        left: 0;
    }
    
    .watcher-right {
        right: 0;
    }
</style>
<script type="text/javascript">
    function CreateImageWatcher(images, startIndex) {
        var globalBackground = document.createElement('div');
        globalBackground.className = "watcher-background";
        var imageBackground = document.createElement('div');
        imageBackground.className = "watcher-image-background";
        var image = document.createElement('img');
        image.className = "watcher-image";
        var leftButton = document.createElement("div");
        var leftButtonImage = "<img src='images/left-arrow.png'>";
        leftButton.innerHTML = leftButtonImage;
        leftButton.className = "watcher-change-button watcher-left";
        var rightButton = document.createElement("div");
        var rightButtonImage = "<img src='images/right-arrow.png'>";
        rightButton.innerHTML = rightButtonImage;
        rightButton.className = "watcher-change-button watcher-right";
        var closeButton = document.createElement("img");
        closeButton.src = "images/close.png";
        closeButton.className = "watcher-close-button";


        imageBackground.appendChild(image);
        imageBackground.appendChild(leftButton);
        imageBackground.appendChild(rightButton);
        globalBackground.appendChild(imageBackground);
        globalBackground.appendChild(closeButton);

        document.body.appendChild(globalBackground);

        globalBackground.addEventListener('click', function() {
            globalBackground.parentNode.removeChild(globalBackground);
        });

        var index = startIndex;
        image.src = images[index];
        leftButton.addEventListener("click", function() {
            index--;
            if (index < 0) {
                index = images.length - 1;
            }
            image.src = images[index];
        });
        rightButton.addEventListener("click", function() {
            index++;
            if (index >= images.length) {
                index = 0;
            }
            image.src = images[index];
        });
        imageBackground.addEventListener('click', function(ev) {
            ev.stopPropagation();
            ev.cancelBubble = true;
        });

    }
</script>