<?php require_once('./layouts/header.php') ?>

<div class="container" style="position: relative;">
    <div class="row" style="margin-top: 70px;margin-bottom: 70px">
        <div class="col-md-5 ">
            <h1>Thank you!</h1>
            <h3 style="margin-top: 40px; color:#2b542c!important;">Let’s get started meeting people</h3>

            <div class="row">
                <div class="col-md-4">Your name:</div>
                <div class="col-md-8"><b><?php echo $_GET['name']; ?> </b></div>
            </div>
            <div class="row">
                <div class="col-md-4">Birthday:</div>
                <div class="col-md-8"><b><?php echo $_GET['birthday']['month'].'/'.$_GET['birthday']['day'].'/'.$_GET['birthday']['year']; ?></b></div>
            </div>
            <div class="row">
                <div class="col-md-4">Gender:</div>
                <div class="col-md-8"><b><?php echo $_GET['gender']; ?></b></div>
            </div>

            <div class="form-group" style="margin-top: 15px;">
                <button id="btnLetStart" onclick="doMeetPeople()" class="btn btn-lg btn-success">Let’s Start</button>
            </div>
        </div>
        <div class="col-md-7">
            <img src="./assets/imgs/call.gif" style="max-width: 100%;"/>
        </div>

    </div>

</div>

<?php
    function generateRandomString($length = 50) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
    $userarr = array(
        'ui' => generateRandomString(),
        'name' => $_GET['name'],
        'birthday' => $_GET['birthday']['month'].'/'.$_GET['birthday']['day'].'/'.$_GET['birthday']['year'],
        'gender' => $_GET['gender']
    )
?>
<script type="text/javascript">
    let hash = '<?php echo json_encode($userarr); ?>';
    function doMeetPeople() {
        let url = './meetup?hash=' + hash;
        document.location = url;
    }
</script>

<?php require_once('./layouts/footer.php') ?>