<div>
    <label for="reason1" style="font-weight:100 !important;">
        <input id="reason1" name="arrival_report_form[reason][]" value="I did not complete the study (academic dismissal)" class="radio-nominee" type="checkbox" <?= (is_array($arrival_report_form['reason']) && in_array('I did not complete the study (academic dismissal)', $arrival_report_form['reason'])) ? 'checked' : '' ?>> I did not complete the study (academic dismissal)
    </label>
</div>
<div>
    <label for="reason2" style="font-weight:100 !important;">
        <input id="reason2" name="arrival_report_form[reason][]" value="I have completed the course works, but I have notstarted my dissertation writing" class="radio-nominee" type="checkbox" <?= (is_array($arrival_report_form['reason']) && in_array('I have completed the course works, but I have notstarted my dissertation writing', $arrival_report_form['reason'])) ? 'checked' : '' ?>> I have completed the course works, but I have notstarted my dissertation writing
    </label>
</div>
<div>
    <label for="reason3" style="font-weight:100 !important;">
        <input id="reason3" name="arrival_report_form[reason][]" value="I am in the process of writing my dissertation, and havenot yet defended it" class="radio-nominee" type="checkbox" <?= (is_array($arrival_report_form['reason']) && in_array('I am in the process of writing my dissertation, and havenot yet defended it', $arrival_report_form['reason'])) ? 'checked' : '' ?>> I am in the process of writing my dissertation, and havenot yet defended it
    </label>
</div>
<div>
    <label for="reason4" style="font-weight:100 !important;">
        <input id="reason4" name="arrival_report_form[reason][]" value="I have defended my dissertation, but I need more timeto work on some revision" class="radio-nominee" type="checkbox" <?= (is_array($arrival_report_form['reason']) && in_array('I have defended my dissertation, but I need more timeto work on some revision', $arrival_report_form['reason'])) ? 'checked' : '' ?>> I have defended my dissertation, but I need more timeto work on some revision
    </label>
</div>
<div>
    <label for="reason5" style="font-weight:100 !important;">
        <input id="reason5" name="arrival_report_form[reason][]" value="I am conducting research for my dissertation and will do it in the home country" class="radio-nominee" type="checkbox" <?= (is_array($arrival_report_form['reason']) && in_array('I am conducting research for my dissertation and will do it in the home country', $arrival_report_form['reason'])) ? 'checked' : '' ?>> I am conducting research for my dissertation and will do it in the home country
    </label>
</div>
<div>
    <label for="reason6" style="font-weight:100 !important;">
        <input id="reason6" name="arrival_report_form[reason][]" value="I have not done any of those above, but I have transferred my visa sponsorship to the university" class="radio-nominee" type="checkbox" <?= (is_array($arrival_report_form['reason']) && in_array('I have not done any of those above, but I have transferred my visa sponsorship to the university', $arrival_report_form['reason'])) ? 'checked' : '' ?>> I have not done any of those above, but I have transferred my visa sponsorship to the university
    </label>
</div>
<div>
    <label for="reason7" style="font-weight:100 !important;">
        <input id="reason7" name="arrival_report_form[reason][]" value="I have done any of those above, and I have transferred my visa sponsorship to the university to do projects" class="radio-nominee" type="checkbox" <?= (is_array($arrival_report_form['reason']) && in_array('I have done any of those above, and I have transferred my visa sponsorship to the university to do projects', $arrival_report_form['reason'])) ? 'checked' : '' ?>> I have done any of those above, and I have transferred my visa sponsorship to the university to do projects
    </label>
</div>
<div>
    <label for="reason8" style="font-weight:100 !important;">
        <input id="reason8" name="arrival_report_form[reason][]" value="I have completed my course works and dissertation, but I will return to the U.S. for the commencement" class="radio-nominee" type="checkbox" <?= (is_array($arrival_report_form['reason']) && in_array('I have completed my course works and dissertation, but I will return to the U.S. for the commencement', $arrival_report_form['reason'])) ? 'checked' : '' ?>> I have completed my course works and dissertation, but I will return to the U.S. for the commencement
    </label>
</div>
<div>
    <label for="reason9" style="font-weight:100 !important;">
        <input id="reason9" name="arrival_report_form[reason][]" value="I have completed my course works and dissertation, and I am planning to take OPT/PAT or internship in the U.S" class="radio-nominee" type="checkbox" <?= (is_array($arrival_report_form['reason']) && in_array('I have completed my course works and dissertation, and I am planning to take OPT/PAT or internship in the U.S', $arrival_report_form['reason'])) ? 'checked' : '' ?>> I have completed my course works and dissertation, and I am planning to take OPT/PAT or internship in the U.S
    </label>
</div>
<div>
    <label for="reason10" style="font-weight:100 !important;">
        <input id="reason10" name="arrival_report_form[reason][]" value="None of those above, please explain" class="radio-nominee" type="checkbox" <?= (is_array($arrival_report_form['reason']) && in_array('', $arrival_report_form['reason'])) ? 'checked' : '' ?>> None of those above, please explain
    </label>
    <input type="text" class="form-control" id="complete_study_date" name="arrival_report_form[other_reason]" value="<?= $arrival_report_form['other_reason'] ?>">
</div>