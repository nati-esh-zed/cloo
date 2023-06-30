{$if (!isset({$@login_info$}))
{<div class="container row mx-auto">
    <div class="border border-sm rounded bg-light 
                col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4  
                my-3 mx-auto p-4 py-2">
        <div class="h3 mb-1 py-1 px-2">create an account</div>
        <div class="border-top mb-2"></div>
        <div class="section-content">
            <form
                id="registration_form"
                class=""
                name="register"
                method="post"
                action="javascript:void(0)"
                onsubmit="return handle_registration(this)"
                novalidate
                >
            {* <div class="form-group mb-2">
                    <label for="register_email">Email</label>
                    <input autofocus
                        class="form-control form-control-md" 
                        type="email" 
                        id="register_email"
                        name="email" 
                        placeholder="username@example.com"
                        value=""
                        />
                    <small id="loginEmailMsg" class="form-text px-1 pt-1 d-none"></small>
                </div> *}
                <div class="form-group mb-2">
                {* <label for="register_username">Username</label> *}
                <input autofocus
                    class="form-control form-control-md" 
                    type="text" 
                    id="register_username"
                    name="username" 
                    placeholder="username"
                    value=""
                    autocomplete="false"
                    required
                    />
                <small id="register_username_msg" class="form-text px-1 pt-1 d-none"></small>
            </div>
            <div class="form-group mb-2">
                {* <label for="register_age">Age</label> *}
                <input autofocus
                    class="form-control form-control-md" 
                    type="number" 
                    min="13"
                    max="500"
                    id="register_age"
                    name="age" 
                    placeholder="age"
                    value=""
                    autocomplete="false"
                    required
                    />
                <small id="register_age_msg" class="form-text px-1 pt-1 d-none"></small>
            </div>
                <div class="form-group mb-2">
                    {* <label for="register_password">Password</label> *}
                    <input 
                        class="form-control form-control-md" 
                        type="password" 
                        id="register_password"
                        name="password" 
                        placeholder="password"
                        value=""
                        autocomplete="false"
                        required
                        />
                    <small id="register_password_msg" class="form-text px-1 pt-1 d-none"></small>
                </div>
                <div class="form-group mb-2">
                    {* <label for="register_verify_password">Verify Password</label> *}
                    <input 
                        class="form-control form-control-md" 
                        type="password" 
                        id="register_verify_password"
                        name="verify_password" 
                        placeholder="verify-password"
                        value=""
                        autocomplete="false"
                        required
                        />
                    <small id="register_verify_password_msg" class="form-text px-1 pt-1 d-none"></small>
                </div>
                <div class="form-group">
                    <input
                        class=""
                        type="checkbox"
                        id="show_password_checkbox"
                        name="register_show_password"
                        onchange="toggle_show_password('register_password'); toggle_show_password('register_verify_password')"
                        />
                    <label for="show_password_checkbox">show password</label>
                </div>
                <button 
                    class="form-control form-control-md btn btn-primary" 
                    type="submit" 
                    name="submit" 
                    value="register" >
                    create account
                </button>
            </form>
        </div>
    </div>
</div>
$}