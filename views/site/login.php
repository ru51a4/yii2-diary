<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">login</div>
                <div class="card-body">
                    <form action="/site/register" method="POST">
                        <div class="form-group row d-flex justify-content-center">
                            <img style="width: 300px;"
                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Underground.svg/1024px-Underground.svg.png"
                                width="150px">
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">name(only for
                                register)</label>
                            <div class="col-md-6">
                                <input id="name" class="form-control" name="login"
                                    autocomplete="current-password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">email</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control " name="email" required
                                    autocomplete="email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">password</label>

                            <div class="col-md-6">
                                <input id="password" formControlName="password" type="password" class="form-control"
                                    name="password" required autocomplete="current-password">
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    login - register
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>