@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Class List -->
                <div class="col-md-3 class-list border-end bg-light p-3">
                    <h4 class="text-secondary fw-bold">Classes</h4>
                    <ul class="list-group" id="class-list">
                        @foreach($classes as $class)
                        <li class="list-group-item class-item" data-class-id="{{ $class->id }}">
                            {{ $class->name }}
                            <ul class="student-list list-group mt-2" style="display:none;"></ul> <!-- Student list -->
                        </li>
                        @endforeach
                    </ul>

                </div>

                <!-- Chat Box -->
                <div class=" mt-4 col-md-9 chat-box p-3 position-relative">
                    <button onclick="window.history.back()" class="btn btn-secondary mb-3">Back</button>
                    @if(isset($receiver))
                    <h4 class="text-primary fw-bold">{{ $receiver->name }}</h4>
                    <h4 class="text-primary small">{{ $receiver->email }}</h4>
                    <div class="messages mb-3" id="messages">
                        @foreach($messages as $message)
                        <div class="message mb-3">
                            @if($message->sender_id == auth()->id())
                            <div class="sent-message shadow-sm">
                                <p class="mb-1">{{ $message->message }}</p>
                                @if($message->file)
                                <a href="{{ asset('storage/' . $message->file) }}" download>Download attachment</a>
                                @endif
                                <small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
                            </div>
                            @else
                            <div class="received-message shadow-sm">
                                <p class="mb-1">{{ $message->message }}</p>
                                @if($message->file)
                                <a href="{{ asset('storage/' . $message->file) }}" download>Download attachment</a>
                                @endif
                                <small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <form action="{{ url('chat/send') }}" method="POST" enctype="multipart/form-data" class="input-group">
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
</div>
@endsection

@section('style')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }


    .class-list {
        height: 100vh;
        overflow-y: auto;
        padding-top: 15px;
        background-color: #f8f9fa;
        box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
    }

    .class-item {
        cursor: pointer;
        transition: background-color 0.3s;
        position: relative;
    }

    .class-item:hover {
        background-color: #e9ecef;
    }

    .student-list {
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 5px;
        z-index: 1000;
        display: none;
        /* Initially hidden */
    }

    .student-list li {
        padding: 5px 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    .student-list li img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .student-list li:hover {
        background-color: #f1f1f1;
    }

    .chat-box {
        border-radius: 10px;
        background-color: #ffffff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-height: 85vh;
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
        margin-left: 90%;
        text-align: left;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    }

    .received-message {
        background-color: #fce4ec;
        padding: 10px;
        border-radius: 10px;
        max-width: 75%;
        display: inline-block;
        margin-right: auto;
        text-align: left;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const classItems = document.querySelectorAll('.class-item');

        classItems.forEach(item => {
            let isStudentListVisible = false;

            item.addEventListener('click', function() {
                const classId = this.getAttribute('data-class-id');
                const studentList = this.querySelector('.student-list');

                if (isStudentListVisible) {
                    studentList.style.display = 'none';
                    isStudentListVisible = false;
                } else {
                    studentList.innerHTML = '';

                    fetch(`/chat/get-students/${classId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.students.length === 0) {
                                studentList.innerHTML = '<li class="list-group-item text-muted">No students available</li>';
                            } else {
                                const uniqueStudents = new Set();
                                data.students.forEach(student => {
                                    if (!uniqueStudents.has(student.id)) {
                                        uniqueStudents.add(student.id);

                                        const li = document.createElement('li');
                                        li.classList.add('list-group-item');

                                        const img = document.createElement('img');
                                        img.src = `/upload/images/${student.profile_pic}`;
                                        img.alt = `${student.name}'s profile picture`;

                                        li.appendChild(img);
                                        li.append(` ${student.name}`);

                                        li.addEventListener('click', function(event) {
                                            event.stopPropagation();
                                            window.location.href = `/chat/${student.id}`;
                                        });

                                        studentList.appendChild(li);
                                    }
                                });
                            }
                        })
                        .catch(error => console.error('Error fetching students:', error));

                    studentList.style.display = 'block';
                    isStudentListVisible = true;
                }
            });

            const studentList = item.querySelector('.student-list');
            studentList.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        });
    });
</script>
@endsection