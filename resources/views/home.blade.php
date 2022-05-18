@include('Front.include.header')

@section('content')
<div class="container">
    @livewire('message', ['users' => $users, 'messages' => $messages ?? null])
</div>
@include('Front.include.footer')
