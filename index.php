<?php require_once('./layouts/header.php') ?>

        <div class="text-center user_count">
            <strong>10</strong> + online now!
        </div>
        <div class="container">
            <div class="row" style="margin-top:20px; margin-bottom: 0px">
                <div class="col-md-5 ">
                    <h1>60 Second Video Meet</h1>
                    <p>
                        Join our community and find a warm and meaningful connection!
                    </p>
                    <form id="frmFacetime" onsubmit="return checkForm();" action="./facetimeWaiting" method="get" style="margin: 15px;">
                    <div class="row">
                        <div class="form-group">
                            <label>Your Name:</label>
                            <input type="text" class="form-control" name="name" placeholder="Full name" value="" id="name" required="">
                        </div>
                        <div class="form-group">
                            <label>Your email: (will not be displayed)</label>
                            <input type="text" class="form-control" name="email" placeholder="" value="" id="email" required="">
                        </div>
                        <div class="form-group">
							<div id="groub_gender">
                                <label>Gender:</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="Male">
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="Female">
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                                <div id="error_gender" class="text_red" style="display:none; color:red;">Please select your gender.</div>
							</div>		
                            <div class="form-group" style="margin-top: 15px;">
                                    <div class="row birthday-fields">
                                    <div class="col-md-4">
                                        <select id="birthday_year" name="birthday[year]" class="form-control input-lg">
                                            <option value="">Year</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select id="birthday_month" name="birthday[month]" class="form-control input-lg">
                                            <option value="">Month</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select id="birthday_day" name="birthday[day]" class="form-control input-lg">
                                            <option value="">Day</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                    </select>
                                    </div>
                                </div>
                                <span class="help-block small" id="error_message"><span class="required">*</span> Select your birthday. User must 18 years old or older to participate.</span>
                            </div>
                            <div class="form-group" style="margin-top: 15px;">
                                <button class="btn btn-lg btn-danger">I am ready!</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="col-md-7">
					<div class="text-center"> 
                        <div class="intro_section">Go to 60 second</div>
                        <div class="intro_section"><strong style="font-size:45px">video meetings</strong></div>
                        <div>
                            <a href="javascript:void(0);" class="now_btn">Now</a>
                        </div>
                        <img style="max-width: 100%; visibility: visible;" src="./assets/imgs/60s_img.png" data-xblocker="passed">
					</div>
                </div>

            </div>
        </div>

        <?php require_once('./layouts/footer.php') ?>