<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="logo d-flex align-items-center gap-2">

            @if ($appSetting->logo_url)
                <img src="{{ $appSetting->logo_url }}" alt="Logo" style="height: 30px; width: auto;">
            @endif

            <span>{{ $appSetting->website_name ?? 'Servis.in' }}</span>
        </a>

        <button class="sidebar-close-btn" id="sidebar-close-btn">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <ul class="sidebar-nav">
        <li>
            <a href="{{ route('admin.dashboard') }}" @class(['active' => request()->routeIs('admin.dashboard')])>
                <i class="fas fa-tachometer-alt icon"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.services.index') }}" @class(['active' => request()->routeIs('admin.services.*')])>
                <i class="fas fa-wrench icon"></i> Manajemen Layanan
            </a>
        </li>
        <li>
            <a href="{{ route('admin.orders.index') }}" @class(['active' => request()->routeIs('admin.orders.*')])>
                <i class="fas fa-box icon"></i> Manajemen Pesanan
            </a>
        </li>
        <li>
            <a href="{{ route('admin.settings.edit') }}" @class(['active' => request()->routeIs('admin.settings.*')])>
                <i class="fas fa-cog icon"></i>Pengaturan Website
            </a>
        </li>
    </ul>
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="fas fa-sign-out-alt icon"></i>
                <span>Logout</span>
            </a>
        </form>
    </div>
</aside>
