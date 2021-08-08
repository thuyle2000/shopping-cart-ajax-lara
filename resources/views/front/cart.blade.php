@extends('front.layout')

@section('content')

<table id="cart" class="table table-hover table-condensed">
    <thead>
        <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price ($)</th>
            <th style="width:8%">Quantity</th>
            <th style="width:22%" class="text-center">Subtotal ($)</th>
            <th style="width:10%"></th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0 @endphp
        @if(session('cart'))
            @foreach(session('cart') as $id => $details)
                @php $total += $details['price'] * $details['quantity'] @endphp
                <tr data-id="{{ $id }}">
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-3 hidden-xs"><img src="{{ $details['image'] }}" width="100" height="100"
                                    class="img-responsive" /></div>
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $details['name'] }}</h4>
                            </div>
                        </div>
                    </td>

                    {{-- don gia 1 san pham (price) --}}
                    <td data-th="Price">
                        <input value="{{ $details['price']  }}" class="form-control  price" readonly />
                    </td>

                    {{-- so luong 1 san pham (quantity) --}}
                    <td data-th="Quantity">
                        <input type="number" min="1" max="10" value="{{ $details['quantity'] }}"
                            class="form-control quantity update-cart" />
                    </td>

                    {{-- thanh tien 1 san pham (subtotal) --}}
                    <td data-th="Subtotal" class="text-center ">
                        <input value="{{$details['price'] * $details['quantity'] }}" class="form-control subtotal" readonly />
                        {{-- ${{ $details['price'] * $details['quantity'] }} --}}
                    </td>

                    {{-- remove item button --}}
                    <td class="actions" data-th="">
                        <button class="btn btn-danger btn-sm remove-from-cart">
                            <i class="fa fa-trash-o"></i></button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right">
                {{-- tong tien hoa don (total-amount) --}}
                <h3>Total
                    <strong class="total-amount"> ${{ $total }}</strong>
                </h3>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">
                <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>
                <button class="btn btn-success">Checkout</button>
            </td>
        </tr>
    </tfoot>
</table>
@endsection

@section('scripts')
<script type="text/javascript">
    $(".update-cart").change(function (e) {
        e.preventDefault();

        let ele = $(this);                                          //input quantity element
        let subtotalElement = ele.parents("tr").find(".subtotal");  //input sub total element

        let qty = Number(ele.val());
        let price = Number(ele.parents("tr").find(".price").val());

        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}',
                id: ele.parents("tr").attr("data-id"),
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function (response) {
                //window.location.reload();

                rendePopupCart(response);
                subtotalElement.val(qty * price);
                $(".alert").text('Cart updated successfully');
                $(".alert").show();

            }
        });
    });


    $(".remove-from-cart").click(function (e) {
        e.preventDefault();

        let ele = $(this);

        if(confirm("Are you sure want to remove?")) {
            $.ajax({
                url: '{{ route('remove.from.cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    // window.location.reload();

                    ele.parents("tr").remove();
                    rendePopupCart(response);
                    $(".alert").text('Product removed successfully');
                    $(".alert").show();

                 }
            });
        }

    });



</script>
@endsection
