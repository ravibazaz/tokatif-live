
<div class="sidebar">
  <ul>
    
    <li class="{{ Request::segment(1)=='my-lesson' ? 'active' : '' }}"> 
        <a href="{{route('my-lesson')}}">
        <img src="https://staging.tokatif.com/public/frontendassets/images/lesson_icon.png" class="img-fluid normal"/>
        <img src="https://staging.tokatif.com/public/frontendassets/images/lesson_icon.png" class="hover-on"/>
        <span> My Lessons </span></a>
    </li> 
    <!-- <li class="{{ Request::segment(1)=='lesson-package' ? 'active' : '' }}"> 
        <a href="{{route('lesson-package')}}">
        <img src="https://staging.tokatif.com/public/frontendassets/images/lesson_icon.png" class="img-fluid normal"/>
        <img src="https://staging.tokatif.com/public/frontendassets/images/lesson_iconhover.png" class="hover-on"/>
        <span> My Packages </span></a>
    </li> -->
    <li class="{{ Request::segment(1)=='my-students' ? 'active' : '' }}">
        <a href="{{route('my-students')}}"> 
        <img src="https://staging.tokatif.com/public/frontendassets/images/students.png" class="img-fluid normal"/>
        <img src="https://staging.tokatif.com/public/frontendassets/images/students.png" class="hover-on"/>
        <span>My Students</span></a>
    </li>
    <li class="{{ Request::segment(1)=='my-wallet' ? 'active' : '' }}">
        <a href="{{route('my-wallet')}}">
        <img src="https://staging.tokatif.com/public/frontendassets/images/wallet-icon.png" class="img-fluid normal"/>
        <img src="https://staging.tokatif.com/public/frontendassets/images/wallet-icon.png" class="hover-on"/>
        <span>My Wallet </span></a>
    </li>
    <li class="{{ Request::segment(1)=='lesson-management' ? 'active' : '' }}">
        <a href="{{route('lesson-management')}}">
        <img src="https://staging.tokatif.com/public/frontendassets/images/policy.png" class="img-fluid normal"/>
        <img src="https://staging.tokatif.com/public/frontendassets/images/policy.png" class="hover-on"/>
        <span> Lesson Settings </span></a>
    </li>
    <li>
        <a href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard" class="active collapsed" aria-expanded="false"> 
            <img src="https://staging.tokatif.com/public/frontendassets/images/teachesettings-icon.png" class="img-fluid normal"/>
            <img src="https://staging.tokatif.com/public/frontendassets/images/teachesettings-icon.png" class="hover-on"/> 
            <span class="nav-label">  Teacher Settings</span> 
            <span class="fa fa-chevron-left pull-right"></span> </a>
        <ul class="sub-menu collapse tedit-icon" id="dashboard" style="">
            <li class="{{ Request::segment(1)=='teacher-profile-edit' ? 'active' : '' }}"><a href="{{route('teacher-profile-edit')}}">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Edit Teacher Profile</span></a></li> 
            <li class="{{ Request::segment(1)=='teacher-calendar' ? 'active' : '' }}"><a href="{{route('teacher-calendar')}}"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Edit Availability</span> </a></li>
            
            <!--
            <li class="active"><a href="{{route('teacher-profile')}}">Edit Teacher Profile</a></li>
            <li><a href="#">Withdraw</a></li>-->
        </ul>
    </li>
    <li class="{{ Request::segment(1)=='teacher-settings' ? 'active' : '' }}"> 
        <a href="{{route('teacher-settings')}}">
        <img src="https://staging.tokatif.com/public/frontendassets/images/accountsettings-icon.png" class="img-fluid normal"/>
        <img src="https://staging.tokatif.com/public/frontendassets/images/accountsettings-icon.png" class="hover-on"/>
        <span>Account Settings</span></a>
    </li>
    <li class="{{ Request::segment(1)=='community' ? 'active' : '' }}"> 
        <a href="{{route('community')}}">
        <img src="https://staging.tokatif.com/public/frontendassets/images/teacherforum-icon.png" class="img-fluid normal"/>
        <img src="https://staging.tokatif.com/public/frontendassets/images/teacherforum-icon.png" class="hover-on"/>
        <span>Community</span>
        </a>
    </li>
    <li class="{{ Request::segment(1)=='support' ? 'active' : '' }}">
        <a href="{{route('support')}}">
        <img src="https://staging.tokatif.com/public/frontendassets/images/support-icon.png" class="img-fluid normal"/>
        <img src="https://staging.tokatif.com/public/frontendassets/images/support-icon.png" class="hover-on"/>
        <span>Support</span>
        </a>
    </li>
    
    
    
    <!--<li>
        <a href="javascript:void(0);" data-toggle="collapse" data-target="#lesson" class="active collapsed" aria-expanded="false"> 
            <img src="https://staging.tokatif.com/public/frontendassets/images/lesson_icon.png" class="img-fluid normal"/>
            <img src="https://staging.tokatif.com/public/frontendassets/images/lesson_iconhover.png" class="hover-on"/>
            <span class="nav-label">Lesson Settings</span> 
            <span class="fa fa-chevron-left pull-right"></span></a>
        <ul class="sub-menu collapse" id="lesson" style="">
            <li><a href="{{route('lesson-management')}}"> Lesson Management </a></li>
            <li><a href="{{route('lesson-package')}}"> My Packages </a></li>
            <li>
            <a href="{{route('my-lesson')}}"> 
            <img src="https://staging.tokatif.com/public/frontendassets/images/lesson_icon.png" class="img-fluid normal"/>
            <img src="https://staging.tokatif.com/public/frontendassets/images/lesson_iconhover.png" class="hover-on"/>
            My Lessons </a></li> 
            <li><a href="{{route('add-lesson')}}"> Create New Lesson </a></li> 
        </ul>
    
    </li>-->
    
    
    
    <!--<li><a href="{{route('community')}}"><i class="fa fa-table"></i><span>Teacher Forum</span></a></li>-->
    
    </ul>
</div>