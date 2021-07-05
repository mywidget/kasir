<!DOCTYPE html>
<html lang="en">
    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="<?= base_url('assets/'); ?>img/logo.png" rel="icon">
        <title><?= SITE_NAME; ?> - <?= $title; ?></title>
        <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/'); ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <style>
            @import url('https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap');
            *{
            padding: 0;
            margin: 0;
            outline: none;
            }
            body{
            font-family: 'Roboto', sans-serif !important;
            height:100vh;
            color: #3a3e42 !important;
            }
            .AppForm .AppFormLeft h1{
            font-size: 35px;
            }
            .AppForm .AppFormLeft input:focus{
            border-color: #ced4da;
            }
            .AppForm .AppFormLeft input::placeholder{
            font-size: 15px;
            }
            .AppForm .AppFormLeft i{
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            }
            .AppForm .AppFormLeft a{
            color: #3a3e42 ;
            }
            .AppForm .AppFormLeft button{
            background: linear-gradient(45deg,#330066,#001a66);
            border-radius: 30px;
            }
            .AppForm .AppFormLeft p span{
            color: #007bff;
            }
            .AppForm .AppFormRight{
            background-image: url('assets/img/bone.jpg');
            height: 450px;
            background-size: cover;
            background-position: center;
            }
            .AppForm .AppFormRight:after{
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg,#004040,#004d66);
            opacity: 0.5;
            }
            .AppForm .AppFormRight h2{
            z-index: 1;
            }
            .AppForm .AppFormRight h2::after{
            content: "";
            position: absolute;
            width: 100%;
            height: 2px;
            background-color: #fff;
            bottom: 0;
            left:50%;
            transform: translateX(-50%);
            }
            .AppForm .AppFormRight p{
            z-index: 1;
            }
        </style>
    </head>
    <body class="bg-gradient-login"> 
        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <form class="col-md-9 user" method="POST" action="<?=base_url();?>adm/index">
                    <div class="AppForm shadow-lg">
                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-center align-items-center">
                                <div class="col-md-10 AppFormLeft">
                                    <?php
                                        echo $this->session->flashdata('message');
                                    ?>
                                    <h1>Login</h1>
                                    <div class="form-group position-relative mb-4">
                                        <input type="text" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" name="email_user" id="email_user"
                                        placeholder="Email" required="">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="form-group position-relative mb-4">
                                        <input type="password" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" name="pass_user" id="pass_user"
                                        placeholder="Password" required="">
                                        <i class="fa fa-key"></i>
                                        
                                    </div>
                                    
                                    <button name='submit' type="submit" class="btn btn-success btn-block shadow border-0 py-2 text-uppercase ">
                                        Login
                                    </button>
                                    
                                    <p class="text-center mt-5" id="version-ruangadmin">
                                    </p>
                                    
                                </div>
                                
                                </div>
                            <div class="col-md-6">
                                <div class="AppFormRight position-relative d-flex justify-content-center flex-column align-items-center text-center p-5 text-white">
                                    <h2 class="position-relative px-4 pb-3 mb-4">Selamat Datang</h2>
                                    <?=info()['ket'];?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
        <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
        <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
    </body>
    
</html>