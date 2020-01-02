@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-12">

            <div class="card border-secondary shadow">

                <div class="card-header text-center text-white bg-secondary">

                    <h3 class="font-weight-lighter">
                    
                        Administración - 

                        <small>Usuarios de la Intranet Municipal</small>

                    </h3>

                </div>

                <div class="card-body">

                    @if (session('info'))

                    <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
                          
                        <strong> {{ session('info') }} </strong>
                        
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        
                            <span aria-hidden="true">&times;</span>
                          
                        </button>

                    </div>
                   
                    @endif


                        <table class="display" style="font-size: 0.9em;" width="100%" id="usersTable">

                        <thead>

                            <tr>

                                <th width="5%">ID</th>

                                <th>Nombre</th>

                                <th>Correo</th>

                                <th>Dependencia</th>

                                <th colspan="3">&nbsp;</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($users as $user)

                            <tr>

                                <td>{{ $user->id }}</td>

                                <td>{{ $user->name }}</td>

                                <td>{{ $user->email }}</td>

                                <!-- <td>{{ date('d-m-Y H:i:s', strtotime($user->created_at)) }}</td>

                                <td>{{ date('d-m-Y H:i:s', strtotime($user->updated_at)) }}</td> -->

                                <td>{{ $user->dependencia }}</td>

                                @can('users.show')

                                <td>

                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" title="Ver Detalle de este Permiso" style="font-size: 90%;">

                                        <i class="fas fa-eye"></i>

                                        Ver

                                    </a>

                                </td>

                                @endcan

                                @can('users.edit')

                                <td>
                                        
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="bottom" title="Editar este Permiso del Sistema" style="font-size: 90%;">

                                            <i class="fas fa-edit"></i>

                                            Editar

                                        </a>

                                </td>

                                @endcan

                                @can('users.destroy')

                                <td>

                                   {!! Form::open(['route'=> ['users.destroy', $user->id], 'method' => 'DELETE']) !!}

                                        <button class="btn btn-outline-danger" style="font-size: 90%;">

                                            <i class="fas fa-trash"></i>

                                            Eliminar

                                        </button>

                                   {!! Form::close() !!}

                                </td>

                                @endcan

                            </tr>

                            @endforeach

                        </tbody>

                    </table>
                        
                    {{ $users->render() }}

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

    <!-- JQuery DataTable -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js" ></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>

<!-- JQuery DatePicker -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">
        
        $(document).ready(function () {

        // Start Configuration DataTable
            var table = $('#usersTable').DataTable({

                "paginate"  : true,

                "order"     : ([0, 'desc']),

                "language"  : {
                            "sProcessing":     "Procesando...",
                            "sLengthMenu":     "Mostrar _MENU_ registros",
                            "sZeroRecords":    "No se encontraron resultados",
                            "sEmptyTable":     "No existen solicitudes generadas por su unidad, aún...",
                            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix":    "",
                            "sSearch":         "Buscar:",
                            "sUrl":            "",
                            "sInfoThousands":  ",",
                            "sLoadingRecords": "Cargando...",
                            "oPaginate": {
                                "sFirst":    "Primero",
                                "sLast":     "Último",
                                "sNext":     ">>",
                                "sPrevious": "<<"
                            },
                            "oAria": {
                                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            },
                            "buttons": {
                                "copy": "Copiar",
                                "colvis": "Visibilidad"
                            }
                        }

            });
            //End Configuration DataTable

    });    

</script>

@endpush
