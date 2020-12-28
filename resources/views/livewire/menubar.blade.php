<div>
<ul class="list-unstyled components mb-5 main-menu text-center">
    <li class="{{ Request::is('/*') ? 'active' : '' }}" wire:click="$set('tab', 'dashboard')" >
        <a href="{{route('dashboard')}}"><span class="fa fa-home"></span> {{ __('Dashboard') }}</a>
    </li>
    @if(Auth::user()->role_id <= 2)
    <li class="{{ Request::is('admin*') ? 'active' : '' }}">
        <a href="{{route('admin-setting')}}"><span class="fa fa-user-shield"></span> {{ __('Admin') }}</a>
    </li>
    @endif
    <li class="{{ Request::is('courses*') ? 'active' : '' }}">
        <a href="{{route('courses')}}"><span class="fa fa-book"></span> {{ __('Courses') }}</a>
    </li>
    <li class="{{ Request::is('classes*') ? 'active' : '' }}">
        <a href="{{route('courses')}}"><span class="fas fa-chalkboard-teacher"></span> {{ __('Classes') }}</a>
    </li>
    {{-- <li class="{{ Request::is('chats*') ? 'active' : '' }}">
        <a href="{{route('courses')}}"><span class="fa fa-comment-alt"></span> {{ __('Chats') }}</a>
    </li> --}}
    <li class="{{ Request::is('chats*') ? 'active' : '' }}">
        <a href="{{ route('logout') }}" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();"><span class="fa fa-cog"></span> {{ __('Logout') }}</a>
    </li>
</ul>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
</div>
