@extends('layouts.app')

@section('content')

<div id="allWindow">

    <div class="row justify-content-center">

        <div class="col-md-12">

            <div class="card border-primary shadow">

                <div class="card-header text-center text-white bg-primary mb-3">

                    @include('siscom.menu')

                </div>

                    <div class="card-body">

                        @if (session('status'))
    
                            <div class="alert alert-success" role="alert">

                                {{ session('status') }}
                            
                            </div>

                        @endif

                        <a href="{{ route('factura.index') }}" class="btn btn-link text-decoration-none float-right"> <i class="far fa-arrow-alt-circle-left"></i> Volver</a>

                        <h4> Factura No.  <input type="text" value="{{ $factura->factura_id }}" readonly class="h4" style="border:0;" name="factura_id" form="1"> </h4>

                         <hr style="background-color: #d7d7d7">

                        <div class="py-3">

                            <div class="form-row mb-3">

                                <div class="col-md-4 mb-3">

                                    <label class="text-muted">Tipo Documento</label>
                                                                
                                    <h5>{{ $factura->tipoDocumento }}</h5>
                                                            
                                </div>

                                <div class="col-md-3 mb-3">
                                                          
                                    <label class="text-muted">Fecha Oficina de Parte</label> <br>

                                    <h5>{{ date('d-m-Y H:i:s', strtotime($factura->created_at)) }}</h5>

                                </div>

                                <div class="col-md-3 mb-3">
                                
                                    <label class="text-muted">Fecha Recepci??n C&S</label>
                                                                
                                    <h5>{{ date('d-m-Y H:i:s', strtotime($factura->created_at)) }}</h5> 

                                </div>

                            </div>

                            <div class="form-row mb-3">

                                <div class="col-md-6 mb-3">
                                
                                    <label class="text-muted">Unidad Solicitante</label>
                                                                
                                    <h5>{{ $factura->Dependencia }}</h5> 

                                </div>

                                <div class="col-md-3 mb-3" style="display: none;">
                                
                                    <label class="text-muted">No. ??rden de Compra</label>
                                                                
                                    <input type="hidden" value="{{ $factura->ordenCompra_id }}" readonly class="h5" style="border:0;" name="ordenCompra_id" form="facturarProductoForm"> 

                                </div>

                                <div class="col-md-3 mb-3">
                                                          
                                    <label class="text-muted">Proveedor</label> <br>

                                    <h5>{{ $factura->RazonSocial }}</h5> 

                                </div>

                                <div class="col-md-3 mb-3">

                                    <label class="text-muted">Factura Gestionada por</label>
                                                                
                                    <h5>{{ $factura->userName }}</h5>
                                                            
                                </div>

                            </div>

                             <hr style="background-color: #d7d7d7">

                            <div style="font-size: 0.8em;" class="bg-warning rounded-top rounded-bottom shadow p-3" class="col">

                                <h5 class="text-center">

                                    <i class="fas fa-hourglass-half px-2"></i>

                                    TimeLine Factura

                                </h5>
                                        
                                <table class="table table-striped table-sm table-hover" width="100%">
                                                
                                    <thead>
                                            
                                        <tr>
                                                
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Responsable</th>
                                            <th>Obs. Rechazo</th>
                                                    
                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach($move as $m)
                                                
                                        <tr>

                                            <td>{{ date('d-m-Y H:i:s', strtotime($m->date)) }}</td>
                                            <td>{{ $m->status }}</td>
                                            <td>{{ $m->name }}</td>
                                            <td>{{ $m->obsRechazoValidacion }}</td>

                                        </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                            <hr style="background-color: #d7d7d7">

                            <div class="mb-5 float-right">

                                @if($fullFactura == 0)

                                    {{--@can('ordenCompra.confirmarRecepcionProductos')--}}
                                    
                                    <form method="POST" action="{{ route('factura.facturarTodos', $factura->ordenCompra_id) }}" id="facturarTodosProductoForm">

                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="flag" value="FacturarTodosProductos">
                                        <input type="hidden" value="{{ $factura->id }}" readonly name="factura_id">

                                        <button type="submit" class="btn btn-primary"> 
                                            
                                            <i class="fas fa-check-double"></i> 

                                            Facturar Todos de los Productos de la O.C.

                                        </button>

                                    {{--@endcan--}}

                                @else

                                <button type="submit" class="btn btn-primary" disabled> 
                                            
                                    <i class="fas fa-check-double"></i> 

                                    Facturar Todos de los Productos de la O.C.

                                </button>

                                @endif
                                       
                            </div> 

                            <div class="mb-5">
                            
                                <table class="display" id="detalleFactura" style="font-size: 0.9em">
                                    
                                    <thead>
                                        
                                        <tr>
                                            
                                            <th style="display: none;">ID</th>
                                            <th>No.Solicitud</th>
                                            <th>Producto</th>
                                            <th>Especificaci??n</th>
                                            <th>Cantidad</th>
                                            <th>ID ??rden de Compra</th>
                                            <th>Estado O.C.</th>
                                            <th>Recepcionado?</th>
                                            <th>Licitaci??n</th>
                                            <th>Estado Licitaci??n</th>
                                            <th>Acciones</th>

                                        </tr>

                                    </thead>

                                    <tbody>
                                        
                                        @foreach($detalleSolicituds as $dS)

                                        <tr>
                                            
                                            <td style="display: none;">{{ $dS->id }}</td>
                                            <td>{{ $dS->solicitud_id }}</td>
                                            <td>{{ $dS->Producto }}</td>
                                            <td>{{ $dS->especificacion }}</td>
                                            <td>{{ $dS->cantidad }}</td>
                                            <td>{{ $dS->NoOC }}</td>
                                            <td>{{ $dS->EstadoOC }}</td>

                                            @if($dS->fechaRecepcion == NULL)
                                                 <td>No</td>
                                            @else
                                                 <td>Si</td>
                                            @endif

                                            <td>{{ $dS->NoLicitacion}}</td>
                                            <td>{{ $dS->EstadoLicitacion }}</td>

                                            <td>
                                                
                                                <div class="btn-group" role="group" aria-label="Basic example">

                                                    @if($dS->factura_id == NULL)

                                                    <form method="POST" action="{{ route('factura.update', $dS->id) }}" >

                                                        @csrf
                                                        @method('PUT')

                                                        <input type="hidden" name="flag" value="FacturarProducto">
                                                        <input type="hidden" name="factura_id" value="{{ $factura->id }}">


                                                            <button class="btn btn-primary btn-sm mr-1" type="submit">
                                                            
                                                                <i class="fas fa-check"></i>    

                                                            </button>

                                                    </form>

                                                    @else

                                                        <a href="#" class="btn btn-danger btn-sm mr-1 noFacturar" data-toggle="tooltip" data-placement="bottom" title="Eliminar Producto">
                                                                    
                                                            <i class="far fa-trash-alt"></i>

                                                        </a>                                                    

                                                    @endif

                                                </div>

                                            </td>

                                        </tr>

                                        @endforeach

                                    </tbody>

                                </table>     

                            </div>

                            <div class="form-row">

                                <div class="col-md-12 mb-2">

                                    <a href="{{ route('factura.index') }}" class="text-decoration-none">

                                        <button type="submit" class="btn btn-secondary btn-block"> 

                                            <i class="fas fa-arrow-left"></i>
                                                        
                                            Aceptar

                                        </button>

                                    </a>

                                </div>

                            </div>
                           
                        </div>

                    </div>
                
                </div>
            </div>

        </div>

    </div>
        
