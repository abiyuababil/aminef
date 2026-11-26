<style>
    .custom-icon {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 2;
    }

    .card-title-bg {
        background-color: #013473;
        color: #fff;
        padding: 70px 15px 15px 15px; /* untuk memberi ruang di bawah ikon */
        min-height: 208px;
        position: relative;
        z-index: 1;
        border-radius: 8px 8px 0 0;
    }

    .card-title-name {
        display: -webkit-box;
        max-width: 100%;
        height: 95px;
        margin: 0 auto;
        line-height: 30px;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .activity-wrapper {
        height: 200px;
    }

    .activity-wrapper p {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 6;
        -webkit-box-orient: vertical;
    }

    .wrapper-card-grant {
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }
    

  .center-box {
    width: 50%;
    height: 250px;
    margin: 50px auto;
    
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .center-box p {
    margin: 0;
    font-size: 20px;
    text-align: center;
  }
</style>

<div class="row" style="padding-bottom:50px;">
    <?php if($data) { ?>
    <?php foreach ($data as $key => $data) { ?>
        <div class="col-lg-4 text-center" style="padding-top:70px;">
            <div class="wrapper-card-grant">
                <!-- ICON -->
                <div class="custom-icon shadow-sm" style="background-color:#fff;color:#0089d1;">
                    <i class="fa fa-graduation-cap fa-4x"></i>
                </div>

                <!-- TITLE AREA -->
                <div class="card-title-bg">
                    <h3 class="card-title-name" data-toggle="tooltip" data-placement="left" title="<?= $data->year ?>">
                        Duolingo English Test - <?php echo $data->year; ?>
                    </h3>
                </div>

                <!-- CONTENT CARD -->
                <div class="card" style="background-color:#fff;padding:10px;">
                    <div class="card-body">
                        <div class="activity-wrapper">
                            <h5 class="card-title"><b>INFORMATION</b></h5>
                            <p class="card-text" style="font-size:14px;">
                                <?= shorten_string($data->activity, 70);?>
                            </p>
                        </div>
                        <div class="grant-length-wrapper" style="height: 127px;">
                            <hr>
                            <h5 class="card-title"><b>TIMELINE</b></h5>
                            <p class="card-text" style="font-size:14px;">
                                <?= shorten_string($data->deadline_note, 30);?>
                            </p>
                        </div>
                        <div class="more-information-wrapper">
                            <hr>
                            <a href="<?= base_url('det/registration/detail/' . $data->id) ?>" class="btn btn-lg btn-primary btn-block" style="margin:20px 0px">
                                More Information
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php } else { ?>
        <div class="center-box">
            <p>Registration is not open at the moment. Please check back at <a href="https://www.aminef.or.id/" target="_blank"> for the next registration period.</p>
        </div>
    <?php } ?>
</div>
