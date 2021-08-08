<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Add To Cart Function </title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>


<body>
    <div class="container">

        <div class="row">
            <div class="col-lg-12 col-sm-12 col-12 main-section">

                {{-- class=dropdown: right-align --}}
                <div class="dropdown">

                    <button type="button" class="btn btn-info" data-toggle="dropdown" id="button-cart">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart
                        <span
                            class="badge badge-pill badge-danger total-item">{{ count((array) session('cart')) }}</span>
                    </button>

                    {{-- class="dropdown-menu": toggle effect controlled by button --}}
                    <div class="dropdown-menu">

                        <div class="row total-header-section">

                            <div class="col-lg-6 col-sm-6 col-6">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span
                                    class="badge badge-pill badge-danger total-item">{{ count((array) session('cart')) }}</span>
                            </div>

                            @php $total = 0 @endphp
                            @foreach((array) session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            @endforeach
                            <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                                <p>Total: <span class="text-info total-amount">$ {{ $total }}</span></p>
                            </div>
                        </div>

                        <div class="row-item-detail">
                            @if(session('cart'))

                                @foreach(session('cart') as $id => $details)

                                <div class="row cart-detail">
                                    <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                        <img src="{{ $details['image'] }}" />
                                    </div>
                                    <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                        <p>{{ $details['name'] }}</p>
                                        <span class="price text-info"> ${{ $details['price'] }}</span>
                                        <span class="count"> Quantity:{{ $details['quantity'] }}</span>
                                    </div>
                                </div>

                                @endforeach

                            @endif
                        </div>


                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                <a href="{{ route('cart') }}" class="btn btn-primary btn-block">View all</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <br />
    <div class="container">

        {{-- @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif --}}

        <div class="alert alert-success" style="display: none">
        </div>

        @yield('content')
    </div>

    @yield('scripts')


    <script>

    function rendePopupCart(data){
        let s= ``;
        let totalAmount = 0;
        let totalItem = Object.keys(data).length;

        $.each(data, function (i, ele) {

             s += `<div class="row cart-detail">
                        <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                            <img src="${ele.image}" />
                        </div>
                        <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                            <p>${ele.name}</p>
                            <span class="price text-info"> ${ele.price}</span>
                            <span class="count"> Quantity:${ele.quantity}</span>
                        </div>
                    </div>`;

                    totalAmount += (ele.price * ele.quantity) ;
        });


        $(".row-item-detail").html(s);
        $(".total-amount").text( `$ ${totalAmount}`);
        $(".total-item").text(totalItem);

    }

    </script>
</body>

</html>
