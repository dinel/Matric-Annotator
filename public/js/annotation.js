var changed = false;

const distortions = [];
distortions["step2"] = "substitution";
distortions["step3"] = "omission";
distortions["step4"] = "addition";

const nexts = [];
nexts["step1"] = ["step2", 1];
nexts["step2"] = ["step3", 2];
nexts["step3"] = ["step4", 3];
nexts["step4"] = ["step5", 4];

$(document).ready(function() {
    // ensure the current segment is highlighted
    $('#src-preview').scrollTop(Math.max(0, $('#src-current').position().top - 40));
    $('#trg-preview').scrollTop(Math.max(0, $('#trg-current').position().top - 40));

    $("#annotation-process").accordion();
    $( "#side-panel" ).tabs();

    // TODO: uncomment
    //$('#submit-panel').hide();

    $('#swap-preview').click(function () {

        $.ajax({url: "/annotation/move-preview", success: function(result){
                if(left) {
                    $('#side-panel').insertAfter('#annotation-panel');
                    left = false;
                } else {
                    $('#side-panel').insertBefore('#annotation-panel');
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
        valuesChanged();
        checkSubmitButton();
    });

    $('#q_st1_y').click(function () {
        disableSubmit();
        removeAddSelection($('#q_st1_n'), $('#q_st1_y'));
        enableNext($('#next_st1'));
        enableStep($('#step2'));
        answers["q_st1"] = "yes";
        valuesChanged();
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

        if(type == "n") {
            removeAddSelection($('#' + question + '_y'), $('#' + question + '_n'));
            answers[question] = "no";
            $('#' + step + '_extra_info').addClass('disabled');
        } else {
            removeAddSelection($('#' + question + '_n'), $('#' + question + '_y'));
            answers[question] = "yes";
            $('#' + step + '_extra_info').removeClass('disabled');
        }
        valuesChanged();
        checkSubmitButton();
        checkNextButton($('#next_' + step), answers[question], [distortions[step] + "-distortion-rate", step + "_explanation"],
            $('#' + nexts[step][0]));
    });

    $('.distortion-rate').change(function () {
        let id = $(this).parents('.step').find('.step-yes-no')[0].id;
        let question = id.slice(0, -2);
        let step = $(this).parents('.step').attr('id');
        answers[distortions[step] + "-distortion-rate"] = $(this).val();
        valuesChanged();
        checkSubmitButton();
        checkNextButton($('#next_' + step), answers[question], [distortions[step] + "-distortion-rate", step + "_explanation"],
            $('#' + nexts[step][0]));
    });

    $('.explanation').on("keydown focusout", function () {
        let id = ($(this).parents('.step').find('.step-yes-no'))[0].id;
        let question = id.slice(0, -2);
        let step = $(this).parents('.step').attr('id');
        answers[step + "-explanation"] = $(this).val();
        valuesChanged();
        checkSubmitButton();
        checkNextButton($('#next_' + step), answers[question], [distortions[step] + "-distortion-rate", step + "-explanation"],
            $('#' + nexts[step][0]));
    });

    $('.next').click(function () {
        let step = $(this).parents('.step').attr('id');
        $( "#annotation-process" ).accordion( "option", "active", nexts[step][1] );
    });

    $('#btn-save').click(function() {
        console.log("Sending array ... ", answers);
        console.log("Sending ... ", JSON.stringify(answers));
        $.ajax({
            type: "POST",
            url: "/annotation/save_evaluation",
            data: {data:answers},
            success: function(data) {
                console.log(data);
                answers['id'] = data.id;
                changed = false;
                $('#btn-save').addClass('btn-primary');
                $('#btn-save').removeClass('btn-danger');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                alert('Error saving the data: ' + textStatus + "Error thrown" + errorThrown);
            }
        });
    });

    $('.prev-next').click(function () {
       if(changed) {
           const result = confirm("You have information which is not saved. Are you sure you want to proceed? If you do, all the changes will be lost");
           if (! result) {
               return false;
           }
       }
    });

    setInitValues();
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
            if(! (value in answers))  {
                flag = false;
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
    let enable = false;

    if(answers["q_st1"] == "no") {
        enable = true;
    } else {
        let missing = false;
        if("q_st2" in answers) {
            if(answers["q_st2"] == "yes") {
                if((!("substitution-distortion-rate" in answers)) || (!("step2-explanation" in answers))) {
                    missing = true;
                }
            }
        } else {
            missing = true;
        }

        if("q_st3" in answers) {
            if(answers["q_st3"] == "yes") {
                if((!("omission-distortion-rate" in answers)) || (!("step3-explanation" in answers))) {
                    missing = true;
                }
            }
        } else {
            missing = true;
        }

        if("q_st4" in answers) {
            if(answers["q_st4"] == "yes") {
                if((!("addition-distortion-rate" in answers)) || (!("step4-explanation" in answers))) {
                    missing = true;
                }
            }
        } else {
            missing = true;
        }

        enable = !missing;
    }

    if(enable) {
        $('#btn-save').removeClass("disabled");
    } else {
        $('#btn-save').addClass('disabled');
    }

}

function valuesChanged() {
    changed = true;
    $('#btn-save').removeClass('btn-primary');
    $('#btn-save').addClass('btn-danger');
}