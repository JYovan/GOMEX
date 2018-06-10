<body class="text-center">
    <form class="form-signin">
        <fieldset>
            <legend><h1>Acceso</h1></legend>
            <div class="col-sm">
                <input type="text" id="Usuario" name="Usuario" class="form-control" required="" autofocus="">
            </div>
            <div class="col-sm">
                <input type="password" id="Contrasena" name="Contrasena" class="form-control" required="" autofocus="">
            </div>
            <div class="col-sm">
                <button id="btnEntrar" class="btn btn-lg btn-primary btn-block" type="button">Entrar</button>
            </div>
        </fieldset>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2020</p>
    </form>
</body>
<script>
    var master_url = base_url + 'index.php/Sesion/';
    var btnEntrar = $("#btnEntrar");
    // IIFE - Immediately Invoked Function Expression
    (function (yc) {
        // The global jQuery object is passed as a parameter
        yc(window.jQuery, window, document);
    }(function ($, window, document) {
        // The $ is now locally scoped
        // Listen for the jQuery ready event on the document
        $(function () {
            btnEntrar.click(function () {
                var Usuario = $("#Usuario").val(), Contrasena = $("#Contrasena").val();
                $.get(master_url + 'onIngreso',{Usuario: Usuario, Contrasena: Contrasena}).done(function (data) {
                    location.reload();
                }).fail(function (x, y, z) {
                    console.log(x, y, z);
                }).always(function () {
                    HoldOn.close();
                }); 
            });
        });
    }));
</script>
<style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: -webkit-box;
        display: flex;
        -ms-flex-align: center;
        -ms-flex-pack: center;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: center;
        justify-content: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
    }

    .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-signin .checkbox {
        font-weight: 400;
    }
    .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="text"],input[type="password"] { 
        margin-top: 10px;
        border: 2px solid #000;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>