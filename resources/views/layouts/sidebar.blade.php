<div id="left-sidebar" class="sidebar ">
    <h5 class="brand-name">{{config('app.name')}} <a href="javascript:void(0)" class="menu_option float-right"><i class="fa fa-plus-square-o" aria-hidden="true"></i></a></h5>
    <nav id="left-sidebar-nav" class="sidebar-nav">
        <ul class="metismenu">
            <!-- <li class="g_heading">Project</li> -->
            <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}"><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
            <li class="{{ Request::is('admin/setting') ? 'active' : '' }}"><a href="{{route('setting')}}"><i class="fa fa-gear"></i><span>Setting</span></a></li>
            <li class="{{ Request::is('admin/category') ? 'active' : '' }}"><a href="{{route('category')}}"><i class="fa fa-list-ol"></i><span>Category</span></a></li>
            <li class="{{ Request::is('admin/blogs') ? 'active' : '' }}"><a href="{{route('blogs')}}"><i class="fa fa-rss"></i><span>Blogs</span></a></li>
            <li class="{{ Request::is('admin/projects') ? 'active' : '' }}"><a href="{{route('projects')}}"><i class="fa fa-tasks"></i><span>Projects</span></a></li>
            <li class="{{ Request::is('admin/services') ? 'active' : '' }}"><a href="{{route('services')}}"><i class="fa fa-cubes"></i><span>Services</span></a></li>
            <li class="{{ Request::is('admin/testmonial') ? 'active' : '' }}"><a href="{{route('testmonial')}}"><i class="fa fa-star-half-o"></i><span>Testmonial</span></a></li>
            <li class="{{ Request::is('admin/skills') ? 'active' : '' }}"><a href="{{route('skills')}}"><i class="fa fa-puzzle-piece"></i><span>Skills</span></a></li>
            <li class="{{ Request::is('admin/contact-requests') ? 'active' : '' }}"><a href="{{route('contact_requests')}}"><i class="fa fa-handshake-o"></i><span>Contact-Requests</span></a></li>
            <li class="{{ Request::is('admin/newsletters') ? 'active' : '' }}"><a href="{{route('newsletters')}}"><i class="fa fa-newspaper-o"></i><span>Newsletter</span></a></li>
            <li class="{{ Request::is('admin/resume') ? 'active' : '' }}"><a href="{{route('resume')}}"><i class="fa fa-file"></i><span>Resume</span></a></li>
        </ul>
    </nav>        
</div>