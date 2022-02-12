<aside id="sidebar">
    <nav>
        <div class="logo">
            <img src="{{ asset('img/logo.jpg') }}"
                alt="logo brand"
                width="50"
                height="50">
        </div>
        <div class="nav-list">
            <ul class="list">
                <li class="list-item">
                    <a href="#dashboard" 
                        title="dashboard" 
                        class="btn-nav-item">
                        <i data-feather="bar-chart-2"></i>
                    </a>
                </li>
                <li class="list-item">
                    <a href="#menu" 
                        title="menu"
                        class="btn-nav-item">
                        <i data-feather="activity"></i>
                    </a>
                </li>
                <li class="list-item">
                    <a href="#orders" 
                        title="orders"
                        class="btn-nav-item">
                        <i data-feather="book-open"></i>
                    </a>
                </li>
                <li class="list-item">
                    <a href="#inventories" 
                        title="inventories" 
                        class="btn-nav-item">
                        <i data-feather="archive"></i>
                    </a>
                </li>
                <li class="list-item">
                    <a href="#reports" 
                        title="reports" 
                        class="btn-nav-item">
                        <i data-feather="database"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="user">
            <form id="logout-form" 
                action="{{ route('logout') }}" 
                method="POST">
                @csrf

                <button type="button" class="btn btn-user btn-logout">
                    <i data-feather="log-out"></i>
                </button>
            </form>
        </div>
    </nav>
</aside>