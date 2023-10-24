@extends('Base/BaseIndex')

@section('content')

<div id="dashboard-painel" class="container" style="margin-bottom: 50px;">
    <div class="d-block card w-100 shadow d-block">
        <div class="card-header text-light fs-4 bg-white gradient-bg">
            <div class="d-flex justify-content-between">
                <a href="" class="text-primary text-decoration-none">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-clipboard-user text-primary me-3"></i>
                        <h2 id="id_button" data-hotel-id="{{$id}}" class="mb-0"></h2>
                    </div>
                </a>
            </div>
        </div>

        <div id="dashboard-body" class="card-body overflow-auto">
            <div class="d-block d-sm-flex justify-content-start ms-2">

                <button onclick="openModalAdd()" id="addButton" class="ml-3 me-4 btn btn-success text-light fs-6 d-flex justify-content-around align-self-center" data-bs-toggle="modal" data-bs-target="#formAdd">
                    <i class="fa fa-plus-circle me-1 mt-1" aria-hidden="true"></i> <span>Adicionar Quarto</span> </button>

            </div>

            <div id="error-message" class="d-none">
            </div>

            <div id="dashboard-content" class="container mt-4">
                <div class="row">
                    <div class="table-responsive responsive-y">
                        <table id="rooms_table" class="table table-bordered table-striped">
                            <thead class="tr-white">
                                <th class="custom-header" scope="col">ID</th>
                                <th class="custom-header" scope="col">Nome</th>
                                <th class="custom-header" scope="col">Preço</th>
                                <th class="custom-header" scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dashboard-painel" class="container " style="margin-bottom: 50px;">
    <div class="d-block card w-100 shadow d-block">
        <div class="card-header text-light fs-4 bg-white gradient-bg">
            <div class="d-flex justify-content-between">
                <a href="" class="text-primary text-decoration-none">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-clipboard-user text-primary me-3"></i>
                        <h2 id="id_reserve" data-hotel-id="{{$id}}" class="mb-0"></h2>
                    </div>
                </a>
            </div>
        </div>

        <div id="dashboard-body" class="card-body overflow-auto">

            <div id="error-message" class="d-none">
            </div>

            <div id="dashboard-content" class="container mt-4">
                <div class="row">
                    <div class="table-responsive responsive-y">
                        <table id="reserves_table" class="table table-bordered table-striped">
                            <thead class="tr-white">
                                <th class="custom-header" scope="col">ID reserva</th>
                                <th class="custom-header" scope="col">ID Quarto</th>
                                <th class="custom-header" scope="col">Check-In</th>
                                <th class="custom-header" scope="col">Check-Out</th>
                                <th class="custom-header" scope="col">Total</th>
                                <th class="custom-header" scope="col">Nome</th>
                                <th class="custom-header" scope="col">Diaria</th>
                                <th class="custom-header" scope="col">Valor Diária</th>
                                <th class="custom-header" scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- Modal de adicionar dinamicamente com o js -->
<div class="modal fade" id="formAdd" tabindex="-1" aria-labelledby="formAdd" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-white text-white rounded-1 ">
                <h5 class="modal-title text-primary" id="exampleModalLabel"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Adicionar Quarto</h5>
                <button type="button" class="btn-close btn-close-white btn-close-add-form" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="DiningTableAdd">
                    <form id="form-add" action="">

                        <div class="row">
                            <div class="form-group col-12">
                                <select name="hotel_id" id="hotels_select" class="form-control bg-light border-1 border-warning w-75">

                                </select>
                                <div id="input" class="my-3">
                                    <input type="text" id="room_name" class="form-control bg-light border-1 border-warning my-2 w-75" name="room_name" placeholder="Nome do quarto">
                                </div>
                                <div class="mb-4">
                                    <button onclick="add_room()" id="newRoom" class="me-4 btn btn-success text-light fs-6 d-flex justify-content-around align-self-center">
                                        <i class="fa fa-plus-circle me-1 mt-1" aria-hidden="true"></i> <span>Novo Quarto</span> </button>

                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button onclick="resetForm()" type="button" class="btn btn-danger btn-close-add-form" data-bs-dismiss="modal"> <i class="fa fa-close" aria-hidden="true"></i> Fechar</button>
                            <button onclick="registerRoom()" id="btn-add-form" class="btn btn-success"> <i class="fa fa-check" aria-hidden="true"></i>
                                Adicionar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Modal Editar -->
