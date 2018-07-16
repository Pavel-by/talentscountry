<script type="text/javascript">
    function TaskPicker(tasks) {
        var chosen = {};
        var resultBlock = null;
        var message = new Message({
            header: "Выберите конкурсы",
            buttons: [
                {
                    val: "Сохранить",
                    click: function() {
                        message.hide();
                        update();
                    },
                    style: Message.STYLE_BRIGHT
                }
            ],
            onClose: function() {
                update();
            }
        });

        this.show = function () {
            show();
        };

        this.hide = function() {
            hide();
        };

        this.setResultBlock = function(block) {
            resultBlock = block;
            update();
        };

        this.update = function() {
            update();
        };

        this.getChosen = function() {
            return chosen;
        };

        this.setChosen = function(newChosen) {
            chosen = newChosen;
        };

        function update() {
            if (resultBlock == null) return false;
            if (Object.keys(chosen).length == 0) {
                resultBlock.innerHTML = "<p>Вы не выбрали ни одного конкурса для участия</p>"
                return;
            }
            var text = "<table class='content-table'>"
                + "<tr class='bold'>"
                + "<td>Название конкурса</td>"
                + "</tr>";
            for (i in chosen) {
                var value = chosen[i];
                text += "<tr>"
                    + "<td>" + value + "</td>"
                    + "</tr>";
            }

            text += "</table>";
            resultBlock.innerHTML = text;
        }

        function hide() {
            message.hide();
        }

        function show() {
            var root = $("<div class='flex-block flex-column flex-left'>");

            for (var i = 0; i < tasks.length; i++) {
                root.append(createButton(tasks[i]));
            }

            message.setContent(root);
            message.show();

            function createButton(taskInfo) {
                var root = $("<div class=\'flex-block flex-row flex-middle flex-left task-picker-competition\'>\n    <p class=\'task-picker-competition-name\'>" + taskInfo['rus'] + "</p>\n</div>");
                root.click(function () {
                    if (taskInfo['eng'] in chosen) {
                        $(this).removeClass('chosen');
                        delete chosen[taskInfo['eng']];
                    } else {
                        $(this).addClass('chosen');
                        chosen[taskInfo['eng']] = taskInfo['rus'];
                    }
                });
                if (taskInfo['eng'] in chosen) {
                    root.addClass('chosen')
                }
                return root;
            }
        }
    }


</script>