@if($accessories)
    @foreach($accessories as $accessory)
        <tr>
            <input type="hidden" class="form-control _itemId" value="{{ $itemId }}" style="width:50px;">
            <input type="hidden" class="form-control _productId" value="{{ $accessory->id }}" style="width:50px;">
            <input type="hidden" class="form-control _originalAssetValue" value="{{ $accessory->sale_price }}" style="width:50px;">
            <input type="hidden" class="form-control _Qty" value="1" style="width:50px;">
            <td>{{ $accessory->name }}</td>
            <td>{{ $accessory->pn_no }}</td>
            <td>{{ $accessory->hsn_no }}</td>
            <td><input type="text" class="form-control _AssetValue" value="{{ $accessory->sale_price }}"></td>
            <td><a href="javascript:void(0)" onclick="itemlist.addAccessories(this, '{{route('product.additem')}}','{{$accessory->sku}}')">Add</a></td>
        </tr>
    @endforeach
@else

@endif
