<div class="form-group">
    <div x-cloak x-data="{ show: false }" class="input-group mb-3">
        <span class="input-group-prepend">
            <button type="button" class="btn btn-default" disabled><i class="fas fa-lock"></i></button>
        </span>
        <input :type="show ? 'text' : 'password'" {{ $attributes }} class='form-control' />
        <span class="input-group-append">
            <button @click="show = !show" type="button" class="btn btn-default">
                <i :class="{ 'd-none': show }" class="fa fa-eye-slash"></i>
                <i :class="{ 'd-none': !show }" class="fa fa-eye"></i>
            </button>
        </span>
    </div>
</div>
