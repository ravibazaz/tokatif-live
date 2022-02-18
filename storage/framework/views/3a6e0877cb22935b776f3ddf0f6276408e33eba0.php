
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <!-- <img src=<?php echo e(asset("public/admin/img/logo.jpg")); ?> alt="Go deliver" class="brand-image img-circle elevation-3"
           style="opacity: .8"> -->
      <span class="brand-text font-weight-light">Tokatif Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
     

      <!-- Sidebar Menu -->
      <nav class="mt-2">


        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
          <li class="nav-item has-treeview ">
            <a href="<?php echo e(route('admin-dashboard')); ?>" class="nav-link <?php echo e((request()->is('admin/dashboard')) ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                
              </p>
            </a>
          </li>


          
          <li class="nav-item has-treeview <?php echo e((request()->is('admin/teachers') || request()->is('admin/teacher/*') || request()->is('admin/students') || request()->is('admin/student/*') ) ? 'menu-open' : ''); ?>"> 
            <a href="javascript:void(0)" class="nav-link <?php echo e((request()->is('admin/teachers') || request()->is('admin/teacher/*') || request()->is('admin/students') || request()->is('admin/student/*') ) ? 'active' : ''); ?>">
              <i class="nav-icon fa fa-tasks"></i>
              <p> Menu  <i class="right fas fa-angle-left"></i> </p>
            </a>

                <ul class="nav nav-treeview">
                  
                    <li class="nav-item <?php echo e((request()->is('admin/teachers') || request()->is('admin/teacher/*')) ? 'menu-open' : ''); ?>"> 
                        <a href="<?php echo e(route('admin-teacher-list')); ?>" class="nav-link <?php echo e((request()->is('admin/teachers') || request()->is('admin/teacher/*')) ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p> Teacher </p>
                        </a>
                    </li>
                  
                    <li class="nav-item <?php echo e((request()->is('admin/students') || request()->is('admin/student/*')) ? 'menu-open' : ''); ?>"> 
                        <a href="<?php echo e(route('admin-student-list')); ?>" class="nav-link <?php echo e((request()->is('admin/students') || request()->is('admin/student/*')) ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p> Student </p>
                        </a>
                    </li>

                  
                </ul>
          </li>

          

          
          <li class="nav-item has-treeview <?php echo e((request()->is('admin/website-setting') || request()->is('admin/website-setting/*') ) ? 'menu-open' : ''); ?>"> 
            <a href="<?php echo e(route('admin-website-setting-list')); ?>" class="nav-link <?php echo e((request()->is('admin/website-setting') || request()->is('admin/website-setting/*') ) ? 'active' : ''); ?>">
              <i class="nav-icon fa fa-tasks"></i>
              <p> Website Setting </p>
            </a>
          </li>
         




          <li class="nav-item has-treeview <?php echo e((request()->is('admin/home-banners') || request()->is('admin/home-banner/*') || request()->is('admin/languages') || request()->is('admin/language/*') || request()->is('admin/whylearn') || request()->is('admin/whylearn/*') || request()->is('admin/whytech') || request()->is('admin/whytech/*') || request()->is('admin/howitworks') || request()->is('admin/howitworks/*') || request()->is('admin/becomefluentin') || request()->is('admin/becomefluentin/*') ) ? 'menu-open' : ''); ?>"> 
            <a href="javascript:void(0)" class="nav-link <?php echo e((request()->is('admin/home-banners') || request()->is('admin/home-banner/*') || request()->is('admin/languages') || request()->is('admin/language/*') || request()->is('admin/whylearn') || request()->is('admin/whylearn/*') || request()->is('admin/whytech') || request()->is('admin/whytech/*') || request()->is('admin/howitworks') || request()->is('admin/howitworks/*') || request()->is('admin/becomefluentin') || request()->is('admin/becomefluentin/*') ) ? 'active' : ''); ?>">
              <i class="nav-icon fa fa-tasks"></i>
              <p> Home  <i class="right fas fa-angle-left"></i> </p>
            </a>

                <ul class="nav nav-treeview">
                  
                    <li class="nav-item <?php echo e((request()->is('admin/home-banners') || request()->is('admin/home-banner/*')) ? 'menu-open' : ''); ?>"> 
                        <a href="<?php echo e(route('admin-home-banner-list')); ?>" class="nav-link <?php echo e((request()->is('admin/home-banners') || request()->is('admin/home-banner/*')) ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p> Banner </p>
                        </a>
                    </li>
                  
                    <li class="nav-item <?php echo e((request()->is('admin/languages') || request()->is('admin/language/*')) ? 'menu-open' : ''); ?>"> 
                        <a href="<?php echo e(route('admin-language-list')); ?>" class="nav-link <?php echo e((request()->is('admin/languages') || request()->is('admin/language/*')) ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p> Language </p>
                        </a>
                    </li>
                    
                    
                    <li class="nav-item <?php echo e((request()->is('admin/whylearn') || request()->is('admin/whylearn/*')) ? 'menu-open' : ''); ?>"> 
                        <a href="<?php echo e(route('admin-whylearn-list')); ?>" class="nav-link <?php echo e((request()->is('admin/whylearn') || request()->is('admin/whylearn/*')) ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p> Why Learn </p>
                        </a>
                    </li>
                    
                    
                    <li class="nav-item <?php echo e((request()->is('admin/whytech') || request()->is('admin/whytech/*')) ? 'menu-open' : ''); ?>"> 
                        <a href="<?php echo e(route('admin-whytech-list')); ?>" class="nav-link <?php echo e((request()->is('admin/whytech') || request()->is('admin/whytech/*')) ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p> Why Tech </p>
                        </a>
                    </li>
                    
                    
                    
                    <li class="nav-item <?php echo e((request()->is('admin/howitworks') || request()->is('admin/howitworks/*')) ? 'menu-open' : ''); ?>"> 
                        <a href="<?php echo e(route('admin-howitworks-list')); ?>" class="nav-link <?php echo e((request()->is('admin/howitworks') || request()->is('admin/howitworks/*')) ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p> How It Works </p>
                        </a>
                    </li>
                    
                    
                    <li class="nav-item <?php echo e((request()->is('admin/becomefluentin') || request()->is('admin/becomefluentin/*')) ? 'menu-open' : ''); ?>"> 
                        <a href="<?php echo e(route('admin-becomefluentin-list')); ?>" class="nav-link <?php echo e((request()->is('admin/becomefluentin') || request()->is('admin/becomefluentin/*')) ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p> Become Fluent In </p>
                        </a>
                    </li>

                  
                </ul>
          </li>


          

          <li class="nav-item has-treeview <?php echo e((request()->is('admin/articles') || request()->is('admin/article/*') || request()->is('admin/articles') || request()->is('admin/article/*') ) ? 'menu-open' : ''); ?>"> 
            <a href="javascript:void(0)" class="nav-link <?php echo e((request()->is('admin/articles') || request()->is('admin/article/*') || request()->is('admin/articles') || request()->is('admin/article/*') ) ? 'active' : ''); ?>">
              <i class="nav-icon fa fa-tasks"></i>
              <p> Community  <i class="right fas fa-angle-left"></i> </p>
            </a>

                <ul class="nav nav-treeview">
                  
                    <li class="nav-item <?php echo e((request()->is('admin/articles') || request()->is('admin/article/*')) ? 'menu-open' : ''); ?>"> 
                        <a href="<?php echo e(route('admin-article-list')); ?>" class="nav-link <?php echo e((request()->is('admin/articles') || request()->is('admin/article/*')) ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p> article </p>
                        </a>
                    </li>
                  
                    <!--<li class="nav-item <?php echo e((request()->is('admin/students') || request()->is('admin/student/*')) ? 'menu-open' : ''); ?>"> 
                        <a href="<?php echo e(route('admin-student-list')); ?>" class="nav-link <?php echo e((request()->is('admin/students') || request()->is('admin/student/*')) ? 'active' : ''); ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p> Forum </p>
                        </a>
                    </li>-->

                  
                </ul>
          </li>
          
          
          
          <li class="nav-item has-treeview <?php echo e((request()->is('admin/support') || request()->is('admin/support/*') ) ? 'menu-open' : ''); ?>"> 
            <a href="<?php echo e(route('admin-support-list')); ?>" class="nav-link <?php echo e((request()->is('admin/support') || request()->is('admin/support/*') ) ? 'active' : ''); ?>">
              <i class="nav-icon fa fa-tasks"></i>
              <p> Support </p>
            </a>
          </li>


          
        
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  
<?php /**PATH /home/tokatifc/staging.tokatif.com/resources/views/admin/includes/sidebar.blade.php ENDPATH**/ ?>