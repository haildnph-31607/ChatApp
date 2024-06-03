@extends('layouts.app')
@section('css')
    <style>
        .item img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }

        .item {
            display: flex;
            padding: 10px;
            align-items: center;
            background-color: rgb(243, 243, 243);
            border: 1px solid lightgray;
            text-decoration: none;
            position: relative;

        }

        .status {
            position: absolute;
            width: 10px;
            height: 10px;
            right: 10px;
            background-color: greenyellow;
            border-radius: 50%;
        }

        .item:hover {
            opacity: 0.5;
        }

        .blockchat {
            overflow-y: scrol;
            width: 100%;
            height: 450px;
            border: 1px solid lightgray;
            border-radius: 4px;
        }
        .my-Messgae{
            color: blue;
            text-align: right;
        }
        ul{
            list-style: none;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <h1>Messenger</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="row">

                        <div class="col-md-12 sm-none ">
                            <a href="{{ route('profileView',Auth::user()->id) }}" class="item" id="link_{{ Auth::user()->id }}">
                                {{-- <div class="status"></div> --}}
                                <img src="{{ Auth::user()->avatar }}" alt="">
                                <p>{{ Auth::user()->name }}</p>
                            </a>
                        </div>

                </div>
            </div>
            <div class="col-md-9">
                <div class="col-md-12 ">
                    <a href="{{ route('chatSolution',$user->id) }}" class="item" id="link_{{ $user->id }}">
                        {{-- <div class="status"></div> --}}
                        <img src="{{ $user->avatar }}" alt="">
                        <p>{{ $user->name }}</p>
                    </a>
                </div>
                <ul class="blockchat" id="message">

                </ul>
                <form>
                    <div class="d-flex">
                        <input type="text" class="form-control me-2" placeholder="Nhap Tin Nhan ..." id="inputChat">
                        <button class="btn btn-success" type="button" id="btnSend">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type='module'>
        Echo.join('chat')
            .here(users => {
                //    console.log('Join' ,users);
                users.forEach(item => {
                    let onl = document.querySelector(`#link_${item.id}`);
                    let elementStatus = document.createElement('div');
                    // console.log(`link_${item.id}`);
                    elementStatus.classList.add('status');
                    if (onl) {
                        onl.appendChild(elementStatus);
                    }
                })
            })
            .joining(user => {
                // console.log('Joining' ,user);

                let onl = document.querySelector(`#link_${user.id}`);
                let elementStatus = document.createElement('div');
                // console.log(`link_${item.id}`);
                elementStatus.classList.add('status');

                if (onl) {
                    onl.appendChild(elementStatus);
                }
            })


            .leaving(user => {
                // console.log('Leaving' ,user);
                let onl = document.querySelector(`#link_${user.id}`);
                let ElementRemote = onl.querySelector('.status');
                if (ElementRemote) {
                    onl.removeChild(ElementRemote);
                }

            })

        let inputChat = document.querySelector('#inputChat')
        let btnSend = document.querySelector('#btnSend')
        btnSend.addEventListener('click', function(e) {
            e.preventDefault();
            //    console.log(1);
            axios.post('{{ route('Message',$user->id) }}', {
                'message': inputChat.value
            }).then(data => {
                // console.log(data.data);
                inputChat.value = ''
            })

        })

    </script>
    <script type="module">
         Echo.private(`ChatSolution.{{ Auth::user()->id }}.{{ $user->id }}`)
         .listen('ChatSolution', event=>{
           console.log(event);
           let message = document.querySelector('#message')
           let items = document.createElement('li');
           items.textContent = `${ event.userSend.name} : ${event.message}`;
        //    items.classList.add('my-Messgae')
           message.appendChild(items)
         })

         Echo.private('ChatSolution.{{ $user->id }}.{{ Auth::user()->id }}')
         .listen('ChatSolution', event=>{
           console.log(event);
           let message = document.querySelector('#message')
           let items = document.createElement('li');
           items.textContent = `${event.message} : ${ event.userSend.name} `;
           items.classList.add('my-Messgae')
           message.appendChild(items)
         })
    </script>
@endsection

