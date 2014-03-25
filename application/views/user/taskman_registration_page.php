<?php $this->load->view("taskman_header_page") ?> 
<body class="login-body">
<?php if ($this->session->flashdata('status') == 1){?>
    <div id="mini-notification">
        <p>Our system detect that your email has been registered.</p>
    </div>
    <?php }
    else if ($this->session->flashdata('status') == 3){?>
    <div id="mini-notification">
        <p>Please, complete the fill below.</p>
    </div>
    <?php }?>
    <div class="container">
        <div class="form">
            <form class="form-signin cmxform form-horizontal " id="signupForm" method="POST" action="<?php echo site_url() ?>/registration/register_staff">
                <h2 class="form-signin-heading">registration now</h2>
                <div class="login-wrap">
                    <p>Enter your personal details below</p>
                    <input id="fullname" name="fullname" type="text" class="form-control" placeholder="Full Name" autofocus>
                    <div class="radios">
                        <label class="label_radio col-lg-6 col-sm-6" for="jabatan-01">
                            <input name="jabatan[]" id="jabatan-01" value="1" type="radio" checked /> Staff
                        </label>
                        <label class="label_radio col-lg-6 col-sm-6" for="jabatan-02">
                            <input name="jabatan[]" id="jabatan-02" value="2" type="radio" /> Manager
                        </label>
                    </div>

                    <select id="e9" name="departemen" class="form-control input-sm m-bot15">
                        <option value="0">Pilih Departemen</option>    
                        <option value="1">Teknologi Informasi</option>
                        <option value="2">Departemen A</option>
                    </select>

                    <input id="email" name="email" type="text" class="form-control" placeholder="Email" autofocus>
                    <input name="religion" type="text" class="form-control" placeholder="Religion" autofocus>
                    <input name="homephone" type="text" class="form-control" placeholder="Home Phone" autofocus>
                    <input name="mobilephone" type="text" class="form-control" placeholder="Mobile Phone" autofocus>
                    <input name="address" type="text" class="form-control" placeholder="Address" autofocus>
                    <div class="radios">
                        <label class="label_radio col-lg-6 col-sm-6" for="gender-01">
                            <input name="gender[]" id="gender-01" value="L" type="radio" checked /> Male
                        </label>
                        <label class="label_radio col-lg-6 col-sm-6" for="gender-02">
                            <input name="gender[]" id="gender-02" value="P" type="radio" /> Female
                        </label>
                    </div>

                    <p> Enter your account details below. You cannot change your NIP.</p>
                    <input name="usernip" type="text" class="form-control" placeholder="Nip" autofocus>
                    <input name="userpassword" id="userpassword" type="password" class="form-control" placeholder="Password">
                    <input id="confirmuserpassword" name="confirmuserpassword" type="password" class="form-control" placeholder="Re-type Password">
                    <!--            <label class="checkbox">
                                    <input type="checkbox" value="agree this condition"> I agree to the Terms of Service and Privacy Policy
                                </label>-->
                    
                    <button class="btn btn-lg btn-login btn-block" type="submit">Submit</button>
                   
                    <div class="registration">
                        Already Registered.
                        <a class="" href="<?php echo site_url() ?>/login">
                            Login
                        </a>
                    </div>

                </div>

            </form>
        </div>
        
    </div>
    <?php $this->load->view("taskman_footer_page") ?>