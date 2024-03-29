<?php $this->load->view("taskman_header_page") ?>
<body class="login-body">
    <?php if ($this->session->flashdata('status') == 2) { ?>
        <div id="mini-notification">
            <p>Your password has been sent to your email. Please check it in your email.</p>
        </div>
    <?php } else if ($this->session->flashdata('status') == -1) {
        ?>
        <div id="mini-notification">
            <p>Sorry. It looks like you type the wrong password or username. Please, try again.</p>
        </div>
    <?php } else if ($this->session->flashdata('status') == 1) {
        ?>
        <div id="mini-notification">
            <p>Our system detect that your email has been registered.</p>
        </div>
    <?php } else if ($this->session->flashdata('status') == 4) {
        ?>
        <div id="mini-notification">
            <p>You are not allowed to see this page without login. Please, login first.</p>
        </div>
    <?php } ?>
    <div class="container">

        <form method="POST" class="form-signin" action="<?php echo site_url() ?>/login/authentication">
            <h2 class="form-signin-heading">sign in now</h2>
            <div class="login-wrap">
                <div class="user-login-info">
                    <input type="text" name="username" class="form-control" placeholder="User ID" autofocus>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <label class="checkbox">
<!--                    <input type="checkbox" name="rememberme" value="remember-me"> Remember me-->
                    <span class="pull-right">
                        <a data-toggle="modal" href="#myModal"> Lupa Password?</a>

                    </span>
                </label>
                <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>

                <div class="registration">
                    Tidak punya akun ?
                    <a class="" href="<?php echo site_url() ?>/registration">
                        Silahkan hubungi Admin
                    </a>
                </div>

            </div>
            `</form>
        <!-- Modal -->
        <form class="form-signin" method="POST" action="<?php echo site_url() ?>/registration/forgot_password">
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Lupa Password ?</h4>
                        </div>
                        <div class="modal-body">
                            <p>Masukkan email anda untuk mereset password anda.</p>
                            <input type="text" name="email_user" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default" type="button">Batal</button>
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal -->
        </form>
    </div>
    <?php
    $this->load->view("taskman_footer_page")?>