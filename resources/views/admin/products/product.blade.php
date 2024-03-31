 <!-- Combinations -->
<div class="row">
        <div class="col-md-12">
            <table id="widget-product-list productCombinationTable"
                   class="table dt-responsive nowrap" width="100%"
                   cellspacing="0">
                <thead>
                <tr>
{{--                    <th>SKU</th>--}}
                    <th>Product Name</th>
                    <th>P/N</th>
                    <th>Quantity</th>
                    <th>Asset Value</th>
                    <th>{{--Action--}}</th>
                </tr>
                </thead>
                <tbody>
                    <?php $cnt=1;?>
                    @if($product)
                        <tr id="tr<?php echo $cnt;?>">
                            <td>
                                {{ $product->name }}

                            </td>
                            <td>
                                {{ $product->pn_no }}
                                <input type="hidden" class="form-control _productId" value="{{ $product->id }}" style="width:50px;">
                            </td>
                            <td>
                                <input type="hidden" class="form-control _originalAssetValue" value="{{ $product->sale_price }}" style="width:50px;">
                                <input type="text" class="form-control _Qty" value="1" style="width:50px;">
                            </td>
                            <td><input type="text" class="form-control _AssetValue" value="{{ $product->sale_price }}"></td>
                            <td>
                                <button type="button"
                                        class="btn btn-mini btn-primary m-r-15 f-18"
                                        onclick="itemlist.add(this, '{{route('product.additem')}}','{{$product->sku}}')"
                                >
                                    <i class="icofont icofont-plus"></i> Add
                                </button>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="5">Product not found.</td>
                        </tr>
                    @endif
                        <?php $cnt++;?>
                </tbody>
            </table>
        </div>
</div>
{{--@else--}}
{{--    <div class="alert alert-info">--}}
{{--        <strong>Not Found!</strong>--}}
{{--    </div>--}}
{{--@endif--}}
