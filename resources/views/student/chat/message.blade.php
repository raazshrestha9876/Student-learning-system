@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- User list section -->
                <div class="col-md-3 user-list border-end bg-light p-3">
                    <h4 class="text-secondary fw-bold">Users</h4>
                    <ul class="list-group">
                        @foreach($users as $user)
                        <li class="list-group-item d-flex align-items-center {{ isset($receiver) && $receiver->id == $user->id ? 'active' : '' }} border-0 py-2">
                            <img src="{{ asset($user->profile_pic ? 'upload/images/'.$user->profile_pic : 'upload/images/avatar.jpg') }}" alt="{{ $user->name }}" class="rounded-circle me-3 user-avatar">
                            <a href="{{ url('chat/' . $user->id) }}" class="ml-2 text-decoration-none flex-grow-1 user-link {{ isset($receiver) && $receiver->id == $user->id ? 'text-dark' : 'text-dark' }}">
                                {{ $user->name }}
                                <span class="unique-id text-muted" style="font-size: 0.7rem;">
                                    @if($user->is_role === 2)
                                    T{{ $user->id }}
                                    @elseif($user->is_role === 3)
                                    S{{ $user->class_id }}
                                    @elseif($user->is_role === 1)
                                    A{{ $user->id }}
                                    @endif
                                </span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Chat box section -->
                <div class="col-md-9 chat-box p-3 position-relative mt-4">
                    @if(isset($receiver))
                    <!-- Class name for students -->
                    @if(Auth::user()->is_role == 3)
                    <div class="class-name text-secondary mb-3">
                        Class: <strong>{{ $className }}</strong>
                    </div>
                    @endif
                    <!-- Receiver name -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="text-primary fw-bold">{{ $receiver->name }}</h4>
                            <h4 class="text-primary small">{{ $receiver->email }}</h4>
                        </div>
                        <span class="text-muted">{{ now()->format('d M, Y') }}</span>
                    </div>

                    <!-- Chat messages -->
                    <div class="messages p-4 mb-3" id="messages">
                        @foreach($messages as $message)
                        <div class="message mb-3 d-flex {{ $message->sender_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                            @if($message->sender_id == auth()->id())
                            <div class="sent-message shadow-sm">
                                <p class="mb-1">{{ $message->message }}</p>
                                <small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
                            </div>
                            @else
                            <div class="received-message shadow-sm">
                                <p class="mb-1">{{ $message->message }}</p>
                                <small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <!-- Message input form -->
                    <form action="{{ url('chat/send') }}" method="POST" class="input-group">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                        <textarea name="message" class="form-control border-0 shadow-sm" placeholder="Type a message..." required></textarea>
                        <button type="submit" class="btn btn-primary px-4">Send</button>
                    </form>
                    @else
                    <div class="d-flex justify-content-center align-items-center" style="height: 600px;">
                        <h4 class="text-muted">Select a user to start chatting</h4>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection

@section('style')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }

    .user-list {
        height: 100vh;
        overflow-y: auto;
        padding-top: 15px;
        background-color: #f8f9fa;
        box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
    }

    .user-list h4 {
        margin-bottom: 20px;
    }

    .list-group-item {
        border: none;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
    }

    .user-link {
        color: inherit;
    }

    .chat-box {
        border-radius: 10px;
        background-color: #ffffff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-height: 90vh;
    }

    .class-name {
        background-color: #e3f2fd;
        padding: 10px;
        border-radius: 8px;
    }

    .messages {
        height: 500px;
        overflow-y: auto;
        background-color: #ffffff;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .sent-message {
        background-color: #e3f2fd;
        padding: 10px;
        border-radius: 10px;
        max-width: 75%;
        display: inline-block;
    }

    .received-message {
        background-color: #fce4ec;
        padding: 10px;
        border-radius: 10px;
        max-width: 75%;
        display: inline-block;
    }
</style>
@endsection

@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const messagesContainer = document.getElementById('messages');
        messagesContainer.scrollTop = messagesContainer.scrollHeight; // Scroll to the bottom
    });
</script>
@endsection