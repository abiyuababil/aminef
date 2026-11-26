<div>
    <label for="reason1" style="font-weight:100 !important;">
        <input id="reason1" name="arrival_report_form[reason][]" value="I did not complete the study (academic dismissal)" class="radio-nominee" type="checkbox" <?= (is_array($arrival_report_form['reason']) && in_array('I did not complete the study (academic dismissal)', $arrival_report_form['reason'])) ? 'checked' : '' ?>> I did not complete the study (academic dismissal)
    </label>
</div>
<div>
    <label for="reason2" style="font-weight:100 !important;">
        <input id="reason2" name="arrival_report_form[reason][]" value="I did not complete the program (personal withdrawal)" class="radio-nominee" type="checkbox" <?= (is_array($arrival_report_form['reason']) && in_array('I did not complete the program (personal withdrawal)', $arrival_report_form['reason'])) ? 'checked' : '' ?>> I did not complete the program (personal withdrawal)
    </label>
</div>
<div>
    <label for="reason3" style="font-weight:100 !important;">
        <input id="reason3" name="arrival_report_form[reason][]" value="I have not completed the program because I extend my research project" class="radio-nominee" type="checkbox" <?= (is_array($arrival_report_form['reason']) && in_array('I have not completed the program because I extend my research project', $arrival_report_form['reason'])) ? 'checked' : '' ?>> I have not completed the program because I extend my research project
    </label>
</div>
<div>
    <label for="reason4" style="font-weight:100 !important;">
        <input id="reason4" name="arrival_report_form[reason][]" value="I have completed the program, but I postpone to return home, please explain:" class="radio-nominee" type="checkbox" <?= (is_array($arrival_report_form['reason']) && in_array('I have completed the program, but I postpone to return home, please explain:', $arrival_report_form['reason'])) ? 'checked' : '' ?>> I have completed the program, but I postpone to return home, please explain:
    </label>
    <input type="text" class="form-control" id="other_reason_completed" name="arrival_report_form[other_reason_completed]" value="<?= $arrival_report_form['other_reason_completed'] ?>">
</div>
<div>
    <label for="reason5" style="font-weight:100 !important;">
        <input id="reason5" name="arrival_report_form[reason][]" value="None of those above, please explain" class="radio-nominee" type="checkbox" <?= (is_array($arrival_report_form['reason']) && in_array('None of those above, please explain', $arrival_report_form['reason'])) ? 'checked' : '' ?>> None of those above, please explain
    </label>
    <input type="text" class="form-control" id="other_reason" name="arrival_report_form[other_reason]" value="<?= $arrival_report_form['other_reason'] ?>">
</div>