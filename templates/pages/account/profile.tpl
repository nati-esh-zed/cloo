{$if (isset({$@login_info$}))
{<div class="col-12 col-sm-10 mx-auto">
    <h3>Profile</h3>
    <form class="">
        <div class="form-group">
            <label for="profile_username">Username</label>
            <input 
                class="form-control form-readonly" 
                type="text" 
                id="profile_username":
                value="{$login_info.username$}"
                readonly
                />
        </div>
        <div class="form-group">
            <label for="profile_password">Password</label>
            <input 
                class="form-control form-readonly" 
                type="password" 
                id="profile_password"
                value="{$login_info.password$}"
                readonly
                />
        </div>
        <div class="form-group">
            <input
                class=""
                type="checkbox"
                id="profile_show_password_checkbox"
                name="show_password"
                onchange="toggle_show_password('profile_password')"
                />
            <label for="profile_show_password_checkbox">show password</label>
        </div>
    </form>
</div>
}$}