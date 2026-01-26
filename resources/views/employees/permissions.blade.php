<form method="POST" action="{{ route('employees.permissions.update', $employee) }}">
    @csrf @method('PUT')

    @foreach($allPermissions as $permission)
    <div class="form-check">
        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ $employee->permissions->contains($permission->id) ? 'checked' : '' }}>
        <label>{{ ucfirst(str_replace('-', ' ', $permission->name)) }}</label>
    </div>
    @endforeach

    <button type="submit" class="btn btn-primary">Update Permissions</button>
</form>
