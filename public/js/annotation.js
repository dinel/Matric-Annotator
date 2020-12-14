var actions = [];

actions['q1'] = ['answer1', 'q2'];
actions['q2'] = ['answer2', 'q3'];
actions['q3'] = ['answer3', null];

var selection = null;

$(document).ready(function() {
    $('.question-block').slice(1).hide();
    $('#submit-panel').hide();

    $('#src-preview').scrollTop(Math.max(0, $('#src-current').position().top - 40));
    $('#trg-preview').scrollTop(Math.max(0, $('#trg-current').position().top - 40));

    $( "#tabs" ).tabs({
        disabled: [ 1, 2, 3 ],
        activate: function(event, ui) {
            initialise();
        }
    });

    $( "#accordion" ).accordion();

    $('.no').click(function () {
        highlight($(this));
        var id = actions[$(this).parent().parent().attr('id')];
        if(id[1] !== null) {
            $('#' + id[1]).show();
            removeHighlighting($('#' + id[1]));
        } else {
            selection = id[0] + "-no";
            enableSubmit();
        }
    });

    $('.yes').click(function () {
        highlight($(this));
        var id = actions[$(this).parent().parent().attr('id')];
        if(id[1] !== null) {
            $('#' + id[1]).find('.yes').trigger('click');
            $('#' + id[1]).hide();
        }
        selection = id[0] + "-yes";
        enableSubmit();
    });

    $('#swap-preview').click(function () {

        $.ajax({url: "/annotation/move-preview", success: function(result){
            if(left) {
                $('#preview-panel').insertAfter('#annotation-panel');
                left = false;
            } else {
                $('#preview-panel').insertBefore('#annotation-panel');
                left = true;
            }
        }});
    });
});

function highlight(element) {
    element.parent().children().removeClass('highlighted');
    element.addClass('highlighted');
}

function removeHighlighting(element) {
    element.find('.btn').removeClass('highlighted');
}

function enableSubmit() {
    $('#submit-panel').show();
}