<div class="form-group row">
    <label class="col-md-3 col-form-label">Link</label>
    <div class="col-md-9">
        <select class="form-control aiz-selectpicker" name="link_ref_id" id="link_ref_id" data-live-search="true" required>
            @foreach ($brands as $brands)
                <option {{ $old_data == $brands->id ? 'selected' : '' }} value="{{ $brands->id }}">
                    {{ $brands->name }}</option>
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