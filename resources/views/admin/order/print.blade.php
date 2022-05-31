<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Invoice - {{ config('app.name', ' ') }}</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link rel="icon" href="{{ asset('assets/backend/img/policymaker.ico') }}" type="image/x-icon" />

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                            <h4>
                            <img src="{{ asset('assets/backend/img/Login.png') }}" style= "width:35%; margin-top:6%"  alt=" " >
                                <small class="float-right">Date: {{ date('l, d-M-Y h:i:s A') }}</small>
                            </h4>
                            </br>
                            </br>
                            </br>
                            </br>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col" style="padding-left:10%">
                            From
                            <address>
                                <strong >{{ config('app.name') }}</strong><br>
                                {{ $company->address }}<br>
                                {{ $company->city }} - {{ $company->zip_code }}, {{ $company->country }}<br>
                                Phone: (+880) {{ $company->mobile }} {{ $company->phone !== null ? ', +880'.$company->phone : ''  }}<br>
                                Email: {{ $company->email }}
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col" style="padding-left:10%">
                            To
                            <address>
                                <strong>{{ $order->customer->name }}</strong><br>
                                {{ $order->customer->address }}<br>
                                {{ $order->customer->city }}<br>
                                Phone: (+880) {{ $order->customer->phone }}<br>
                                Email: {{ $order->customer->email }}
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col" style="padding-left:10%">
                            <b>Invoice #IMS-{{ $order->created_at->format('Ymd') }}{{ $order->id }}</br>
                            <b>Order ID:</b> {{ str_pad($order->id,9,"0",STR_PAD_LEFT) }}<br>
                            <b>Payment Status:</b> <span class="badge {{ $order->order_status == 'approved' ? 'badge-success' : 'badge-warning'  }}">{{ $order->order_status }}</span><br>
                            <b>Account:</b> {{ $order->customer->account_number }}
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row" style="padding-left:6%">
                        <div class="col-12 table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                <tr>
</br>
</br>
</br>
</br>
                                    <th>S.N</th>
                                    <th>Product Name</th>
                                    <th>SSN</th>
                                    <th>Quantity</th>
                                    <th>Unit Cost</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order_details as $order_detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order_detail->product->name }}</td>
                                        <td style="width:20%; text-align:center">{{ $order_detail->ssn }}</td>
                                        <td>{{ $order_detail->quantity }}</td>
                                        <td>{{ $unit_cost = $order_detail->unit_cost }}</td>
                                        <td>{{ $unit_cost * $order_detail->quantity }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

</br>
</br>
</br>
</br>

                    <div class="row" style="padding-left:7%">
                        <!-- accepted payments column -->
                        <div class="col-4">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width:50%">Payment Method:</th>
                                        <td class="text-right">{{ $order->payment_status }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pay</th>
                                        <td class="text-right">{{ $order->pay }}</td>
                                    </tr>
                                    <tr>
                                        <th>Due</th>
                                        <td class="text-right">{{ $order->due }}</td>
                                    </tr>
                                </table>
                            </div>

                            @if($order->order_status === 'pending')
                            <img src="{{ asset('assets/backend/img/due.png') }}" style= "width:90%; margin-left:110%; margin-top:-100%; opacity:.5" >
                            @else
                            <img src="{{ asset('assets/backend/img/paid.png') }}" style= "width:90%; margin-left:110%; margin-top:-100%;  opacity:.5" >
                            @endif

                            

                        </div>
                        <!-- /.col -->
                        <div class="col-4 offset-4">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td class="text-right">{{ $order->sub_total }} Taka</td>
                                    </tr>

                                    {{--$_COOKIE
                                    <tr>
                                        <th>Tax (21%)</th>
                                        <td class="text-right">{{ $order->vat }}</td>
                                    </tr>
                                    --}}

                                    
                                    <tr>
                                        <th>Total:</th>
                                        <td class="text-right">{{ round($order->total) }} Taka</td>
                                    </tr>
                                </table>
                            </div>
                            </br></br></br></br>


                            <div>
                            <h4 style= "text-decoration: underline">Receieved By</h4> </br>
                            <h5 style= "text-decoration: underline">Name: </h5></br></br>
                            <h5 style= "text-decoration: underline">Signature:</h5>
                            </div>

                            
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <!-- /.content -->

<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('assets/backend/js/adminlte.js') }}"></script>

<script>
    window.print();
</script>

</body>



</html>




