<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>New country</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-10 mt-2">
                Your Token: <b id="token"></b>
            </div>
        </div>
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-10 mt-3">
                <div class="card bg-dark text-white">
                    <div class="card-header">
                        New Country
                    </div>
                    <div class="card-body">
                        <form id="update">
                            <div class="mb-3">
                                <label for="code" class="form-label">Code</label>
                                <input type="text" class="form-control" id="code" value="{{ $country->code }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" value="{{ $country->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="continent" class="form-label">Continent</label>
                                <input type="text" class="form-control" id="continent" value="{{ $country->continent }}">
                            </div>
                            <div class="mb-3">
                                <label for="population" class="form-label">Population</label>
                                <input type="text" class="form-control" id="population" value="{{ $country->population }}">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"
        integrity="sha512-yFjZbTYRCJodnuyGlsKamNE/LlEaEAxSUDe5+u61mV8zzqJVFOH7TnULE2/PP/l5vKWpUNnF4VGVkXh3MjgLsg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const token = document.getElementById('token');
        token.innerHTML = localStorage.getItem('token');

        window.onload=function() {
			if (localStorage.getItem('token') == null) {
                window.location.href = `{{ url('login') }}`;
            }
		}

        const form = document.getElementById('update');

        form.addEventListener('submit', (event) => {
            event.preventDefault();

            let data  = {
                code: document.getElementById('code').value,
                name: document.getElementById('name').value,
                continent: document.getElementById('continent').value,
                population: document.getElementById('population').value,
                token: localStorage.getItem('token'),
            };

            fetch('{{ url("api/update") }}', {
                headers:{
                    'Content-Type': 'application/json'
                },
                method:'PUT',
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then((result) => {
                localStorage.setItem('token', result.token);

                Swal.fire({
                    icon: 'success',
                    text: 'Country updated!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `{{ url('dash') }}`;
                    }
                })

            })
            .catch(function (error) {
                console.log(error);
                Swal.fire(
                    'Error',
                    'Intenta más tarde',
                    'error'
                );
            });
        });
    </script>
</body>
</html>
