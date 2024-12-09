<div class="card">
    <div class="card-body">
        <ul class="navbar-nav" style="@media (max-width: 767px) { flex-direction: column; }">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('income') }}">Income</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('expense') }}">Expense</a>
            </li>
        </ul>
    </div>
</div>