<div class="modal fade" id="formEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-white text-white rounded-1 ">
                <h5 class="modal-title text-primary"> <i class="fa fa-pencil" aria-hidden="true"></i> Editar Quarto</h5>
                <button type="button" class="btn-close btn-close-white btn-close-edit-form" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="DiningTableAdd">
                    <form id="form-edit">
                        <div class="row">
                            <div class="form-group col-12">
                                <div id="input" class="my-3">
                                    <input type="text" id="roomNameEdit" class="form-control bg-light border-1 border-warning my-2 w-75" name="room_name" placeholder="Nome do quarto">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button onclick="resetForm()" type="button" class="btn btn-danger btn-close-add-form" data-bs-dismiss="modal"> <i class="fa fa-close" aria-hidden="true"></i> Fechar</button>
                            <button onclick="editRoom()" id="btn-edit-form" class="btn btn-success"> <i class="fa fa-check" aria-hidden="true"></i>
                                Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        hotels_id();
        viewHotel();
        viewReserves();
    });

    function viewHotel() {
        const h2Element = document.getElementById('id_button');
        const id = h2Element.getAttribute('data-hotel-id');

        const table = document.getElementById('rooms_table').getElementsByTagName('tbody')[0];
        fetch(`/api/hotels/${id}`)
            .then(response => response.json())
            .then(data => {
                data.rooms.forEach(rooms => {

                    h2Element.innerText = `${rooms.hotelsName}`;

                    const newRow = table.insertRow();

                    const idCell = newRow.insertCell();
                    const roomNameCell = newRow.insertCell();
                    const roomPriceCell = newRow.insertCell();
                    const actionsCell = newRow.insertCell();

                    idCell.textContent = rooms.id;
                    idCell.id = 'idRoom';
                    roomNameCell.textContent = rooms.roomName;
                    roomNameCell.id = 'roomEdit';
                    roomPriceCell.textContent = rooms.price;

                    var editButton = document.createElement('button');
                    editButton.classList.add('me-4', 'btn', 'btn-success', 'text-light', 'fs-6', 'd-flex', 'justify-content-around', 'align-self-center');
                    editButton.innerHTML = '<i class="bi bi-person-dash-fill" aria-hidden="true"></i> editar';
                    editButton.setAttribute('data-rooms-id', rooms.id);
                    editButton.setAttribute('data-bs-toggle', "modal");
                    editButton.setAttribute('data-bs-target', "#formEdit");

                    editButton.addEventListener('click', function() {
                        const roomId = rooms.id
                        // Redireciona para a página com o ID do hotel como parâmetro
                        openModalEdit(roomId);

                    });

                    // Adiciona o botão de detalhes à célula de ações
                    actionsCell.classList.add('d-flex');
                    actionsCell.appendChild(editButton);

                    var deleteButton = document.createElement('button');
                    deleteButton.classList.add('me-4', 'btn', 'btn-danger', 'text-light', 'fs-6', 'd-flex', 'justify-content-around', 'align-self-center');
                    deleteButton.innerHTML = '<i class="bi bi-person-dash-fill" aria-hidden="true"></i> deletar';
                    deleteButton.setAttribute('data-rooms-id', rooms.id);

                    deleteButton.addEventListener('click', function() {
                        // Obtém o ID do quarto do atributo de dados do botão
                        const roomId = rooms.id;
                        destroyRoom(roomId);
                        // Redireciona para a páginacom o ID do hotel como parâmetro
                        //window.location.href = `/detailsRoom/${hotelId}`;
                    });

                    // Adiciona o botão de detalhes à célula de ações
                    actionsCell.appendChild(deleteButton);
                })
            });
    }

    function viewReserves() {
        const h2Element = document.getElementById('id_reserve');
        const id = h2Element.getAttribute('data-hotel-id');
        const table = document.getElementById('reserves_table').getElementsByTagName('tbody')[0];
        fetch(`/api/hotels/${id}`)
            .then(response => response.json())
            .then(data => {
                data.reserves.forEach(reserves => {
                    console.log(reserves);
                    h2Element.innerText = 'Reservas';
                    const newRow = table.insertRow();

                    const idCell = newRow.insertCell();
                    const roomNameCell = newRow.insertCell();
                    const checkInCell = newRow.insertCell();
                    const checkOutCell = newRow.insertCell();
                    const totalCell = newRow.insertCell();
                    const NameCell = newRow.insertCell();
                    const dailyCell = newRow.insertCell();
                    const payCell = newRow.insertCell();
                    const actionsCell = newRow.insertCell();

                    idCell.textContent = reserves.id;
                    idCell.id = 'idReserve';
                    roomNameCell.textContent = reserves.roomCode;
                    checkInCell.textContent = reserves.checkIn;
                    checkOutCell.textContent = reserves.checkOut;
                    totalCell.textContent = reserves.total;
                    NameCell.textContent = reserves.name;
                    dailyCell.textContent = reserves.date;
                    payCell.textContent = reserves.value;

                    var deleteButton = document.createElement('button');
                    deleteButton.classList.add('me-4', 'btn', 'btn-danger', 'text-light', 'fs-6', 'd-flex', 'justify-content-around', 'align-self-center');
                    deleteButton.innerHTML = '<i class="bi bi-person-dash-fill" aria-hidden="true"></i> deletar';
                    deleteButton.setAttribute('data-reserve-id', reserves.id);

                    deleteButton.addEventListener('click', function() {
                        // Obtém o ID do quarto do atributo de dados do botão
                        const reserveId = reserves.id;
                        destroyReserves(reserveId);
                        // Redireciona para a páginacom o ID do hotel como parâmetro
                        //window.location.href = `/detailsRoom/${hotelId}`;
                    });

                    // Adiciona o botão de detalhes à célula de ações
                    actionsCell.appendChild(deleteButton);
                });
                
            })
    }

    function openModalAdd() {
        const modal = document.getElementById('formAdd');
        const modalInstance = new Bootstrap.Modal(modal);
        modalInstance.show();
    }

    function openModalEdit(roomId) {
        const modal = document.getElementById('formEdit');
        const id = document.getElementById('btn-edit-form');
        id.setAttribute('data-room-id', roomId);
        const modalInstance = new Bootstrap.Modal(modal);
        modalInstance.show();
    }


    function hotels_id() {
        fetch('/api/hotels')
            .then(response => response.json())
            .then(data => {
                    const option_hotels = document.querySelector('#hotels_select');
                    data.hotels.forEach(hotels => {
                        const opt = document.createElement('option');
                        opt.value = hotels.id;
                        opt.id = 'option_id';
                        opt.textContent = hotels.hotelsName;
                        option_hotels.appendChild(opt);

                    });

                }

            )
            .catch(error => {
                console.log(error);
            })

    }

    function add_room() {
        event.preventDefault();
        const div = document.getElementById('input');
        div.innerHTML += `<div  class="addRoom d-flex">
            <input type="text" id="room_name" class="form-control bg-light border-1 border-warning my-2 d-flex w-75" name="room_name" placeholder="Nome do quarto"> <button onclick="removeRoom()" class="m-2 btn btn-danger">X</button></div>`
    }

    function removeRoom() {
        const divRemove = document.querySelector('.addRoom');
        divRemove.remove();
    }

    function resetForm() {
        const form = document.getElementById('form-add');
        form.reset();
    };

    function registerRoom() {
        event.preventDefault();
        const room_name = document.querySelectorAll('#room_name');
        const room = Array.from(room_name).map(input => input.value);
        const hotels_id = document.getElementById('hotels_select').value;
        fetch('/api/hotels', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    roomName: room,
                    hotelCode: hotels_id,

                })

            })

            .then(response => {
                console.log('resposta:', response);
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Erro ao cadastrar');
            })
            .then(data => {
                console.log('message:', data.message, 'request', data.request);
                alert('Cadastrado com sucesso!!');
                location.reload();

            })
            .catch(error => {
                console.error(error);
            });
    }

    function editRoom() {
        event.preventDefault();
        const element = document.getElementById('btn-edit-form');
        const id = element.getAttribute('data-room-id');
        console.log(id);
        const room_name = document.querySelectorAll('#roomNameEdit')[0].value;
        fetch(`/api/hotels/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    roomName: room_name,
                })
            })
            .then(response => {
                console.log('resposta:', response);
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Erro ao cadastrar');
            })
            .then(data => {
                console.log('room', data.room.hotelCode);
                alert('Editado com sucesso!!');
                window.location.href = `/detailsRoom/${data.room.hotelCode}`;
            })
            .catch(error => {
                console.error(error);
            });
    }

    function destroyRoom(roomId) {

        fetch(`/api/hotels/${roomId}?type=room`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                console.log('resposta:', response);
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Erro ao deletar');
            })
            .then(data => {
                console.log('message', data.message);
                alert('Deletado com sucesso!!');
                location.reload();
            })

            .catch(error => {
                console.error(error);
            });


    }

    function destroyReserves(reserveId) {
        console.log(reserveId);
        fetch(`/api/hotels/${reserveId}?type=reserves`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                console.log('resposta:', response);
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Erro ao deletar');
            })
            .then(data => {
                alert('Deletado com sucesso');
                location.reload();
            })
            .catch(error => {
                console.error(error);
            });
    }
</script>

@endsection