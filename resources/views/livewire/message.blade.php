<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

<div>

<div class="container" >
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="cardc chat-app">
{{-- <div>
    <div class="row justify-content-center" wire:poll="mountComponent()"> --}}
        @if(auth()->user()->is_active == true)
            {{-- <div class="col-md-4" wire:init>
                <div class="card">
                    <div class="card-header">
                        Users
                    </div>
                    <div class="card-body chatbox p-0">
                        <ul class="list-group list-group-flush" wire:poll="render">
                            @foreach($users as $user)
                                @php
                                    $not_seen = \App\Models\Messages::where('user_id', $user->id)->where('receiver', auth()->id())->where('is_seen', false)->get() ?? null
                                @endphp
                                <a href="{{ route('show', $user->id) }}" class="text-dark link">
                                    <li class="list-group-item" wire:click="getUser({{ $user->id }})" id="user_{{ $user->id }}">
                                        <img class="img-fluid avatar" src="https://cdn.pixabay.com/photo/2017/06/13/12/53/profile-2398782_1280.png">
                                        @if($user->is_online) <i class="fa fa-circle text-success online-icon"></i> @endif {{ $user->name }}
                                        @if(filled($not_seen))
                                            <div class="badge badge-success rounded">{{ $not_seen->count() }}</div>
                                        @endif
                                    </li>
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div> --}}
            <div id="plist" class="people-list">

                <ul class="list-unstyled chat-list mt-2 mb-0">
                    @foreach($users as $user)
                    @php
                        $not_seen = \App\Models\Messages::where('user_id', $user->id)->where('receiver', auth()->id())->where('is_seen', false)->get() ?? null
                    @endphp
                       <a href="{{ route('show', $user->id) }}" class="text-dark link">
                    <li class="clearfix " wire:click="getUser({{ $user->id }})" id="user_{{ $user->id }}">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                        <div class="about float-right" dir="rtl">
                            <div class="name float-end" >{{ $user->name }}</div>
                            <br/>
                            @if($user->is_online)<div class="status"> <i class="fa fa-circle online"></i> متصل </div> @endif
                            @if(filled($not_seen)) <div class="status"> <i class="fa fa-circle offline"></i> {{ $not_seen->count() }} </div>    @endif
                        </div>
                    </li>
                    </a>
                    @endforeach

                </ul>
            </div>
        @endif
        <div class="chat"  dir="rtl">

                <div class="card-header">
                    @if(isset($clicked_user)) {{ $clicked_user->name }}

                    @elseif(auth()->user()->is_active == true)
                        اختر مستخدم لرؤيه الشات
                    @elseif($admin->is_online)
                        <i class="fa fa-circle text-success"></i> نحن متصلين
                    @else
                        رساله
                    @endif
                </div>
                    <div class="card-body message-box">
                        @if(!$messages)
                         لايوجد اي رساله
                        @else
                            @if(isset($messages))
                                @foreach($messages as $message)
                                    <div class="single-message @if($message->user_id !== auth()->id()) received @else sent @endif">
                                        <p class="font-weight-bolder my-0">{{ $message->user->name }}</p>
                                        <p class="my-0">{{ $message->message }}</p>
                                        @if (isPhoto($message->file))
                                            <div class="w-100 my-2">
                                                <img class="img-fluid rounded" loading="lazy" style="height: 250px" src="{{ $message->file }}">
                                            </div>
                                        @elseif (isVideo($message->file))
                                            <div class="w-100 my-2">
                                                <video style="height: 250px" class="img-fluid rounded" controls>
                                                    <source src="{{ $message->file }}">
                                                </video>
                                            </div>
                                        @elseif ($message->file)
                                            <div class="w-100 my-2">
                                                <a href="{{ $message->file}}" class="bg-light p-2 rounded-pill" target="_blank"><i class="fa fa-download"></i>
                                                    {{ $message->file_name }}
                                                </a>
                                            </div>
                                        @endif
                                        <small class="text-muted w-100">Sent <em>{{ $message->created_at }}</em></small>
                                    </div>
                                @endforeach
                            @else
                            لايوجد اي رساله
                            @endif
                            @if(!isset($clicked_user) and auth()->user()->is_active == true)
                             اضغط على مستخدم لرويه الشات
                            @endif
                        @endif
                    </div>
                @if(auth()->user()->is_active == false)
                    <div class="card-footer">
                        <form wire:submit.prevent="SendMessage" enctype="multipart/form-data">
                            <div wire:loading wire:target='SendMessage'>
                                Sending message . . .
                            </div>
                            <div wire:loading wire:target="file">
                                Uploading file . . .
                            </div>
                            @if($file)
                                <div class="mb-2">
                                   You have an uploaded file <button type="button" wire:click="resetFile" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Remove {{ $file->getClientOriginalName() }}</button>
                                </div>
                            @else
                                No file is uploaded.
                            @endif
                            <div class="row">
                                <div class="col-md-7">
                                    <input wire:model="message" class="form-control input shadow-none w-100 d-inline-block" placeholder="Type a message" @if(!$file) required @endif>
                                </div>
                                @if(empty($file))
                                <div class="col-md-1">
                                    <button type="button" class="border" id="file-area">
                                        <label>
                                            <i class="fa fa-file-upload"></i>
                                            <input type="file" wire:model="file">
                                        </label>
                                    </button>
                                </div>
                                @endif
                                <div class="col-md-4">
                                    <button class="btn btn-primary d-inline-block w-100"><i class="far fa-paper-plane"></i> Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

        </div>
    </div>
</div>
            </div>
        </div>
