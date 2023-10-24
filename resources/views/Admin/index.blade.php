@extends('Base/BaseIndex')

@section('content')

<div id="dashboard-painel" class="container w-75" style="margin-bottom: 50px;">
    <div class="d-block card w-100 shadow d-block">
        <div class="card-header text-light fs-4 bg-white gradient-bg">
            <div class="d-flex justify-content-between">
                <a href="" class="text-primary text-decoration-none">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-clipboard-user text-primary me-3"></i>
                        <h2 class="mb-0">Hoteis</h2>
                    </div>
                </a>
            </div>
        </div>

        <div id="dashboard-body" class="card-body overflow-auto">
            <div class="d-block d-sm-flex justify-content-start ms-2">

                <button onclick="openModalAdd('formAdd')" id="addButton" class="ml-3 me-4 btn btn-success text-light fs-6 d-flex justify-content-around align-self-center" data-bs-toggle="modal" data-bs-target="#formAdd">
                    <i class="fa fa-plus-circle me-1 mt-1" aria-hidden="true"></i> <span>Adicionar Hotel</span> </button>

                <button onclick="openModalXml('formXml')" id="addButton" class="ml-3 me-4 btn btn-warning text-light fs-6 d-flex justify-content-around align-self-center" data-bs-toggle="modal" data-bs-target="#formXml">
                    <i class="fa fa-plus-circle me-1 mt-1" aria-hidden="true"></i> <span>Adicionar Reserva</span> </button>

            </div>

            <div id="error-message" class="d-none">
            </div>

            <div id="dashboard-content" class="container mt-4">
                <div class="row">
                    <div class="table-responsive responsive-y">
                        <table id="hotels_table" class="table table-bordered table-striped">
                            <thead class="tr-white">
                                <th class="custom-header" scope="col">Hotel ID</th>
                                <th class="custom-header" scope="col">Nome Hotel</th>
                                <th class="custom-header" colspan="2">Ações</th>
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
                <h5 class="modal-title text-primary " id="exampleModalLabel"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Adicionar Hotel</h5>
                <button type="button" class="btn-close btn-close-white btn-close-add-form" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="DiningTableAdd">
                    <form id="form-add" action="" method="post">

                        <div class="row">
                            <div class="form-group col-12">
                                <label for="id_first_name" class="fw-bold form-label mb-0"></label>
                                <input type="text" id="hotel_name" name="hotel_name" class="form-control bg-light border-1 border-warning" placeholder="Nome do Hotel">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-close-add-form" data-bs-dismiss="modal"> <i class="fa fa-close" aria-hidden="true"></i> Fechar</button>
                            <button onclick="registerHotel()" id="btn-add-form" class="btn btn-success"> <i class="fa fa-check" aria-hidden="true"></i>
                                Adicionar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal de adicionar xml dinamicamente com o js -->
<div class="modal fade" id="formXml" tabindex="-1" aria-labelledby="formXml" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-black text-white rounded-1 ">
                <h5 class="modal-title text-warning" id="exampleModalLabel"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Adicionar XML</h5>
                <button type="button" class="btn-close btn-close-white btn-close-add-form" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="DiningTableAdd">
                    <form id="form-xml" action="">

                        <div class="row">
                            <div class="form-group col-12">
                                <label for="id_first_name" class="fw-bold form-label mb-0"></label>
                                <input type="file" name="" id="inputXml" class="form-control bg-light border-1 border-warning">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-close-add-form" data-bs-dismiss="modal"> <i class="fa fa-close" aria-hidden="true"></i> Fechar</button>
                            <button onclick="registerXml()" id="btn-add-form" class="btn btn-success"> <i class="fa fa-check" aria-hidden="true"></i>
                                Adicionar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Todas as funções javascript são utilizadas para enviar request e receber os dados em formato json, nessa
pagina possui funções para listagem de todos os hoteis, bem como cadastro e inserção de arquivo xml para reservas, 
outras funções são para abrir modal de cadastro ou para carregar funções desde que a pagina for aberta. -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        hotels_all();
    });

    //função que abre o modal bootstrap para não necessitar ser redirecionado para uma pagina de cadastro.
    function openModalAdd(formAdd) {
        const modal = document.getElementById('formAdd');
        const modalInstance = new Bootstrap.Modal(modal);
        modalInstance.show();
    }

    //faz a busca no banco de dados atravez da requisição para a api e retorna todos os hoteis cadastrados no sistema.
    function hotels_all() {
        const table = document.getElementById('hotels_table').getElementsByTagName('tbody')[0];
        //função que faz a requisição para a api atravez da rota.
        fetch('/api/hotels')
            .then(response => response.json())
            //função que recebe o retorno do json pela api
            .then(data => {
                //a partir desse objeto retornado é possivel acessa-lo para utilizar e ser visualizado.
                data.hotels.forEach(hotels => {
                    //insere uma nova linha na tabela
                    const newRow = table.insertRow();

                    const idCell = newRow.insertCell();
                    const nameCell = newRow.insertCell();
                    const actionsCell = newRow.insertCell();

                    //seta o valor que terá como value na celula da tabela.
                    idCell.textContent = hotels.id;
                    nameCell.textContent = hotels.hotelsName;

                    var detailsButton = document.createElement('button');
                    detailsButton.classList.add('me-4', 'btn', 'btn-success', 'text-light', 'fs-6', 'd-flex', 'justify-content-around', 'align-self-center');
                    detailsButton.innerHTML = '<i class="bi bi-person-dash-fill" aria-hidden="true"></i> Detalhes Hotel';
                    detailsButton.setAttribute('data-hotel-id', hotels.id);

                    detailsButton.addEventListener('click', function() {
                        // Obtém o ID do hotel do atributo de dados do botão
                        const hotelId = this.getAttribute('data-hotel-id');
                        // Redireciona para a página com o ID do hotel como parâmetro

                        window.location.href = `/detailsRoom/${hotelId}`;
                    });

                    // Adiciona o botão de detalhes à célula de ações
                    actionsCell.appendChild(detailsButton);

                })

            })
    }

    //função para cadastrar hoteis
    function registerHotel() {
        event.preventDefault();
        //recupero na variavel os valores do elemento que o usuario inseiriu no input.
        const hotel_name = document.getElementById('hotel_name').value;

        fetch('/api/hotels', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    hotelsName: hotel_name,
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
                window.location.href = '/'
            })
            .catch(error => {
                console.error(error);
            });
    }

    //função para mandar o arquivo xml para o metodo store
    function registerXml() {
        event.preventDefault();
        const input = document.getElementById('inputXml');
        const arquivo = input.files[0];

        if (arquivo) {
            const formData = new FormData();
            formData.append('arquivo', arquivo);

            fetch(`/api/hotels`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    console.log('resposta:', response);
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Erro ao cadastrar xml');
                })
                .then(data => {
                    console.log('message', data.reserveGuest);
                    alert('Cadastrado com sucesso!!');
                    location.reload();

                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
</script>


@endsection