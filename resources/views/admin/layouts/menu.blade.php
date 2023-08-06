<!-- Add icons to the links using the .nav-icon class
with font-awesome or any other icon font library -->
<li class="nav-header"></li>
<li class="nav-item">
  <a href="{{ aurl('') }}" class="nav-link {{ active_link(null,'active') }}">
    <i class="nav-icon fas fa-home"></i>
    <p>
      {{ trans('admin.dashboard') }}
    </p>
  </a>
</li>
@if(admin()->user()->role('settings_show'))
<li class="nav-item">
  <a href="{{ aurl('settings') }}" class="nav-link  {{ active_link('settings','active') }}">
    <i class="nav-icon fas fa-cogs"></i>
    <p>
      {{ trans('admin.settings') }}
    </p>
  </a>
</li>
@endif
@if(admin()->user()->role("admins_show"))
<li class="nav-item {{ active_link('admins','menu-open') }}">
  <a href="#" class="nav-link  {{ active_link('admins','active') }}">
    <i class="nav-icon fas fa-users"></i>
    <p>
      {{trans('admin.admins')}}
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('admins')}}" class="nav-link {{ active_link('admins','active') }}">
        <i class="fas fa-users nav-icon"></i>
        <p>{{trans('admin.admins')}}</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('admins/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}}</p>
      </a>
    </li>
  </ul>
</li>
@endif
@if(admin()->user()->role("admingroups_show"))
<li class="nav-item {{ active_link('admingroups','menu-open') }}">
  <a href="#" class="nav-link  {{ active_link('admingroups','active') }}">
    <i class="nav-icon fas fa-users"></i>
    <p>
      {{trans('admin.admingroups')}}
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('admingroups')}}" class="nav-link {{ active_link('admingroups','active') }}">
        <i class="fas fa-users nav-icon"></i>
        <p>{{trans('admin.admingroups')}}</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('admingroups/create') }}" class="nav-link ">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}}</p>
      </a>
    </li>
  </ul>
</li>
@endif


<!--categories_start_route-->
@if(admin()->user()->role("categories_show"))
<li class="nav-item {{active_link('categories','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('categories','active')}}">
    <i class="nav-icon fa fa-icons"></i>
    <p>
      {{trans('admin.categories')}} 
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('categories')}}" class="nav-link  {{active_link('categories','active')}}">
        <i class="fa fa-icons nav-icon"></i>
        <p>{{trans('admin.categories')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('categories/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--categories_end_route-->

<!--products_start_route-->
@if(admin()->user()->role("products_show"))
<li class="nav-item {{active_link('products','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('products','active')}}">
    <i class="nav-icon fa fa-icons"></i>
    <p>
      {{trans('admin.products')}} 
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('products')}}" class="nav-link  {{active_link('products','active')}}">
        <i class="fa fa-icons nav-icon"></i>
        <p>{{trans('admin.products')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('products/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--products_end_route-->
