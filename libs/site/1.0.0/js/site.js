
const toggle_show_password = function(input_id)
{
    let password = $('#' + input_id);
    if(password)
    {
        type = password.attr('type');
        password.attr('type', type == "password" ? "text" : "password");
    }
}

const validate_email = function(email)
{
    let email_value = email.value.trim();
    if(email.required)
    {
        if(email_value == '')
            return 'this field is required';
    }
    else if(email_value == '')
        return null;
    if(!email.value.match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g))
        return 'please enter a valid email';
    return null;
}

const validate_username = function(username)
{
    let username_value = username.value.trim();
    if(username.required)
    {
        if(username_value == '')
            return 'this field is required';
    }
    else if(username_value == '')
        return null;
    if(!username.value.match(/^[a-zA-Z0-9]{4,20}$/g))
        return 'please enter a valid username';
    return null;
}

const validate_age = function(age)
{
    let age_str = age.value.trim();
    if(age.required)
    {
        if(age_str == '')
            return 'this field is required';
    }
    else if(age_str == '')
        return null;
    if(!age_str.match(/^[\d]{1,3}$/g))
        return 'please enter a valid age';
    let age_value = Number.parseInt(age_str);
    if(age_value < 13 || age_value > 999)
        return 'please enter a valid age in the range of [13, 999]';
    return null;
}

const validate_password = function(password)
{
    let password_value = password.value.trim();
    if(password.required)
    {
        if(password_value == '')
            return 'this field is required';
    }
    else if(password_value == '')
        return null;
    if(!password.value.match(/^(?=.*[A-Z])(?=.*[a-z])(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,20}$/g))
        return 'please enter a valid password<br>' 
            + "\n<span class=\"text-muted\">Password must be at least eight characters long, and must contain at least one uppercase letter, one lowercase letter, one symbol and one number.</span>";
    return null;
}

const handle_login = function(form)
{
    // form = this;
    // console.log(form);
    let username   = form.username;
    let password   = form.password;
    let login_data = {
        'username': username.value.trim(),
        'password': password.value.trim(),
        'submit':   'login'
    };
    let username_error = validate_username(username);
    let password_error = validate_password(password);
    if(username_error !== null)
    {
        let username_msg = $('#login_username_msg');
        $(username).addClass('is-invalid');
        $(username_msg).html(username_error);
        $(username_msg).addClass('text-danger');
        $(username_msg).removeClass('d-none');
    }
    else
    {
        let username_msg = $('#login_username_msg');
        $(username_msg).addClass('d-none');
        $(username_msg).html('');
        $(username).removeClass('is-invalid');
        $(username).addClass('is-valid');
    }
    if(password_error !== null)
    {
        let password_msg = $('#login_password_msg');
        $(password).addClass('is-invalid');
        $(password_msg).html(password_error);
        $(password_msg).addClass('text-danger');
        $(password_msg).removeClass('d-none');
    }
    else
    {
        let password_msg = $('#login_password_msg');
        $(password_msg).addClass('d-none');
        $(password_msg).html('');
        $(password).removeClass('is-invalid');
        $(password).addClass('is-valid');
    }
    if(username_error === null && password_error === null)
    {
        $.post(base_url + 'api/login.api.php', login_data,
        function(user_data, status)
        {
            user_data = JSON.parse(user_data);
            // console.log(user_data);
            username_value = login_data.username;
            password_value = login_data.password;
            if(!(user_data && user_data.name.toLowerCase() == username_value.toLowerCase()))
            {
                let username_msg = $('#login_username_msg');
                $(username).addClass('is-invalid');
                $(username_msg).html('<strong>no such username found</strong>');
                $(username_msg).addClass('text-danger');
                $(username_msg).removeClass('d-none');
            }
            else
            {
                if(user_data.password != password_value)
                {
                    let password_msg = $('#login_password_msg');
                    $(password).addClass('is-invalid');
                    $(password_msg).html('<strong>wrong password</strong>');
                    $(password_msg).addClass('text-danger');
                    $(password_msg).removeClass('d-none');
                }
                else
                {
                    login_cookie = username_value + ',' + password_value;
                    set_cookie('login_info', login_cookie, 30);
                    window.open(window.location.origin+window.location.pathname+'?page=home', '_self');
                    // console.log('login success');
                    // console.log(get_cookie('login_info'));
                }
            }
        });
        return true;
    }
    return false;
}

