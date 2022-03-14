<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>

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
        <div class="row mt-3">
            <div class="col-md-6">
                <a class="btn btn-primary w-100" href="{{ url('new') }}">
                    Nuevo
                </a>
            </div>
            <div class="col-md-6">
                <a class="btn btn-info text-white w-100" href="{{ url('api/csv') }}">
                    Descargar
                </a>
            </div>
        </div>
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-10 mt-3">
                <div class="card bg-dark text-white">
                    <div class="card-header">
                        <span>Countries</span>
                    </div>
                    <div class="card-body">
                        <table class="table text-white text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Code</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Continent</th>
                                    <th scope="col">Population</th>
                                    <th scope="col">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($countries as $country)
                                <tr>
                                    <th scope="row">
                                        {{ $country->code }}
                                    </th>
                                    <td>
                                        {{ $country->name }}
                                    </td>
                                    <td>
                                        {{ $country->continent }}
                                    </td>
                                    <td>
                                        {{ $country->population }}
                                    </td>
                                    <td>
                                        <a href="{{ url('edit/'. $country->code) }}" class="text-decoration-none">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="javascript:destroy('{{ $country->code }}')" class="text-decoration-none text-danger">
                                            <i class="fa-solid fa-xmark"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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

        function destroy(code) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    let data = {
                        token: localStorage.getItem('token'),
                        code: code
                    };

                    fetch('{{ url("api/delete") }}', {
                        headers:{
                            'Content-Type': 'application/json',
                        },
                        method:'DELETE',
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then((result) => {
                        Swal.fire(
                            'Deleted!',
                            'success'
                        ).then((result) => {
                            window.location.href = `{{ url('dash') }}`;
                        });
                    })
                    .catch(function (error) {
                        console.log(error);
                        Swal.fire(
                            'Error',
                            'Intenta más tarde',
                            'error'
                        );
                    });
                }
            });
        }
    </script>
</body>
</html>
