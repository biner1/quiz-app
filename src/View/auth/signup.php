<div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">

            <div class="card-body p-md-5">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                           <form class="form" id="signup-form">

                            <span class="signup">Sign Up</span>
                            <input placeholder="Full Name" type="text" name="name"  class="form--input" />
                            <input placeholder="email" type="email" name="email"  class="form--input" />
                            <input placeholder="Password" type="password" name="password" class="form--input" />
                            <input placeholder="confirm_password" type="password" name="confirm_password" class="form--input" />

                            
                            <div class="form--marketing">
                                <input id="okayToEmail" type="checkbox" name="is_teacher" value="1">
                                <label for="okayToEmail" class="checkbox">
                                Is Teacher?
                                </label>
                            </div>

                            <div id="signup-error"></div>
                            
                            <button type="submit" class="form--submit">
                                Sign up
                            </button>

                            <div class="sign-up">
                                Already have an account?
                                <a href="login">Login</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

