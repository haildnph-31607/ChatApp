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
                    @foreach ($users as $item)
                        <div class="col-md-12 ">
                            <a href="" class="item" id="link_{{ $item->id }}">
                                {{-- <div class="status"></div> --}}
                                <img src="{{ $item->avatar }}" alt="">
                                <p>{{ $item->name }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-9">
                <ul class="blockchat">

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

            }).listen('UserOnlined' ,event=>{
                // console.log(event);
                let blockChat = document.querySelector('.blockchat');
                let elementChat = document.createElement('li');
                elementChat.textContent= `${event.user.name} : ${event.message}`;
                if(event.user.id== "{{ Auth::user()->id }}"){
                 elementChat.classList.add('my-Messgae');
                elementChat.innerHTML= `${event.message} : ${event.user.name}`;

                }else{
                    elementChat.textContent= `${event.user.name} : ${event.message}`;

                }
                blockChat.appendChild(elementChat);
            })

        let inputChat = document.querySelector('#inputChat')
        let btnSend = document.querySelector('#btnSend')
        btnSend.addEventListener('click', function(e) {
            e.preventDefault();
            //    console.log(1);
            axios.post('{{ route('send') }}', {
                'message': inputChat.value
            }).then(data => {
                console.log(data.data);
            })

        })
    </script>
@endsection
