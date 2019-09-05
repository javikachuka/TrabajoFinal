
<section class="content">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h2 class="card-title">Nuevo permiso</h2>
                </div>
                <div class="card-body">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" name="name" required value="{{ old('name') ?? $permiso->name }}"  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Slug</label>
                                    <input type="text" name="slug" required value="{{ old('slug') ?? $permiso->slug }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Descripcion</label>
                                    <input type="text" name="description" required value="{{ old('description') ?? $permiso->description }}"   class="form-control">
                                </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@csrf
