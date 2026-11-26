<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">

        <form role="form" method="POST">

            <?php if (isset($this->Period_english_test_score_model->id)) : ?>
                <input
                    type="hidden"
                    name="id"
                    value="<?php echo $this->Period_english_test_score_model->id; ?>"
                >
            <?php endif; ?>

            <div class="row">

                <!-- Field of Study -->
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="field_of_study">Field of Study</label>

                        <input
                            type="text"
                            id="field_of_study"
                            name="field_of_study"
                            class="form-control"
                            value="<?php echo isset($this->Period_english_test_score_model->field_of_study)
                                ? html_escape($this->Period_english_test_score_model->field_of_study)
                                : ''; ?>"
                            placeholder="eg: Business, Engineering, Computer Science"
                        >
                    </div>
                </div>

                <!-- TOEFL IIE -->
                <!-- <div class="col-lg-6">
                    <div class="form-group">
                        <label for="toefl_iie">TOEFL IIE</label>

                        <input
                            type="text"
                            id="toefl_iie"
                            name="toefl_iie"
                            class="form-control"
                            value="<?php //echo isset($this->Period_english_test_score_model->toefl_iie)
                                //? html_escape($this->Period_english_test_score_model->toefl_iie)
                                //: ''; ?>"
                            placeholder="eg: 550"
                        >
                    </div>
                </div> -->

                <!-- TOEFL ITP -->
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="toefl_itp">TOEFL ITP</label>

                        <input
                            type="text"
                            id="toefl_itp"
                            name="toefl_itp"
                            class="form-control"
                            value="<?php echo isset($this->Period_english_test_score_model->toefl_itp)
                                ? html_escape($this->Period_english_test_score_model->toefl_itp)
                                : ''; ?>"
                            placeholder="eg: 550"
                        >
                    </div>
                </div>

                <!-- TOEFL iBT -->
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="toefl_ibt">TOEFL iBT</label>

                        <input
                            type="text"
                            id="toefl_ibt"
                            name="toefl_ibt"
                            class="form-control"
                            value="<?php echo isset($this->Period_english_test_score_model->toefl_ibt)
                                ? html_escape($this->Period_english_test_score_model->toefl_ibt)
                                : ''; ?>"
                            placeholder="eg: 80"
                        >
                    </div>
                </div>

                <!-- TOEFL iBT 1-6 -->
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="toefl_ibt_1_6">TOEFL iBT 1–6</label>

                        <input
                            type="text"
                            id="toefl_ibt_1_6"
                            name="toefl_ibt_1_6"
                            class="form-control"
                            value="<?php echo isset($this->Period_english_test_score_model->toefl_ibt_1_6)
                                ? html_escape($this->Period_english_test_score_model->toefl_ibt_1_6)
                                : ''; ?>"
                            placeholder="eg: 4.5"
                        >
                    </div>
                </div>

                <!-- IELTS -->
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="ielts">IELTS</label>

                        <input
                            type="text"
                            id="ielts"
                            name="ielts"
                            class="form-control"
                            value="<?php echo isset($this->Period_english_test_score_model->ielts)
                                ? html_escape($this->Period_english_test_score_model->ielts)
                                : ''; ?>"
                            placeholder="eg: 6.5"
                        >
                    </div>
                </div>

                <!-- Duolingo DET -->
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="duolingo_det">Duolingo DET</label>

                        <input
                            type="text"
                            id="duolingo_det"
                            name="duolingo_det"
                            class="form-control"
                            value="<?php echo isset($this->Period_english_test_score_model->duolingo_det)
                                ? html_escape($this->Period_english_test_score_model->duolingo_det)
                                : ''; ?>"
                            placeholder="eg: 120"
                        >
                    </div>
                </div>

                <!-- GRE -->
                <!-- <div class="col-lg-12">
                    <div class="form-group">
                        <label for="gre">GRE</label>

                        <textarea
                            id="gre"
                            name="gre"
                            class="form-control"
                            rows="5"
                            placeholder="eg: 300"
                        ><?php //echo isset($this->Period_english_test_score_model->gre)
                                //? html_escape($this->Period_english_test_score_model->gre)
                                //: ''; ?></textarea>
                    </div>
                </div> -->

                <!-- Additional Considerations -->
                <!-- <div class="col-lg-12">
                    <div class="form-group">
                        <label for="additional_considerations">
                            Additional Considerations
                        </label>

                        <textarea
                            id="additional_considerations"
                            name="additional_considerations"
                            class="form-control"
                            rows="5"
                            placeholder="Enter additional considerations..."
                        ><?php //echo isset($this->Period_english_test_score_model->additional_considerations)
                            //? html_escape($this->Period_english_test_score_model->additional_considerations)
                            //: ''; ?></textarea>
                    </div>
                </div> -->

            </div>

            <a
                href="<?php echo $this->session->userdata('redirect_url') ?>"
                class="btn btn-default"
            >
                Back
            </a>

            <button type="submit" class="btn btn-success">
                Submit
            </button>

        </form>

    </div>
</div>