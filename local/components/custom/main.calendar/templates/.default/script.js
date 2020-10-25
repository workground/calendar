var calendar = {
    params: {},
    init: function (param) {
        this.params = param;
    },
    deleteTask: function (that, date, key) {
        var data = {
            date: date,
            key: key,
            SITE_ID: this.params.SITE_ID,
        };
        BX.showWait();
        var request = this.makeAjax(data, 'deleteTask');
        request.done(function (response) {
            BX.closeWait();
            $(that).parent().remove();
        });
    },
    addTask: function (event) {
        event.preventDefault();
        var data = {
            date: $('#date_input').val(),
            text: $('#task_input').val(),
            SITE_ID: this.params.SITE_ID,
        };
        var request = this.makeAjax(data, 'addTask');
        request.done(function (response) {
            BX.closeWait();
            if (response.data.res == 'ok') {
                $('#task_input').val('');
                $('.cell_' + response.data.date).append('<div class="label-task">' + response.data.text + '<span class="del" onclick="calendar.deleteTask(this);">x</span></div>');
            } else {
                alert("Ошибка записи!");
            }
        });
    },
    makeAjax: function (data, action) {
        var query = {
            c: this.params.componentName,
            action: action,
            mode: 'class'
        };
        return $.ajax({
            url: '/bitrix/services/main/ajax.php?' + $.param(query, true),
            method: 'POST',
            data: data
        });
    }
};