const handle_registration = function(form)
{
    // form = this;
    // console.log(form);
    // let email      = form.email;
    let username          = form.username;
    let age               = form.age;
    let password          = form.password;
    let verify_password   = form.verify_password;
    let registration_data = {
        // 'email':    email.value.trim(),
        'username': username.value.trim(),
        'age':      age.value.trim(),
        'password': password.value.trim(),
        'submit':   'register'
    };
    // console.log(registration_data);
    // let email_error    = validate_email(email);
    let username_error        = validate_username(username);
    let age_error             = validate_age(age);
    let password_error        = validate_password(password);
    let verify_password_error = validate_password(verify_password);
    if(password_error === null && verify_password_error === null
        && registration_data.password != verify_password.value.trim())
    {
        verify_password_error = 'passwords must match';
    }
    // console.log([email.required, username.required, password.required]);
    // if(email_error !== null)
    // {
    //     let email_msg = $('#registerEmailMsg');
    //     $(email).addClass('is-invalid');
    //     $(email_msg).html(email_error);
    //     $(email_msg).addClass('text-danger');
    //     $(email_msg).removeClass('d-none');
    // }
    // else
    // {
    //     let email_msg = $('#registerEmailMsg');
    //     $(email_msg).addClass('d-none');
    //     $(email_msg).html('');
    //     $(email).removeClass('is-invalid');
    //     $(email).addClass('is-valid');
    // }
    if(username_error !== null)
    {
        let username_msg = $('#register_username_msg');
        $(username).addClass('is-invalid');
        $(username_msg).html(username_error);
        $(username_msg).addClass('text-danger');
        $(username_msg).removeClass('d-none');
    }
    else
    {
        let username_msg = $('#register_username_msg');
        $(username_msg).addClass('d-none');
        $(username_msg).html('');
        $(username).removeClass('is-invalid');
        $(username).addClass('is-valid');
    }
    if(age_error !== null)
    {
        let age_msg = $('#register_age_msg');
        $(age).addClass('is-invalid');
        $(age_msg).html(age_error);
        $(age_msg).addClass('text-danger');
        $(age_msg).removeClass('d-none');
    }
    else
    {
        let age_msg = $('#register_age_msg');
        $(age_msg).addClass('d-none');
        $(age_msg).html('');
        $(age).removeClass('is-invalid');
        $(age).addClass('is-valid');
    }
    if(password_error !== null)
    {
        let password_msg = $('#register_password_msg');
        $(password).addClass('is-invalid');
        $(password_msg).html(password_error);
        $(password_msg).addClass('text-danger');
        $(password_msg).removeClass('d-none');
    }
    else
    {
        let password_msg = $('#register_password_msg');
        $(password_msg).addClass('d-none');
        $(password_msg).html('');
        $(password).removeClass('is-invalid');
        $(password).addClass('is-valid');
    }
    if(verify_password_error !== null)
    {
        let verify_password_msg = $('#register_verify_password_msg');
        $(verify_password).addClass('is-invalid');
        $(verify_password_msg).html(verify_password_error);
        $(verify_password_msg).addClass('text-danger');
        $(verify_password_msg).removeClass('d-none');
    }
    else
    {
        let verify_password_msg = $('#register_verify_password_msg');
        $(verify_password_msg).addClass('d-none');
        $(verify_password_msg).html('');
        $(verify_password).removeClass('is-invalid');
        $(verify_password).addClass('is-valid');
    }
    if(username_error === null && age_error === null && password_error === null && verify_password_error === null)
    {
        $.post(base_url + 'api/register.api.php', registration_data,
        function(user_data, status)
        {
            if(user_data)
            {
                login_cookie = registration_data.username + ',' + registration_data.password;
                set_cookie('login_info', login_cookie, 30);
                window.open(window.location.origin+window.location.pathname+'?page=home', '_self');
            }
            // console.log('registration success');
            // console.log(get_cookie('register_info'));
        });
        return true;
    }
    return false;
}

const handle_logout = function()
{
    delete_cookie('login_info');
    window.open(window.location.origin+window.location.pathname+'?page=home', '_self');
}

const set_cookie = function(name, value, exdays, path, domain) 
{
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = name + "=" + value
        + ((path) ? ";path="+path:"")
        + ((domain)?";domain="+domain:"")
        + ";" + expires;
}

const delete_cookie = function(name, path, domain) {
    if(get_cookie(name)) 
    {
        document.cookie = name + "="
            + ((path) ? ";path="+path:"")
            + ((domain)?";domain="+domain:"")
            + ";expires=Thu, 01 Jan 1970 00:00:01 GMT";
    }
}

const get_cookie = function(cname) 
{
    let name = cname + "=";
    let ca   = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) 
    {
        let c = ca[i]; 
        while(c.charAt(0) == ' ')
        {
            c = c.substring(1);
        } 
        if(c.indexOf(name) == 0)
        {
            return c.substring(name.length, c.length); 
        } 
    } 
    return ""; 
}


