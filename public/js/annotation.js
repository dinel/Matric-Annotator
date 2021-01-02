var answers = [];

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

    /* Step 2 */
    $('#q_st2_n').click(function () {
        enableSubmit();
        removeAddSelection($('#q_st2_y'), $('#q_st2_n'));
        $('#step2_extra_info').addClass('disabled');
        answers["q_st2"] = "no";
        checkSubmitButton();
        checkNextButton($('#next_st2'), answers["q_st2"], ["substitution-distortion-rate", "step2_explanation"],
            $('#step3'));
    });

    $('#q_st2_y').click(function () {
        enableSubmit();
        removeAddSelection($('#q_st2_n'), $('#q_st2_y'));
        $('#step2_extra_info').removeClass('disabled');
        answers["q_st2"] = "yes";
        checkSubmitButton();
        checkNextButton($('#next_st2'), answers["q_st2"], ["substitution-distortion-rate", "step2_explanation"],
            $('#step3'));
    });

    $('#substitution-distortion-rate').change(function () {
        answers["substitution-distortion-rate"] = $('#substitution-distortion-rate').val();
        checkSubmitButton();
        checkNextButton($('#next_st2'), answers["q_st2"], ["substitution-distortion-rate", "step2_explanation"],
            $('#step3'));
    });

    $('#step2_explanation').on("keydown focusout", function () {
        answers["step2_explanation"] = $('#step2_explanation').val();
        checkSubmitButton();
        checkNextButton($('#next_st2'), answers["q_st2"], ["substitution-distortion-rate", "step2_explanation"],
            $('#step3'));
    });

    $('#next_st2').click(function () {
        $( "#annotation-process" ).accordion( "option", "active", 2 );
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