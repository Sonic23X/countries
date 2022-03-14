<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body class="bg-light">
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <form id="login" action="#">
                                    <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                    <div class="form-outline form-white mb-4">
                                        <input type="text" id="code" class="form-control form-control-lg" />
                                        <label class="form-label" for="code">Country code</label>
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <input type="text" id="token" class="form-control form-control-lg" />
                                        <label class="form-label" for="token">Token (Empty for first time)</label>
                                    </div>
                                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Access</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const form = document.getElementById('login');

        form.addEventListener('submit', (event) => {
            event.preventDefault();

            let data;
            if (document.getElementById('token').value != '') {
                data = {
                    code: document.getElementById('code').value,
                    token: document.getElementById('token').value,
                };
            }
            else {
                data = {
                    code: document.getElementById('code').value,
                };
            }

            fetch('{{ url("api/access") }}', {
                headers:{
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                method:'POST',
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then((result) => {
                if (result.access == true)
                    window.location.href = `{{ url('dash') }}`;
                else
                    Swal.fire(
                        'Error',
                        result.message,
                        'error'
                    )
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
