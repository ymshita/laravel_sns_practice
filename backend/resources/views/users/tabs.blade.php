<ul class="nav nav-tabs nav-justified mt-3">
    <li class="nav-item">
        <a href="{{ route('users.show', ['name' => $user->name]) }}"
            class="nav-link text-muted {{ $hasArticles ? 'active' : '' }}">
            記事
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('users.likes', ['name' => $user->name]) }}"
            class="nav-link text-muted {{ $hasLikes ? 'active' : '' }}">
            いいね
        </a>
    </li>
</ul>
