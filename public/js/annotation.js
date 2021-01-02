var answers = [];

const distortions = [];
distortions["step2"] = "substitution";
distortions["step3"] = "omission";
distortions["step4"] = "addition";

const nexts = [];
nexts["step2"] = ["step3", 2];
nexts["step3"] = ["step4", 3];
nexts["step4"] = ["step5", 4];

$(document).ready(function() {
    // ensure the current segment is highlighted
    $('#src-preview').scrollTop(Math.max(0, $('#src-current').position().top - 40));
    $('#trg-preview').scrollTop(Math.max(0, $('#trg-current').position().top - 40));

    $("#annotation-process").accordion();
    // TODO: uncomment
    //$('#submit-panel').hide();

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

    /* Step 1 */
    $('#q_st1_n').click(function () {
        enableSubmit();
        removeAddSelection($('#q_st1_y'), $('#q_st1_n'))
        disableNext($('#next_st1'));
        disableStep($('#step2'));
        answers["q_st1"] = "no";
        checkSubmitButton();
    });

    $('#q_st1_y').click(function () {
        disableSubmit();
        removeAddSelection($('#q_st1_n'), $('#q_st1_y'));
        enableNext($('#next_st1'));
        enableStep($('#step2'));
        answers["q_st1"] = "yes";
        checkSubmitButton();
    });

    $('#next_st1').click(function () {
        $( "#annotation-process" ).accordion( "option", "active", 1 );
    });

    /* Step 2-4 */

    $('.step-yes-no').click(function() {
        let id = $(this).attr('id');
        let question = id.slice(0, -2);
        let type = id.slice(-1);
        let step = $(this).parents('.step').attr('id');
        console.log("Values:", id, question, type, step);

        if(type == "n") {
            removeAddSelection($('#' + question + '_y'), $('#' + question + '_n'));
            answers[question] = "no";
            $('#' + step + '_extra_info').addClass('disabled');
        } else {
            removeAddSelection($('#' + question + '_n'), $('#' + question + '_y'));
            answers[question] = "yes";
            $('#' + step + '_extra_info').removeClass('disabled');
        }
        enableSubmit();
        checkSubmitButton();
        checkNextButton($('#next_' + step), answers[question], [distortions[step] + "-distortion-rate", step + "_explanation"],
            $('#' + nexts[step][0]));
    });

    $('.distortion-rate').change(function () {
        let id = $(this).parents('.step').find('.step-yes-no')[0].id;
        let question = id.slice(0, -2);
        let step = $(this).parents('.step').attr('id');
        answers[distortions[step] + "-distortion-rate"] = $(this).val();
        checkSubmitButton();
        checkNextButton($('#next_' + step), answers[question], [distortions[step] + "-distortion-rate", step + "_explanation"],
            $('#' + nexts[step][0]));
    });

    $('.explanation').on("keydown focusout", function () {
        let id = ($(this).parents('.step').find('.step-yes-no'))[0].id;
        let question = id.slice(0, -2);
        let step = $(this).parents('.step').attr('id');
        answers[step + "_explanation"] = $(this).val();
        checkSubmitButton();
        checkNextButton($('#next_' + step), answers[question], [distortions[step] + "-distortion-rate", step + "_explanation"],
            $('#' + nexts[step][0]));
    });

    $('.next').click(function () {
        let step = $(this).parents('.step').attr('id');
        console.log("Activating", nexts[step][1])
        $( "#annotation-process" ).accordion( "option", "active", nexts[step][1] );
    });
});

/* Submit button */
function enableSubmit() {
    $('#submit-panel').show();
}

function disableSubmit() {
    //$('#submit-panel').hide();
    $('#submit-panel').show();
}

/**
 * Determines whether to enable or disable the next button. It checks the value of variable question and
 * whether the values are defined.
 * @param button
 * @param question
 * @param values
 * @param step
 */
function checkNextButton(button, question, values, step) {
    if(question == "no") {
        enableNext(button);
        enableStep(step);
    } else {
        var flag = true;
        var value;
        for(value of values) {
            console.log("Checking", value);
            if(! (value in answers))  {
                flag = false;
                console.log("No");
            }
        }

        if(flag) {
            enableNext(button);
            enableStep(step);
        } else {
            disableNext(button);
            disableStep(step);
        }
    }

}

/* Simple enable/disable functions */
function enableNext(element) {
    element.prop('disabled', false);
}

function disableNext(element) {
    element.prop('disabled', true);
}

function enableStep(element) {
    element.removeClass('disabled');
}

function disableStep(element) {
    element.addClass('disabled');
}

/* Yes no buttons */
function removeAddSelection(el1, el2) {
    removeSelection(el1);
    addSelection(el2);
}

function removeSelection(element) {
    element.removeClass('highlighted');
}

function addSelection(element) {
    element.addClass('highlighted');
}

/* Submit button */
function checkSubmitButton() {
    console.log(answers);
}