</div>

<!-- Facturar Producto Modal -->
<div class="modal fade" id="facturarProductoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            <div class="modal-header bg-primary text-white">

                <p class="modal-title" id="exampleModalLabel" style="font-size: 1.2em"><i class="fas fa-tasks"></i> Facturar Producto Recepcionado </p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>


            <form method="POST" action="{{ url('/siscom/factura/facturarProducto/') }}" class="was-validated" id="facturarProductoForm">

                @csrf
                @method('PUT')

                <input type="hidden" name="flag" value="FacturarProducto">

                <div class="modal-body">
        
                    <div class="col-md-12 mb-3">
                                                
                        <label for="Producto">Producto</label>

                        <input type="text" id="Producto" class="form-control" disabled>
                        
                    </div>

                    <div class="mb-3 form-row">

                        <input type="submit" id="facturarProductos" value="Facturar Producto" class="btn btn-success btn-block">              

                    </div>
                            
                </div>

            </form>
        </div>

    </div>

</div>
<!-- Facturar Producto Modal -->

<!-- Eliminar Producto Facturado Modal -->
<div class="modal fade" id="nofacturarProductoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            <div class="modal-header bg-primary text-white">

                <p class="modal-title" id="exampleModalLabel" style="font-size: 1.2em"><i class="fas fa-tasks"></i> Eliminar Producto Facturado </p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>


            <form method="POST" action="#" class="was-validated" id="nofacturarProductoForm">

                @csrf
                @method('PUT')

                <input type="hidden" name="flag" value="NoFacturarProducto">

                <div class="modal-body">
        
                    <div class="col-md-12 mb-3">
                                                
                        <label class="text-muted">Esta usted seguro de No querer Facturar este Producto? : </label><input type="text" name="Producto" id="productDelete" readonly style="border:0;">
                        
                    </div>

                    <div class="mb-3 form-row">

                        <input type="submit" id="facturarProductos" value="Facturar Producto" class="btn btn-success btn-block">              

                    </div>
                            
                </div>

            </form>
        </div>

    </div>

</div>
<!-- Facturar Producto Modal -->




@endsection

@push('scripts')

<script>
    
    $(document).ready(function () {
        var height = $(window).height();
            $('#allWindow').height(height);

            // Start Configuration DataTable Detalle Solicitud
            var table1 = $('#detalleFactura').DataTable({
                "paginate"  : true,

                "ordering": false,

                "order"     : ([0, 'desc']),

                "language"  : {
                            "sProcessing":     "Procesando...",
                            "sLengthMenu":     "Mostrar _MENU_ registros",
                            "sZeroRecords":    "No se encontraron resultados",
                            "sEmptyTable":     "No existen Productos a Facturar, a??n...",
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
                                "sLast":     "??ltimo",
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

            //Start Edit Record Detalle Solicitud
            table1.on('click', '.facturar', function () {

                $tr = $(this).closest('tr');

                if ($($tr).hasClass('child')) {

                    $tr = $tr.prev('.parent');

                }

                var dataDetalle = table1.row($tr).data();

                console.log(dataDetalle);

                $('#Producto').val(dataDetalle[2]);

                $('#facturarProductoForm').attr('action', '/siscom/factura/facturarProducto/' + dataDetalle[0]);
                $('#facturarProductoModal').modal('show');

            });
            //End Edit Record Detalle Solicitud

            //Start Delete Record Detalle Solicitud 
            table1.on('click', '.noFacturar', function () {

                $tr = $(this).closest('tr');

                if ($($tr).hasClass('child')) {

                    $tr = $tr.prev('.parent');

                }

                var dataDetalle = table1.row($tr).data();

                console.log(dataDetalle);

                $('#productDelete').val(dataDetalle[2]);
                
                $('#nofacturarProductoForm').attr('action', '/siscom/factura/' + dataDetalle[0]);
                $('#nofacturarProductoModal').modal('show');

            });
            //End Delete Record Detalle Solicitud
        
    });


</script>

@endpush