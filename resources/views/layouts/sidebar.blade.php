@php
    use App\Services\SidebarService;
    $menuItems = SidebarService::getMenu();
@endphp

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <span class="menu-text">
            <img src="{{ asset('assets/images/logo/logo-rs.webp') }}" class="bg-white mt-3" width="50px" alt="">
        </span>
    </div>
    
    <div class="sidebar-menu">
        @foreach ($menuItems as $item)
            @if (isset($item['type']) && $item['type'] === 'header')
                <!-- Menu Header/Label -->
                <div class="menu-label">{{ $item['label'] }}</div>
            @else
                <!-- Menu Item with Submenu -->
                @if (isset($item['submenu']) && SidebarService::getSubmenu($item)->count() > 0)
                    <a href="#" class="menu-item m-2 rounded-4 collapsed" data-bs-toggle="collapse" 
                       data-bs-target="#{{ $item['menu'] }}Menu">
                        <i class="{{ $item['icon'] }}"></i>
                        <span class="menu-text">{{ $item['label'] }}</span>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </a>
                    
                    <div class="collapse submenu" id="{{ $item['menu'] }}Menu">
                        @foreach (SidebarService::getSubmenu($item) as $subitem)
                            <a href="{{ SidebarService::getUrl($subitem) }}" 
                               class="menu-item m-2 rounded-4 {{ SidebarService::isActive($subitem) ? 'active' : '' }}">
                                <i class="{{ $subitem['icon'] }}" 
                                   @if(isset($subitem['icon_size']))
                                       style="font-size: {{ $subitem['icon_size'] }};"
                                   @endif>
                                </i>
                                <span class="menu-text">{{ $subitem['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <!-- Regular Menu Item (No Submenu) -->
                    <a href="{{ SidebarService::getUrl($item) }}" 
                       class="menu-item m-2 rounded-4 {{ SidebarService::isActive($item) ? 'active' : '' }}">
                        <i class="{{ $item['icon'] }}"></i>
                        <span class="menu-text">{{ $item['label'] }}</span>
                    </a>
                @endif
            @endif
        @endforeach
    </div>
</div>
