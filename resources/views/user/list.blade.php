@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Danh Sach Users</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
            <ion-icon name="duplicate-outline"></ion-icon>
        </button>
        <table class="table">
            <thead>
                <th>#</th>
                <th>Avatar</th>
                <th>Name</th>
                <th>Email</th>
                <th>Create At</th>
                <th>Option</th>
            </thead>
            <tbody>
                @foreach ($users as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <img src="{{ $item->avatar }}" alt="" width="100px" style="border-radius: 50%">
                        </td>
                        <td>
                            {{ $item->name }}
                        </td>
                        <td>
                            {{ $item->email }}
                        </td>
                        <td>
                            {{ $item->created_at }}
                        </td>
                        <td>
                            <button type="button" data-id='{{ $item->id }}' class="btn btn-warning"
                                data-bs-toggle="modal" data-bs-target="#modalEdit">
                                <ion-icon name="construct-outline"></ion-icon>
                            </button>
                            <button type="button" data-id='{{ $item->id }}' class="btn btn-danger"
                                data-bs-toggle="modal" data-bs-target="#modalDel">
                                <ion-icon name="trash-outline"></ion-icon>
                            </button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddLabel">Add Users</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" placeholder="Name" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" placeholder="Email" id="email">
                        </div>
                        <div class="mb-3">
                            <label for="image">Image</label>
                            <input type="text" class="form-control" placeholder="Image" id="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="close"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btnAdd">SUBMIT ADD NEW USER </button>
                    </div>
                </div>
            </div>
        </div>
        {{--  --}}
        <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditLabel">Update Users</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="" id="id">
                        <div class="mb-3">
                            <label for="nameUp">Name</label>
                            <input type="text" class="form-control" placeholder="Name" id="nameUp">
                        </div>
                        <div class="mb-3">
                            <label for="emailUp">Email</label>
                            <input type="text" class="form-control" placeholder="Email" id="emailUp">
                        </div>
                        <div class="mb-3">
                            <label for="imageUp">Image</label>
                            <input type="text" class="form-control" placeholder="Image" id="imageUp">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="close"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btnUpdate">SUBMIT UPDATE NEW USER </button>
                    </div>
                </div>
            </div>
        </div>
        {{--     --}}
        <div class="modal fade" id="modalDel" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditLabel">Delete Users</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    Bạn Muốn Xóa User Này Không ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="close"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="btnDel">Agree </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script type="module">
        let btnAdd = document.querySelector('#btnAdd');
        let name = document.querySelector('#name')
        let email = document.querySelector('#email')
        let image = document.querySelector('#image')

        function refesh() {
            name.value = ''
            email.value = ''
            image.value = ''
        }
        btnAdd.addEventListener('click', function() {

            axios.post('{{ route('add') }}', {
                name: name.value,
                email: email.value,
                image: image.value
            }).then((data) => {
                let modalAdd = document.querySelector('#modalAdd')
                let close = modalAdd.querySelector('#close')

                console.log(data);
                refesh();
                close.click();
            }).catch((error) => {
                console.log(error);
            })



        })

        ///khi modal update bat
        let nameUp = document.querySelector('#nameUp')
        let emailUp = document.querySelector('#emailUp')
        let imageUp = document.querySelector('#imageUp')
        let idUpdate = document.querySelector('#id')

        var ModalEdit = document.getElementById('modalEdit')
        ModalEdit.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var id = button.getAttribute('data-id');
            console.log(id);
            axios.post('{{ route('DetailUser') }}', {
                id
            }).then((data) => {
                console.log(data.data.name);
                nameUp.value = data.data.name
                emailUp.value = data.data.email
                imageUp.value = data.data.avatar
                idUpdate.value = id

            })
            // update
            let btnUpdate = document.querySelector("#btnUpdate")
            btnUpdate.addEventListener('click', function() {

                // console.log(idUpdate.value);
                axios.post('{{ route('UpdateUser') }}', {
                    name: nameUp.value,
                    email: emailUp.value,
                    avatar: imageUp.value,
                    id: idUpdate.value
                }).then((data) => {
                    console.log(data);
                    let modalEdit = document.querySelector('#modalEdit')
                    let close = modalEdit.querySelector('#close')
                    close.click();
                })
            })

        })



        // xoa
        var ModalDel = document.getElementById('modalDel')
        ModalDel.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var id = button.getAttribute('data-id');
            // console.log(id);
            let btnDel = document.querySelector('#btnDel');
            btnDel.addEventListener('click',function(){
                  console.log(id);
                axios.post('{{ route("DeleteUser") }}',{
                    id
                }).then((data)=>{
                    console.log(data);
                    let ModalDel = document.querySelector('#modalDel')
                    let close = ModalDel.querySelector('#close')
                    close.click();
                })
            })

            })
            // lang nghe
        Echo.channel('users').listen('UserCreated', event=>{
           console.log(event);
        })

    </script>
@endsection
