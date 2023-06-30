<nav class="navbar navbar-expand-md navbar-light 
            sticky-top border border-0-top border-sm 
            bg-light py-3">
    <div class="navbar-header">
        <a class="navbar-brand" href="{$php.self$}?page=home">
            <img src="{$site.base_url$}media/image/logo.svg" width="50"/>
            {* {$site.name$} *}
        </a>
    </div>
    <button 
        class="navbar-toggler collapsed" 
        type="button" 
        data-toggle="collapse" 
        data-target="#navbars-main" 
        aria-controls="navbars-main" 
        aria-expanded="false" 
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div
        id="navbars-main" 
        class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {$eval {$@php.get.page$} == 'home' ? 'active' : '' $}">
                <a class="nav-link" href="{$php.self$}?page=home">Home</a>
            </li>
            <li class="nav-item {$eval {$@php.get.page$} == 'about' ? 'active' : '' $}">
                <a class="nav-link" href="{$php.self$}?page=about">About</a>
            </li>
            <li class="nav-item dropdown {$eval substr_compare({$@php.get.page$}, 'testing/', 0, 8) == 0 ? 'active' : '' $}">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Testing<span class="caret"></span></a>
                <div class="dropdown-menu">
                    {$foreach( {$@list_sub_templates('testing', 'pages') $} as page )
                        {<a class="dropdown-item {$eval {$@php.get.page $} == {$@page.rpath $} ? 'active' : '' $}" href="{$php.self $}?page={$page.rpath $}">{$page.name $}</a>
                    }
                $}
                </div>
            </li>
            <li class="nav-item dropdown {$eval substr_compare({$@php.get.page$}, 'account/', 0, 8) == 0 ? 'active' : '' $}">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Account<span class="caret"></span></a>
                <div class="dropdown-menu">
                {$if (!isset({$@login_info$}))
                    {<a class="dropdown-item {$eval {$@php.get.page$} == 'account/login' ? 'active' : '' $}" href="{$php.self$}?page=account/login"><i class="fa fa-fw fa-lg fa-sign-in"></i> login</a>
                    <a class="dropdown-item {$eval {$@php.get.page$} == 'account/register' ? 'active' : '' $}" href="{$php.self$}?page=account/register"><i class="fa fa-fw fa-lg fa-user-plus"></i> register</a>
                } else
                    {<a class="dropdown-item {$eval {$@php.get.page$} == 'account/register' ? 'active' : '' $}" href="{$php.self$}?page=account/profile"><i class="fa fa-fw fa-lg fa-circle-user"></i> profile</a>
                    <button class="dropdown-item" onclick="handle_logout()"><i class="fa fa-fw fa-lg fa-sign-out"></i> logout</button>
                }
                $}
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item {$eval {$@php.get.page$} == 'account/report' ? 'active' : '' $}" href="{$php.self$}?page=account/report"><i class="fa fa-fw fa-lg fa-exclamation-circle"></i> report an issue</a>
                </div>
            </li>
        </ul>
        {* <form class="form-inline" 
            action="javascript:void(0)" 
            onsubmit="handle_search_form(this)">
            <div class="input-group">
                <input 
                    type="search" 
                    name="search_query" 
                    class="form-control border-right-0" 
                    placeholder="" 
                    aria-label="Search by topics" />
                <div class="input-group-append">
                    <button 
                        class="form-control btn btn-primary" 
                        type="submit"
                        id="search-button"
                        name="query"
                        value="" >
                        <span class="fa fa-search"></span>
                    </button>
                </div>
            </div>
        </form> *}
    </div>
    {$if (isset({$@login_info$}))
    {<div class="d-table d-md-inline-block float-right float-md-none">
        <div class="d-table-cell align-middle">{$login_info.username$}</div>
        <a class="d-table-cell align-middle" href="{$php.self$}?page=account/profile"><i class="fa-regular fa-2x fa-circle-user p-2"></i></a>
    </div>}
    $}
</nav>