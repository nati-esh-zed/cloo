<div class="container row mx-auto">
    <div class="border border-sm rounded bg-light 
                col-12 col-sm-9 col-md-6 col-lg-4  
                my-3 mx-auto p-4 py-2">
        <div class="h3 mb-1 py-1 px-2">login</div>
        <div class="border-top mb-2"></div>
        <div class="section-content">
            <form class="">
                <div class="form-group mb-2">
                    {* <label for="login_username">Username</label> *}
                    <input autofocus
                        class="form-control form-control-md" 
                        type="text" 
                        id="login_username"
                        name="username" 
                        placeholder="username"
                        value=""/>
                </div>
                <div class="form-group mb-2">
                    {* <label for="login_password">Password</label> *}
                    <input 
                        class="form-control form-control-md" 
                        type="password" 
                        id="login_password"
                        name="password" 
                        placeholder="password"
                        value=""/>
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