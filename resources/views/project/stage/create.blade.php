<div class="card mt-4">
    <form action="/project/stages/create" method="POST">

        {{ csrf_field() }}

        <div class="card-header">
            New stage
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="name" class="field-required">Stage name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Stage name" required="required" value="{{ old('name') }}">
                </div>
                <div class="form-group offset-md-1 col-md-5">
                    <label for="sent_amount">Stage cost</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select name="currency_cost" id="currency_cost" class="btn btn-secondary" required="required">
                            @foreach (config('constants.currency') as $currency => $currencyMeta)
                                @php
                                    $selected = $currency === old('currency_cost') ? 'selected="selected"' : '';
                                @endphp
                                <option value="{{ $currency }}" {{ $selected }}>{{ $currency }}</option>
                            @endforeach
                            </select>
                        </div>
                        <input type="number" class="form-control" name="cost" id="cost" placeholder="Stage cost" step=".01" min="0" value="{{ old('cost') }}">
                    </div>
                </div>
            </div>
            <br>
            <div class="form-row">
                <div class="form-group col-md-3 d-flex align-items-center">
                    <input type="checkbox" name="cost_include_gst" id="cost_include_gst" {{ old('cost_include_gst') ? 'checked="checked"' : '' }}>
                    <label for="sent_amount" class="mb-0 pl-2">Is GST included in Stage Cost?</label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create stage</button>
        </div>
    </form>
</div>
