if (!window.BindFrontend) {
    BindFrontend = {};
}
BindFrontend.Ui = {};
BindFrontend.Ui.Actions = {};

BindFrontend.Ui.initCommonObjects = function(scope) {
    if (!scope) {
        scope = document.body;
    }

    $('.form-domain-input', scope).each(function(){$(this).tooltip({title:'Domain part (<a href="x">more info</a>)', delay: 1000, html: true})});
    $('.form-value-input', scope).each(function(){$(this).tooltip({title:'Value part (<a href="y">more info</a>)', delay: 1000, html: true})});
};

BindFrontend.Ui.initCommonObjects();


// Create

BindFrontend.Ui.createNewRecordAction = function (saveCallback, closeCallback, afterElement) {
    var template = $('#record-add-template');
    var html = template.html();

    var row = $('<tr>' + html + '</tr>');
    var removeNewRecordHandler = function () {
        row.remove();
        if (closeCallback) {
            closeCallback.call(row);
        }
    };
    var saveNewRecordHandler = function () {
        saveCallback.call(row);
        removeNewRecordHandler();
    };

    $('.form-cancel-button', row).click(removeNewRecordHandler);

    $('.form-save-button', row).click(saveNewRecordHandler);

    if (!afterElement) {
        template.parent().prepend(row);
    } else {
        afterElement.after(row);
    }
    BindFrontend.Ui.initCommonObjects(template.parent());

    row.find('input').first().focus();
    row.find('input, select, button').bind('keydown', 'esc', function () { removeNewRecordHandler(); return false; });
    row.find('input, select, button').bind('keydown', 'return', function () { saveNewRecordHandler(); return false; });

    return row;
};

BindFrontend.Ui.Actions.createNewRecord = function () {
    BindFrontend.Ui.createNewRecordAction(function() {alert('save new');});
};

$('#create-new-record').click(BindFrontend.Ui.Actions.createNewRecord);
$(document).bind('keydown', 'n', function () { BindFrontend.Ui.Actions.createNewRecord(); return false; });


// Remove
BindFrontend.Ui.removeRecordAction = function(row) {
    var id = row.children().first().text();
    var contents = row.children().eq(1).text() + '\t' + row.children().eq(2).text() +
        '\t' + row.children().eq(3).text();

    var modal = $('#modal-removal');
    $('.removal-record-id', modal).text(id);
    $('.removal-record-contents', modal).text(contents);
    modal.modal();
    var button = $('.removal-record-do');
    button.click(function() {alert('remove');});
    button.focus();
};
BindFrontend.Ui.Actions.removeRecord = function() {
    var row = $(this).parent().parent();
    BindFrontend.Ui.removeRecordAction(row);
};
BindFrontend.Ui.Actions.removePromptedRecord = function() {
    var n = prompt('number');
    var btn = $('.form-remove-button').eq(parseInt(n)-1);
    BindFrontend.Ui.Actions.removeRecord.call(btn);
};

$('.form-remove-button').click(BindFrontend.Ui.Actions.removeRecord);
$(document).bind('keydown', 'r', function () { BindFrontend.Ui.Actions.removePromptedRecord(); return false; });


// Edit

BindFrontend.Ui.editRecordAction = function(row) {
    var editRow = BindFrontend.Ui.createNewRecordAction(function() {alert('save');}, function() { row.show(); }, row);
    editRow.children().first().text(row.children().first().text());
    editRow.children().eq(1).children().first().val(row.children().eq(1).text());
    editRow.children().eq(2).children().first().val(row.children().eq(2).text());
    editRow.children().eq(3).children().first().val(row.children().eq(3).text());

    row.hide();
};

BindFrontend.Ui.Actions.editRecord = function() {
    var row = $(this).parent().parent();
    BindFrontend.Ui.editRecordAction(row);
};
BindFrontend.Ui.Actions.editPromptedRecord = function() {
    var n = prompt('number');
    var btn = $('.form-edit-button').eq(parseInt(n)-1);
    BindFrontend.Ui.Actions.editRecord.call(btn);
};

$('.form-edit-button').click(BindFrontend.Ui.Actions.editRecord);
$(document).bind('keydown', 'e', function () { BindFrontend.Ui.Actions.editPromptedRecord(); return false; });