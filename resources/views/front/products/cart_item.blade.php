<?php use App\Models\Product; ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th colspan="2">Description</th>
            <th>Quantity/Update</th>
            <th>MRP</th>
            <th>Discount</th>
            <th>Sub Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $total_price = 0; ?>
        @foreach ($userCartItems as $item)
        <?php $attrPrice = Product::getDiscountAttrPrice($item['product_id'],$item['size']); ?>
            <tr>
                <td> <img width="60" src="{{asset('images/product_images/small/'.$item['product']['main_image'])}}" alt="" /></td>
                <td colspan="2">{{$item['product']['product_name']}}<br />Color : {{$item['product']['product_color']}}<br />Size : {{$item['size']}}</td>
                <td>
                    <div class="input-append">
                        <input class="span1" style="max-width:34px" id="appendedInputButtons" size="16" type="text" value="{{$item['quantity']}}">

                        <button class="btn btnItemUpdate qtyMinus" data-cartid="{{$item['id']}}" type="button">
                            <i class="icon-minus"></i>
                        </button>
                        <button class="btn btnItemUpdate qtyPlus" data-cartid="{{$item['id']}}" type="button">
                            <i class="icon-plus"></i>
                        </button>
                        <button class="btn btn-danger btnItemDelete" type="button" data-cartid="{{$item['id']}}">
                            <i class="icon-remove icon-white"></i>
                        </button>
                    </div>
                </td>
                <td>BDT. {{$attrPrice['product_price']}}</td>
                <td>BDT. {{$attrPrice['discount']}}</td>
                <td>BDT. {{$attrPrice['final_price'] * $item['quantity']}}</td>
            </tr>
            <?php $total_price = $total_price + ($attrPrice['final_price'] * $item['quantity']);?>
        @endforeach

        <tr>
            <td colspan="6" style="text-align:right">Sub Total: </td>
            <td> BDT. {{$total_price}}</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align:right">Voucher Discount: </td>
            <td> BDT. 0.00</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align:right"><strong>GRAND TOTAL (BDT. {{$total_price}} - BDT. 0)
                    =</strong></td>
            <td class="label label-important" style="display:block"> <strong> BDT. {{$total_price}} </strong>
            </td>
        </tr>
    </tbody>
</table>