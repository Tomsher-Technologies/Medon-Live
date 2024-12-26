<div class="form-group row">
    <label class="col-md-3 col-form-label">Link<span class="text-danger" style="font-size: 20px;line-height: 1;">*</span></label>
    <div class="col-md-9">
        <select class="form-control aiz-selectpicker" name="link_ref_id[]" id="link_ref_id" data-live-search="true" multiple
        data-actions-box="true" required>
           
            @foreach ($products as $product)
                <option {{ (in_array($product->id, $oldArray)) ? 'selected' : '' }} value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<script>
    $('#link_ref_id').selectpicker({
        size: 5,
        virtualScroll: false
    });
</script>
