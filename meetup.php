<?php require_once('./layouts/header.php') ?>

<link rel="stylesheet" href="./assets/css/meet.css">

<?php
    $minfo = json_decode($_GET['hash']);
    $hash = hash('md5', $minfo->ui);
?>
<script>
    const minfo = {
        name: '<?php echo $minfo->name; ?>',
        gender: '<?php echo $minfo->gender; ?>',
    };
    const hash = "<?php echo $hash; ?>";
</script>
<div class="container">
    <div class="row" style="margin-top: 70px;margin-bottom: 70px">
        <div class="col-md-5 ">
            <h1 id="titlePage">Waiting for the next meeting.</h1>
            <div class="row" style="margin-top: 50px;">
                <div class="col-xs-4 col-md-3">
                    <div class="avatar" style="background-image:url('./assets/imgs/<?php echo strtolower($minfo->gender)."_1.png"; ?>')"></div>
                </div>
                <div class="col-xs-8 col-md-9">
                    <div class="box sb2" style="margin-top:8px; max-width: 300px;">
                        <div class="row">
                            <div class="col-md-5">Your name:</div>
                            <div class="col-md-7"><b><?php echo $minfo->name; ?></b></div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">Gender:</div>
                            <div class="col-md-7"><b><?php echo $minfo->gender; ?></b></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="partnerWrap" class="" style="display: none;">
                <div class="row" style="margin-top: 50px;">

                    <div class="col-xs-8 col-md-9">
                        <div class="box sb1" style="margin-top:8px; max-width: 300px;">
                            <div class="row">
                                <div class="col-md-5">Partner:</div>
                                <div class="col-md-7"><b id="partner_name"></b>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">Gender:</div>
                                <div class="col-md-7"><b id="partner_gender"></b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-md-3">
                        <div id="partner_avatar" class="avatar"></div>
                    </div>
                </div>
            </div>
            <div id="partnerLoading" style="display: none">
                <img src="./assets/imgs/processing.gif" style="max-width: 100%;"/>
            </div>
        </div>
        <div class="col-md-7">
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="d-flex align-items-center">
                        <span style="border-radius:100%;background:#00bfb6;display:block;width:20px;height:20px; margin-bottom:10px">
                            &nbsp;
                        </span>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div id="big-container">
                        <div class="videoPeople"
                                style="font-weight:bold;position: absolute; top:-30px; right:10px;">1 user online
                        </div>
                        <div id="videos-second-container" class="my_camera">
                            
                        </div>
                        <div id="videos-container" class="my_camera">
                        </div>
                        <div class="my_camera"
                            style="border-radius:7px;position:absolute;left:10px;bottom:10px;">
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="videoCounterWrap">
                                    <span class="span_counter_label">60</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" id="private_room_form" action="">
                <input type="hidden" id="private_room_id" name="private_room_id"/>
                <input type="hidden" id="private_room_host" name="private_room_host"/>
            </form>


        </div>

    </div>
</div>

<script src="./assets/libs/RTCMultiConnection.js"></script>
<script src="./assets/libs/socket.io.js"></script>
<script src="./assets/js/meet.js"></script>

<?php require_once('./layouts/footer.php') ?>