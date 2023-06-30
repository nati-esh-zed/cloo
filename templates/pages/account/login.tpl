{$if (!isset({$@login_info$}))
{<div class="container row mx-auto">
    <div class="border border-sm rounded bg-light 
                col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4  
                my-2 mx-auto p-4 py-2">
        <div class="h3 mb-1 py-1 px-2">login</div>
        <div class="border-top mb-2"></div>
        <div class="section-content">
            <form 
                id="login_form"
                class=""
                name="login"
                method="post"
                action="javascript:void(0)"
                onsubmit="return handle_login(this)"
                novalidate
                >
                <div class="form-group mb-2">
                    {* <label for="login_username">Username</label> *}
                    <input autofocus
                        class="form-control form-control-md" 
                        type="text" 
                        id="login_username"
                        name="username" 
                        placeholder="username"
                        value=""
                        required/>
                    <small id="login_username_msg" class="form-text px-1 pt-1 d-none"></small>
                </div>
                <div class="form-group mb-2">
                    {* <label for="login_password">Password</label> *}
                    <input 
                        class="form-control form-control-md" 
                        type="password" 
                        id="login_password"
                        name="password" 
                        placeholder="password"
                        value=""
                        required
                        />
                    <small id="login_password_msg" class="form-text px-1 pt-1 d-none"></small>
                </div>
                <div class="form-group">
                    <input
                        class=""
                        type="checkbox"
                        id="show_password_checkbox"
                        name="show_password"
                        onchange="toggle_show_password('login_password')"
                        />
                    <label for="show_password_checkbox">show password</label>
                </div>
                <button 
                    class="form-control form-control-md btn btn-primary" 
                    type="submit" 
                    name="submit" 
                    value="login" >
                    login
                </button>
            </form>
        </div>
    </div>
</div>
}$}