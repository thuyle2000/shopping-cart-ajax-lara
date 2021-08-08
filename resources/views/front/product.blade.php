@extends('front.layout')

@section('content')



<div class="row">
    @foreach($products as $product)
        <div class="col-xs-18 col-sm-6 col-md-3">
            <div class="thumbnail">
                <img src="{{ $product->image }}" alt="">
                <div class="caption" >

                    <h4>{{ $product->name }}</h4>
                    <p>{{ $product->description }}</p>
                    <p><strong>Price: </strong> {{ $product->price }}$</p>
                    <button class="btn btn-holder btn-warning btn-block text-center add-to-cart" data-id="{{$product->id}}">Add to cart</button>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection


@section('scripts')
<script type="text/javascript">
    $(".add-to-cart").click(function (e) {
        e.preventDefault();

        let ele = $(this);          //a href  element

        $.ajax({
            url: '{{ route('add.to.cart') }}',
            method: "get",
            data: {
                _token: '{{ csrf_token() }}',
                id: ele.attr("data-id"),
            },
            success: function (response) {
                //window.location.reload();
                console.log(response);

                rendePopupCart(response);

                $(".alert").text('Cart updated successfully');
                $(".alert").show();

            }
        });
    });



    // function rendePopupCart(data){
    //     let s= ``;
    //     let totalAmount = 0;
    //     let totalItem = Object.keys(data).length;

    //     $.each(data, function (i, ele) {

    //          s += `<div class="row cart-detail">
    //                     <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
    //                         <img src="${ele.image}" />
    //                     </div>
    //                     <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
    //                         <p>${ele.name}</p>
    //                         <span class="price text-info"> ${ele.price}</span>
    //                         <span class="count"> Quantity:${ele.quantity}</span>
    //                     </div>
    //                 </div>`;

    //                 totalAmount += (ele.price * ele.quantity) ;
    //     });

    //     $(".row-item-detail").html(s);
    //     $(".total-amount").text( `$ ${totalAmount}`);
    //     $(".total-item").text(totalItem);

    // }

</script>
@endsection
