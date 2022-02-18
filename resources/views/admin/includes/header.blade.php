
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
     
      </ul>
  
    
  
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <div class="user-panel  d-flex right-nav">
            <div class="image">
                <img src={{asset("public/admin/img/logo.jpg")}} class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <div class="d-block">Tokatif Admin</div>
             </div>
            </div>
          </a>
          <div class="dropdown-menu  dropdown-menu-right">
          <a href="{{URL::route('admin-logout')}}" class="dropdown-item">
             
                  <h3 class="dropdown-item-title">
                   Logout
                    <span class="float-right text-sm text-danger"><i class="fas fa-sign-out-alt"></i></span>
                  </h3>
            </a>
           
          </div>
        </li>
        
        
      </ul>
   