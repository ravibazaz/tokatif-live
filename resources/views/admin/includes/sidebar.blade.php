
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <!-- <img src={{asset("public/admin/img/logo.jpg")}} alt="Go deliver" class="brand-image img-circle elevation-3"
           style="opacity: .8"> -->
      <span class="brand-text font-weight-light">Tokatif Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
     

      <!-- Sidebar Menu -->
      <nav class="mt-2">


        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
          <li class="nav-item has-treeview ">
            <a href="{{route('admin-dashboard')}}" class="nav-link {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                {{-- <i class="right fas fa-angle-left"></i> --}}
              </p>
            </a>
          </li>


          
          <li class="nav-item has-treeview {{ (request()->is('admin/teachers') || request()->is('admin/teacher/*') || request()->is('admin/students') || request()->is('admin/student/*') ) ? 'menu-open' : '' }}"> 
            <a href="javascript:void(0)" class="nav-link {{ (request()->is('admin/teachers') || request()->is('admin/teacher/*') || request()->is('admin/students') || request()->is('admin/student/*') ) ? 'active' : '' }}">
              <i class="nav-icon fa fa-tasks"></i>
              <p> Menu  <i class="right fas fa-angle-left"></i> </p>
            </a>

                <ul class="nav nav-treeview">
                  
                    <li class="nav-item {{ (request()->is('admin/teachers') || request()->is('admin/teacher/*')) ? 'menu-open' : '' }}"> 
                        <a href="{{route('admin-teacher-list')}}" class="nav-link {{ (request()->is('admin/teachers') || request()->is('admin/teacher/*')) ? 'active' : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p> Teacher </p>
                        </a>
                    </li>
                  
                    <li class="nav-item {{ (request()->is('admin/students') || request()->is('admin/student/*')) ? 'menu-open' : '' }}"> 
                        <a href="{{route('admin-student-list')}}" class="nav-link {{ (request()->is('admin/students') || request()->is('admin/student/*')) ? 'active' : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p> Student </p>
                        </a>
                    </li>

                  
                </ul>
          </li>

          

          
          <li class="nav-item has-treeview {{ (request()->is('admin/website-setting') || request()->is('admin/website-setting/*') ) ? 'menu-open' : '' }}"> 
            <a href="{{route('admin-website-setting-list')}}" class="nav-link {{ (request()->is('admin/website-setting') || request()->is('admin/website-setting/*') ) ? 'active' : '' }}">
              <i class="nav-icon fa fa-tasks"></i>
              <p> Website Setting </p>
            </a>
          </li>
         




          <li class="nav-item has-treeview {{ (request()->is('admin/home-banners') || request()->is('admin/home-banner/*') || request()->is('admin/languages') || request()->is('admin/language/*') || request()->is('admin/whylearn') || request()->is('admin/whylearn/*') || request()->is('admin/whytech') || request()->is('admin/whytech/*') || request()->is('admin/howitworks') || request()->is('admin/howitworks/*') || request()->is('admin/becomefluentin') || request()->is('admin/becomefluentin/*') ) ? 'menu-open' : '' }}"> 
            <a href="javascript:void(0)" class="nav-link {{ (request()->is('admin/home-banners') || request()->is('admin/home-banner/*') || request()->is('admin/languages') || request()->is('admin/language/*') || request()->is('admin/whylearn') || request()->is('admin/whylearn/*') || request()->is('admin/whytech') || request()->is('admin/whytech/*') || request()->is('admin/howitworks') || request()->is('admin/howitworks/*') || request()->is('admin/becomefluentin') || request()->is('admin/becomefluentin/*') ) ? 'active' : '' }}">
              <i class="nav-icon fa fa-tasks"></i>
              <p> Home  <i class="right fas fa-angle-left"></i> </p>
            </a>

                <ul class="nav nav-treeview">
                  
                    <li class="nav-item {{ (request()->is('admin/home-banners') || request()->is('admin/home-banner/*')) ? 'menu-open' : '' }}"> 
                        <a href="{{route('admin-home-banner-list')}}" class="nav-link {{ (request()->is('admin/home-banners') || request()->is('admin/home-banner/*')) ? 'active' : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p> Banner </p>
                        </a>
                    </li>
                  
                    <li class="nav-item {{ (request()->is('admin/languages') || request()->is('admin/language/*')) ? 'menu-open' : '' }}"> 
                        <a href="{{route('admin-language-list')}}" class="nav-link {{ (request()->is('admin/languages') || request()->is('admin/language/*')) ? 'active' : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p> Language </p>
                        </a>
                    </li>
                    
                    
                    <li class="nav-item {{ (request()->is('admin/whylearn') || request()->is('admin/whylearn/*')) ? 'menu-open' : '' }}"> 
                        <a href="{{route('admin-whylearn-list')}}" class="nav-link {{ (request()->is('admin/whylearn') || request()->is('admin/whylearn/*')) ? 'active' : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p> Why Learn </p>
                        </a>
                    </li>
                    
                    
                    <li class="nav-item {{ (request()->is('admin/whytech') || request()->is('admin/whytech/*')) ? 'menu-open' : '' }}"> 
                        <a href="{{route('admin-whytech-list')}}" class="nav-link {{ (request()->is('admin/whytech') || request()->is('admin/whytech/*')) ? 'active' : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p> Why Tech </p>
                        </a>
                    </li>
                    
                    
                    
                    <li class="nav-item {{ (request()->is('admin/howitworks') || request()->is('admin/howitworks/*')) ? 'menu-open' : '' }}"> 
                        <a href="{{route('admin-howitworks-list')}}" class="nav-link {{ (request()->is('admin/howitworks') || request()->is('admin/howitworks/*')) ? 'active' : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p> How It Works </p>
                        </a>
                    </li>
                    
                    
                    <li class="nav-item {{ (request()->is('admin/becomefluentin') || request()->is('admin/becomefluentin/*')) ? 'menu-open' : '' }}"> 
                        <a href="{{route('admin-becomefluentin-list')}}" class="nav-link {{ (request()->is('admin/becomefluentin') || request()->is('admin/becomefluentin/*')) ? 'active' : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p> Become Fluent In </p>
                        </a>
                    </li>

                  
                </ul>
          </li>


          

          <li class="nav-item has-treeview {{ (request()->is('admin/articles') || request()->is('admin/article/*') || request()->is('admin/articles') || request()->is('admin/article/*') ) ? 'menu-open' : '' }}"> 
            <a href="javascript:void(0)" class="nav-link {{ (request()->is('admin/articles') || request()->is('admin/article/*') || request()->is('admin/articles') || request()->is('admin/article/*') ) ? 'active' : '' }}">
              <i class="nav-icon fa fa-tasks"></i>
              <p> Community  <i class="right fas fa-angle-left"></i> </p>
            </a>

                <ul class="nav nav-treeview">
                  
                    <li class="nav-item {{ (request()->is('admin/articles') || request()->is('admin/article/*')) ? 'menu-open' : '' }}"> 
                        <a href="{{route('admin-article-list')}}" class="nav-link {{ (request()->is('admin/articles') || request()->is('admin/article/*')) ? 'active' : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p> article </p>
                        </a>
                    </li>
                  
                    <!--<li class="nav-item {{ (request()->is('admin/students') || request()->is('admin/student/*')) ? 'menu-open' : '' }}"> 
                        <a href="{{route('admin-student-list')}}" class="nav-link {{ (request()->is('admin/students') || request()->is('admin/student/*')) ? 'active' : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p> Forum </p>
                        </a>
                    </li>-->

                  
                </ul>
          </li>
          
          
          
          <li class="nav-item has-treeview {{ (request()->is('admin/support') || request()->is('admin/support/*') ) ? 'menu-open' : '' }}"> 
            <a href="{{route('admin-support-list')}}" class="nav-link {{ (request()->is('admin/support') || request()->is('admin/support/*') ) ? 'active' : '' }}">
              <i class="nav-icon fa fa-tasks"></i>
              <p> Support </p>
            </a>
          </li>  
          
          <li class="nav-item has-treeview {{ (request()->is('admin/privacy') || request()->is('admin/privacy/*') ) ? 'menu-open' : '' }}"> 
            <a href="{{route('admin-privacy-list')}}" class="nav-link {{ (request()->is('admin/privacy') || request()->is('admin/privacy/*') ) ? 'active' : '' }}">
              <i class="nav-icon fa fa-tasks"></i>
              <p> Privacy </p>
            </a>
          </li>  
          
          <li class="nav-item has-treeview {{ (request()->is('admin/terms') || request()->is('admin/terms/*') ) ? 'menu-open' : '' }}"> 
            <a href="{{route('admin-terms-list')}}" class="nav-link {{ (request()->is('admin/terms') || request()->is('admin/terms/*') ) ? 'active' : '' }}">
              <i class="nav-icon fa fa-tasks"></i>
              <p> Terms </p>
            </a>
          </li>


          
        
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  
